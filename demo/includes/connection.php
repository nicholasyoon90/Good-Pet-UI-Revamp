<?php
require("constants.php");

// 1. Create a database connection
/*$connection = mysql_connect(DB_SERVER,DB_USER,DB_PASS);
if (!$connection) {
	die("Database connection failed: " . mysql_error());
}

// 2. Select a database to use 
$db_select = mysql_select_db(DB_NAME,$connection);
if (!$db_select) {
	die("Database selection failed: " . mysql_error());
}

/*try{
	$connection = new PDO("mysql:host=localhost;dbname=ProjectPet", DB_USER, DB_PASS);
}
catch(PDOException $e){
	echo $e->getMessage();
}
*/
$connection = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
if (!$connection) {
	die('Database connection failed: (' . mysqli_connect_errno() . ')' . mysqli_connect_error());
}
?>
