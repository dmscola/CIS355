

<?php 
include 'database.php';
$pdo = Database::connect();

if($GET['id']) $sql = "SELECT * from customers WHERE id =" . $_GET['id'];
	else
		$sql = "SELECT * from customers";

		$arr = array();
		
foreach ($pdo->query($sql) as $row) {
	array_push($arr, $row['name'] . ", ". $row['mobile']);

}
Database::disconnect();
//print_r($arr);

echo '{"names":' . json_encode($arr) . '}';


?>
