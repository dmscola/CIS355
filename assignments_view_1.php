<?php 

$id = $_GET['id']; 
$sessionid = $_SESSION['fr_person_id'];

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
	
		<div class="row">
			<h3><?php if($id) echo 'ID = '; echo $id; ?></h3>
		</div>
		
		<div class="row">
			<p>Here is a list of all of your assignments.</p>
			<p>
				<?php if($_SESSION['fr_person_title']=='Administrator')
					echo '<a href="fr_assign_create.php" class="btn btn-primary">Add Assignment</a>';
				?>
				<a href="logout.php" class="btn btn-warning">Logout</a> &nbsp;&nbsp;&nbsp;
				<?php if($_SESSION['fr_person_title']=='Administrator')
					echo '<a href="fr_persons.php">Volunteers</a> &nbsp;';
				?>
				<a href="events.php">All Events</a> &nbsp;
				<?php if($_SESSION['fr_person_title']=='Administrator')
					echo '<a href="fr_assignments.php">AllShifts</a>&nbsp;';
				?>
				<a href="assignments_view_1.php?id=<?php echo $sessionid; ?>">My Assignments</a>&nbsp;
				<?php if($_SESSION['fr_person_title']=='Volunteer')
					echo '<a href="fr_events.php" class="btn btn-primary">Volunteer</a>';
				?>
			</p>
			
			<table class="table table-striped table-bordered" style="background-color: pink !important">
				<thead>
					<tr>
						<th>Name</th>
						<th>Description</th>
						<th>Event</th>
						<th>Customer</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
				<?php 
					include 'database.php';
					include 'functions.php';
					$pdo = Database::connect();
					
					if($id) 
						$sql = "SELECT * FROM Assignments 
						LEFT JOIN customers ON customers.id = Assignments.assignment_customer_id 
						LEFT JOIN events ON events.id = Assignments.assignment_event_id
						WHERE customer.id = $id 
						ORDER BY assignment_event_id ASC;";
					else
						$sql = "SELECT * FROM Assignments 
						LEFT JOIN customers ON customers.id = Assignments.assignment_customer_id 
						LEFT JOIN events ON events.id = Assignments.assignment_event_id
						ORDER BY assignment_event_id ASC;";

					foreach ($pdo->query($sql) as $row) {
						echo '<tr>';
						echo '<td>'. $row['assignment_name'] . '</td>';
						echo '<td>'. $row['assignment_description'] . '</td>';
						echo '<td width=250>';
						# use $row[0] because there are 3 fields called "id"
						echo '<a class="btn" href="fr_assign_read.php?id='.$row[0].'">Details</a>';
						if ($_SESSION['fr_person_title']=='Administrator' )
							echo '&nbsp;<a class="btn btn-success" href="fr_assign_update.php?id='.$row[0].'">Update</a>';
						if ($_SESSION['fr_person_title']=='Administrator' 
							|| $_SESSION['fr_person_id']==$row['assign_per_id'])
							echo '&nbsp;<a class="btn btn-danger" href="fr_assign_delete.php?id='.$row[0].'">Delete</a>';
						if($_SESSION["fr_person_id"] == $row['assign_per_id']) 		echo " &nbsp;&nbsp;Me";
						echo '</td>';
						echo '</tr>';
					}
					Database::disconnect();
				?>
				</tbody>
			</table>
    	</div>

    </div> <!-- end div: class="container" -->
	
</body>
</html>