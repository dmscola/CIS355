<?php 
	
	require 'database.php';

	$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
		if ( null==$id ) {
		header("Location: login.php");
	}
	
		if ( !empty($_POST)) {
		// keep track validation errors
		$dateError = null;
		$timeError = null;
		$locationError = null;
		$descriptionError = null;
		
		// keep track post values
		$event_date = $_POST['event_date'];
		$event_time = $_POST['event_time'];
		$event_location = $_POST['event_location'];
		$event_description = $_POST['event_description'];
		
		echo $date . $time . $location . $description;
		// validate input
		$valid = true;
		if (empty($event_date)) {
			$dateError = 'Please enter Date';
			$valid = false;
		}
		
		if (empty($event_time)) {
			$timeError = 'Please enter time';
			$valid = false;
		} 
		
		if (empty($event_location)) {
			$locationError = 'Please enter location';
			$valid = false;
		}
				if (empty($event_description)) {
			$descriptionError = 'Please enter description';
			$valid = false;
		}


		}
		
		// update data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE events  set event_date = ?, event_location = ?, event_description =?, event_time= ? WHERE id = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($event_date,$event_description,$event_location, $event_time, $id));
			Database::disconnect();
			header("Location: events.php");
		}
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM events where id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		$event_date = $data['event_date'];
		$event_description = $data['event_description'];
		$event_location = $data['event_location'];
		$event_time = $data['event_time'];
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
    		
	    			<form class="form-horizontal" action="update_event.php?id=<?php echo $id?>" method="post">
					  <div class="control-group <?php echo !empty($dateError)?'error':'';?>">
					    <label class="control-label">Event Date</label>
					    <div class="controls">
					      	<input name="event_date" type="text"  placeholder="Event_date" value="<?php echo !empty($event_date)?$event_date:'';?>">
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
					    <label class="control-label">event_description </label>
					    <div class="controls">
					      	<input name="event_description" type="text"  placeholder="event_description " value="<?php echo !empty($event_description)?$event_description:'';?>">
					      	<?php if (!empty($descriptionError)): ?>
					      		<span class="help-inline"><?php echo $descriptionError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					 	  <div class="control-group <?php echo !empty($timeError)?'error':'';?>">
					    <label class="control-label">Event Time </label>
					    <div class="controls">
					      	<input name="event_time" type="text"  placeholder="event_time " value="<?php echo !empty($event_time)?$event_time:'';?>">
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