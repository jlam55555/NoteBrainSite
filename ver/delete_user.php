<?php

	// Check for password, and user signed in
	session_start();
	if(!isset($_SESSION["user"]) || !isset($_POST["pass"]))
		exit();
		
	// Check if password is the same one as in the database
	$user = $_SESSION["user"];
	include "server.php";
	include "tools.php";
	try {
		$conn = new PDO("mysql:host=$servername;dbname=nobr_user",$username,$password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		$data = get($conn,"SELECT pass FROM user_data WHERE user='$user'",false);
		if(password_verify($_POST["pass"],$data["pass"]))
			echo "true";
		else {
			echo "false";
			exit();
		}
		
		$conn->exec("DELETE FROM user_data WHERE user='$user'");
		$conn->exec("DROP TABLE nobr_note.$user");
		$conn->exec("DROP TABLE nobr_folder.$user");
	} catch(PDOException $e) {
		exit();
	}

?>