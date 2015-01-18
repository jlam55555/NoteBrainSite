<?php

// To use this project, change the values to match your server, username, and password.
// Run this every time you update this project for the latest database structure (this will wipe out

// Get server data (edit it at "../ver/server.php")
include "../ver/server.php";

try {
	// Create databases "user.data" and "user.note"
	$conn = new PDO("mysql:host=$servername", $username, $password);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	// Delete databases if they already exist
	$chck = $conn->prepare("SELECT schema_name FROM information_schema.schemata WHERE schema_name='nobr_user' OR schema_name='nobr_note'");
	$chck->execute();
	if($chck->fetch(PDO::FETCH_ASSOC) !== false) {
		$conn->exec("DROP DATABASE nobr_user");
		$conn->exec("DROP DATABASE nobr_note");
	}
	$conn->exec("CREATE DATABASE nobr_user");
	$conn->exec("CREATE DATABASE nobr_note");
	
	// Create the user table
	$conn = new PDO("mysql:host=$servername;dbname=nobr_user", $username, $password);
	$conn->exec("CREATE TABLE user_data(first_name CHAR(50),last_name CHAR(50),email CHAR(50),user CHAR(50) PRIMARY KEY,pass CHAR(255))");
} catch(PDOException $e) {
	echo $e->getMessage();
}
$conn = null;

// Sign user out (if already signed in)
session_start();
session_destroy();

// Delete XML for note structures if any users are signed up
$dirHandle = opendir("../user/notes/"); 
while($file = readdir($dirHandle))
	if(!is_dir($file))
		unlink("../user/notes/$file");
closedir($dirHandle); 

header("Location: ../index.php");

?>