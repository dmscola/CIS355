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

		              <?php 

include 'database.php';
include 'customers.php';

	Customers::navbar();
	Customers::displayListHeading();
	Customers::displayTableContents();
	customers::importBootstrap();
	Customers::displayListFooting();

					  ?>
				      </tbody>
	            </table>
    	</div>
   
  </body>
</html>