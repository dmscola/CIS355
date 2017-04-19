<?php
session_start();
if(!isset($_SESSION["id"])){ // if "user" not set,
	session_destroy();
	header('Location: login.php');     // go to login page
	exit;
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
    		<div class="row">
    			<h3>Main Page</h3>
    		</div>
			<div class="row">
				<p>
					<a href="customers_view.php" class="btn btn-success">Customers</a>
				</p>
				
			<div class="row">
				<p>
					<a href="events.php" class="btn btn-success">Events</a>
				</p>
				</div>
			<div class="row">
				<p>
					<a href="assignments.php" class="btn btn-success">Assignments</a>
				</p>
				</div>
    	</div>
   
  </body>
</html>