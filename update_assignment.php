<?php 
	
	require 'database.php';

	$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
		if ( null==$id ) {
		header("Location: assignments_view_1.php");
	}
	

		if ( !empty($_POST)) {
		// keep track validation errors
		$dateError = null;
		$timeError = null;
		$locationError = null;
		$descriptionError = null;
		
		// keep track post values
		$assignment_description = $_POST['assignment_description'];
		$assignment_name = $_POST['assignment_name'];
		$assignment_event_id = $_POST['assignment_event_id'];
		$assignment_customer_id = $_POST['assignment_customer_id'];
		
		echo $date . $time . $location . $description;
		// validate input
		$valid = true;
		if (empty($assignment_description)) {
			$dateError = 'Please enter Date';
			$valid = false;
		}
		
		if (empty($assignment_customer_id)) {
			$timeError = 'Please enter time';
			$valid = false;
		} 
		
		if (empty($assignment_name)) {
			$locationError = 'Please enter location';
			$valid = false;
		}
				if (empty($assignment_event_id)) {
			$descriptionError = 'Please enter description';
			$valid = false;
		}


		}
		
		// update data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE Assignments  set assignment_description = ?, assignment_name = ?, assignment_event_id =?, assignment_customer_id= ? WHERE assignment_id = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($assignment_description,$assignment_event_id,$assignment_name, $assignment_customer_id, $assignment_id));
			Database::disconnect();
			header("Location: assignments_view_1.php");
		}
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM Assignments where id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		$assignment_description = $data['assignment_description'];
		$assignment_event_id = $data['assignment_event_id'];
		$assignment_name = $data['assignment_name'];
		$assignment_customer_id = $data['assignment_customer_id'];
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
		    			<h3>Update a Customer</h3>
		    		</div>
    		
	    			<form class="form-horizontal" action="update_assignment.php?id=<?php echo $id?>" method="post">
					  <div class="control-group <?php echo !empty($dateError)?'error':'';?>">
					    <label class="control-label">Event Date</label>
					    <div class="controls">
					      	<input name="assignment_description" type="text"  placeholder="assignment_description" value="<?php echo !empty($assignment_description)?$assignment_description:'';?>">
					      	<?php if (!empty($dateError)): ?>
					      		<span class="help-inline"><?php echo $dateError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($date_locationError)?'error':'';?>">
					    <label class="control-label">date_location </label>
					    <div class="controls">
					      	<input name="date_location" type="text" placeholder="date_location" value="<?php echo !empty($date_location)?$date_location:'';?>">
					      	<?php if (!empty($locationError)): ?>
					      		<span class="help-inline"><?php echo $locationError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($descriptionError)?'error':'';?>">
					    <label class="control-label">assignment_event_id </label>
					    <div class="controls">
					      	<input name="assignment_event_id" type="text"  placeholder="assignment_event_id " value="<?php echo !empty($assignment_event_id)?$assignment_event_id:'';?>">
					      	<?php if (!empty($descriptionError)): ?>
					      		<span class="help-inline"><?php echo $descriptionError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					 	  <div class="control-group <?php echo !empty($timeError)?'error':'';?>">
					    <label class="control-label">Event Time </label>
					    <div class="controls">
					      	<input name="assignment_customer_id" type="text"  placeholder="assignment_customer_id " value="<?php echo !empty($assignment_customer_id)?$assignment_customer_id:'';?>">
					      	<?php if (!empty($timeError)): ?>
					      		<span class="help-inline"><?php echo $timeError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Update</button>
						  <a class="btn" href="index.php">Back</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>