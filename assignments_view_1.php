<?php 

session_start();
if(!isset($_SESSION["id"])){ // if "user" not set,
	session_destroy();
	header('Location: login.php');     // go to login page
	exit;
}
 $id = $_GET['id']; 
$sessionid = $_SESSION['id'];

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
	<link rel="icon" href="../cardinal_logo.png" type="image/png" />
</head>

<?php
include 'customers.php';

	Customers::navbar();
	?>

<body>
    <div class="container">
	
	<h1>
	View All Assignments
	</h1>
		
		<div class="row">

			<p>
				<?php 
					echo '&nbsp;<a class="btn btn-success" href="assignments_view_1.php?id='.$sessionid.'">My Assignments</a>';
				?>
				<?php 
					echo '<a href="fr_assign_create.php" class="btn btn-primary">Add Assignment</a>';
				?>
				<a href="logout.php" class="btn btn-warning">Logout</a> &nbsp;&nbsp;&nbsp;
				<?php 
					echo '<a href="customers_view.php">All Customers</a> &nbsp;';
				?>
				<a href="events.php">All Events</a> &nbsp;
				<?php 
					echo '<a href="assignments_view_1.php">All Assignments</a>&nbsp;';
					echo '&nbsp;<a class="btn btn-success" href="update_me.php?id='.$sessionid.'">Update my Profile</a>';
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
						WHERE customers.id = $id 
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
						echo '<td>'. $row['event_description'] . '</td>';
						echo '<td>'. $row['name'] . '</td>';
						echo '<td width=250>';
						# use $row[0] because there are 3 fields called "id"
						echo '<a class="btn" href="assignment_read.php?id='.$row[0].'">Details</a>';

							echo '&nbsp;<a class="btn btn-success" href="update_assignment_1.php?id='.$row[0].'">Update</a>';

							echo '&nbsp;<a class="btn btn-danger" href="assignment_delete.php?id='.$row[0].'">Delete</a>';
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