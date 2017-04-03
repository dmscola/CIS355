<?php 
session_start();
print_r($_SESSION)
if (isempty($_SESSION)['userid']))
	echo 'user not set'; exit();

function login()
{
	echo '<form action = "demo_from.php"?';
	echo '<p>Username (email):';
	echo '<input type = "text" name = "email"><br>';
	echo '<p>Password:';
	echo '<input type = "password" name = "password"><br>';
	echo '<input type ="submit" value= "Submit">';
	echo '</form>';
}

include 'database.php';
include 'customers.php';
	Customers::displayListHeading();
	Customers::displayTableContents();
	Customers::importBootstrap();
	Customers::displayListFooting();
?>
