<?php

// To use this project, change the values to match your server, username, and password.
// Run this every time you update this project for the latest database structure (this will wipe out

// Set these to the values for your server. Actual values are hidden for security reasons. If you use this section, delete the following section.
$servername = "localhost";	// servername (change this)
$username = "root";			// username (change this)
$password = "";				// password (change this)

// These are my values (stored in a non-server file). Delete this section if you modified the values above, or, store your server data in a similar way by creating a file named "servdata.txt" with the three comma-separated values.
$hndl = fopen("../../servdata.txt","r");
$rval = explode(",",fread($hndl,2048));
fclose($hndl);
$servername = $rval[0];
$username = $rval[1];
$password = $rval[2];

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
	echo "Databases refreshed/created successfully<br>";
	
	// Create the user table
	$conn = new PDO("mysql:host=$servername;dbname=nobr_user", $username, $password);
	$conn->exec("CREATE TABLE user_data(first_name CHAR(50),last_name CHAR(50),email CHAR(50),user CHAR(50) PRIMARY KEY,pass CHAR(50))");
	echo "Table refreshed/created successfully<br>";
} catch(PDOException $e) {
	echo $e->getMessage();
}
$conn = null;

?>