<?php 

session_start();
if(!isset($_SESSION["id"])){ // if "user" not set,
	session_destroy();
	header('Location: login.php');     // go to login page
	exit;
}
require 'database.php';
require 'functions.php';

$id = $_GET['id'];

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



if ( !empty($_POST)) {


	$personError = null;
	$eventError = null;
	
	// initialize $_POST variables
	$person = $_POST['id'];    // same as HTML name= attribute in put box
	$event = $_POST['event_id'];
	
	
	if ($valid) { // if valid user input update the database
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "UPDATE Assignments set assignment_customer_id = ?, assignment_event_id = ? WHERE assignment_id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($person,$event,$id));
		Database::disconnect();
		header("Location: assignments_view_1.php");
	}
} else { // if $_POST NOT filled then pre-populate the form
	$pdo = Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql = "SELECT * FROM Assignments where assignment_id = ?";
	$q = $pdo->prepare($sql);
	$q->execute(array($id));
	$data = $q->fetch(PDO::FETCH_ASSOC);
	$person = $data['assignment_customer_id'];
	$event = $data['assignment_event_id'];
	Database::disconnect();
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
</head>


<body>
    <div class="container">

		<div class="span10 offset1">
		
			<div class="row">
				<h3>Update Assignment</h3>
			</div>
	
			<form class="form-horizontal" action="update_assignment_1.php?id=<?php echo $id?>" method="post">
					  
					  <div class="control-group <?php echo !empty($nameError)?'error':'';?>">
					    <label class="control-label">Assignment Name</label>
					    <div class="controls">
					      	<input name="assignment_name" type="text"  placeholder="name" value="<?php echo !empty($assignment_name)?$assignment_name:'';?>">
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
					<label class="control-label">Customers</label>
					<div class="controls">
						<?php
							$pdo = Database::connect();
							$sql = 'SELECT * FROM customers ORDER BY name ASC';
							echo "<select class='form-control' name='id' id='id'>";
							foreach ($pdo->query($sql) as $row) {
								if($row['id']==$person)
									echo "<option selected value='" . $row['id'] . " '> " . $row['name'] . ', ' .$row['mobile'] . "</option>";
								else
									echo "<option value='" . $row['id'] . " '> " . $row['name'] . ', ' .$row['mobile'] . "</option>";
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
							echo "<select class='form-control' name='event_id' id='event_id'>";
							foreach ($pdo->query($sql) as $row) {
								if($row['id']==$event) {
									echo "<option selected value='" . $row['id'] . " '> " . Functions::dayMonthDate($row['event_date']) . " (" . Functions::timeAmPm($row['event_time']) . ") - " . trim($row['event_description']) . " (" . trim($row['event_location']) . ") " . "</option>";
								}
								else {
									echo "<option value='" . $row['id'] . " '> " . Functions::dayMonthDate($row['event_date']) . " (" . Functions::timeAmPm($row['event_time']) . ") - " . trim($row['event_description']) . " (" . trim($row['event_location']) . ") " . "</option>";
								}
							}
							echo "</select>";
							Database::disconnect();
						?>
					</div>	<!-- end div: class="controls" -->
				</div> <!-- end div class="control-group" -->

				<div class="form-actions">
					<button type="submit" class="btn btn-success">Update</button>
					<a class="btn" href="assignments_view_1.php">Back</a>
				</div>
				
			</form>
			
		</div> <!-- end div: class="span10 offset1" -->
				
    </div> <!-- end div: class="container" -->

  </body>
</html>