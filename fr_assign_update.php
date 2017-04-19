<?php 

 
 
session_start();
if(!isset($_SESSION["id"])){ // if "user" not set,
	session_destroy();
	header('Location: login.php');     // go to login page
	exit;
}

	$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
$personid = $_SESSION["id"];
$eventid = $_GET['event_id'];
$assignmentname = $_POST['assignment_name'];
$assignmentdescription = $_POST['assignment_description'];

		$nameError = null;
		$descriptionError = null;

						if (empty($assignmentdescription)) {
			$descriptionError = 'Please enter description';
			$valid = false;
		}
		
						if (empty($assignmentname)) {
			$nameError = 'Please enter name';
			$valid = false;
		}

include 'customers.php';

	Customers::navbar();


require 'database.php';
require 'functions.php';

if ( !empty($_POST)) {

	// initialize user input validation variables
	$personError = null;
	$eventError = null;
	
	// initialize $_POST variables
	$customer = $_POST['customer'];    // same as HTML name= attribute in put box
	$event = $_POST['event'];
	
	// validate user input
	$valid = true;
	if (empty($customer)) {
		$customerError = 'Please choose a customer';
		$valid = false;
	}
	if (empty($event)) {
		$eventError = 'Please choose an event';
		$valid = false;
	} 
		
	// Update data
	if ($valid) {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = " UPDATE Assignments set assignment_customer_id = ?,assignment_event_id = ?,assignment_name = ?,assignment_description = ? WHERE id =?" 
		
		$q = $pdo->prepare($sql);
		$q->execute(array($customer,$event, $assignmentname, $assignmentdescription,$id));
		Database::disconnect();
		header("Location: assignments_view_1.php");
	}
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
	<link rel="icon" href="../cardinal_logo.png" type="image/png" />
</head>

<body>
    <div class="container">
    
		<div class="span10 offset1">
		
			<div class="row">
				<h3>Add a New Assignment</h3>
			</div>
	
			<form class="form-horizontal" action="fr_assign_create.php" method="post">
		
		
					  <div class="control-group <?php echo !empty($nameError)?'error':'';?>">
					    <label class="control-label">Name</label>
					    <div class="controls">
					      	<input name="assignment_name" type="text"  placeholder="Name" value="<?php echo !empty($assignmentname)?$assignmentname:'';?>">
					      	<?php if (!empty($nameError)): ?>
					      		<span class="help-inline"><?php echo $nameError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($descriptionError)?'error':'';?>">
					    <label class="control-label">Description</label>
					    <div class="controls">
					      	<input name="assignment_description" type="text"  placeholder="Description" value="<?php echo !empty($assignmentdescription)?$assignmentdescription:'';?>">
					      	<?php if (!empty($descriptionError)): ?>
					      		<span class="help-inline"><?php echo $descriptionError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>					  
				<div class="control-group">
					<label class="control-label">Customer</label>
					<div class="controls">
						<?php
							$pdo = Database::connect();
							$sql = 'SELECT * FROM customers ORDER BY name ASC';
							echo "<select class='form-control' name='customer' id='person_id'>";
							if($eventid) // if $_GET exists restrict person options to logged in user
								foreach ($pdo->query($sql) as $row) {
									if($customerid==$row['id'])
										echo "<option value='" . $row['id'] . " '> " . $row['name'] . ', ' .$row['email'] . "</option>";
								}
							else
								foreach ($pdo->query($sql) as $row) {
									echo "<option value='" . $row['id'] . " '> " . $row['name'] . ', ' .$row['email'] . "</option>";
								}
							echo "</select>";
							Database::disconnect();
						?>
					</div>	<!-- end div: class="controls" -->
				</div> <!-- end div class="control-group" -->
			  
				<div class="control-group">
					<label class="control-label">Event</label>
					<div class="controls">
						<?php
							$pdo = Database::connect();
							$sql = 'SELECT * FROM events ORDER BY event_date ASC, event_time ASC';
							echo "<select class='form-control' name='event' id='event_id'>";
							if($eventid) // if $_GET exists restrict event options to selected event (from $_GET)
								foreach ($pdo->query($sql) as $row) {
									if($eventid==$row['id'])
									echo "<option value='" . $row['id'] . " '> " . Functions::dayMonthDate($row['event_date']) . " (" . Functions::timeAmPm($row['event_time']) . ") - " .
									trim($row['event_description']) . " (" . 
									trim($row['event_location']) . ") " .
									"</option>";
								}
							else
								foreach ($pdo->query($sql) as $row) {
									echo "<option value='" . $row['id'] . " '> " . Functions::dayMonthDate($row['event_date']) . " (" . Functions::timeAmPm($row['event_time']) . ") - " .
									trim($row['event_description']) . " (" . 
									trim($row['event_location']) . ") " .
									"</option>";
								}
								
							echo "</select>";
							Database::disconnect();
						?>
					</div>	<!-- end div: class="controls" -->
					
				</div> <!-- end div class="control-group" -->
				

				<div class="form-actions">
					<button type="submit" class="btn btn-success">Confirm</button>
						<a class="btn" href="fr_assignments.php">Back</a>
				</div>
				
			</form>
			
		</div> <!-- end div: class="span10 offset1" -->
				
    </div> <!-- end div: class="container" -->

  </body>
</html>