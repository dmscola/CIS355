<?php

class Customers 
{
	

	
	public function displayTableContents()
	{
							   $pdo = Database::connect();
					   $sql = 'SELECT * FROM customers ORDER BY id DESC';
	 				   foreach ($pdo->query($sql) as $row) {
						   		echo '<tr>';
							   	echo '<td>'. $row['name'] . '</td>';
							   	echo '<td>'. $row['email'] . '</td>';
							   	echo '<td>'. $row['mobile'] . '</td>';
							   	echo '<td width=250>';
							   	echo '<a class="btn" href="read_customer.php?id='.$row['id'].'">Read</a>';
							   	echo '&nbsp;';
							   	echo '<a class="btn btn-success" href="update.php?id='.$row['id'].'">Update</a>';
							   	echo '&nbsp;';
							   	echo '<a class="btn btn-danger" href="delete.php?id='.$row['id'].'">Delete</a>';
							   	echo '</td>';
							   	echo '</tr>';
					   }
					   Database::disconnect();
					  
	}
	
	public function displayListHeading()
	{
		echo '<body> <div class="container"> <div class="row"> <h3>Customers</h3> </div><div class="row"><p><a href="create.php" class="btn btn-success">Create</a></p><table class="table table-striped table-bordered"> <thead> <tr> <th>Name</th> <th>Email Address</th> <th>Mobile Number</th> <th>Action</th> </tr></thead> <tbody>';
		
	}
	
	public function importBootstrap()
	{
		echo '<!DOCTYPE html><html lang="en"><head> <meta charset="utf-8"> <link href="css/bootstrap.min.css" rel="stylesheet"> <script src="js/bootstrap.min.js"></script></head>';
	}
	
	public function displayListFooting()
	{
		echo  "</tbody> </table> </div></div></body></html>";
	}
	
	
	public function navbar()
	{
		print "<head>\n";
print "<style>\n";
print "ul {\n";
print "    list-style-type: none;\n";
print "    margin: 0;\n";
print "    padding: 0;\n";
print "    overflow: hidden;\n";
print "    background-color: #333;\n";
print "}\n";
print "\n";
print "li {\n";
print "    float: left;\n";
print "}\n";
print "\n";
print "li a {\n";
print "    display: block;\n";
print "    color: white;\n";
print "    text-align: center;\n";
print "    padding: 14px 16px;\n";
print "    text-decoration: none;\n";
print "}\n";
print "\n";
print "li a:hover {\n";
print "    background-color: #111;\n";
print "}\n";
print "</style>\n";
print "</head>\n";
print "<body>\n";
print "\n";
print "<ul>\n";
echo '<li><a href="assignments_view_1.php?id='.$sessionid.'">Assignments</a></li>\n';
print "  <li><a href=\"events.php\">Events</a></li>\n";
print "  <li><a href=\"customers_view.php\">Customers</a></li>\n";
print "</ul>\n";
print "\n";
print "</body>\n";
print "</html>";

	}
	public function displayListScreen()
	{



	}
}
?>