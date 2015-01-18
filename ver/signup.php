<?php

	// Check if session is set (user is logged in).
	if(!isset($_SESSION))
		session_start();
	else
		header("Location: ../index.php");
	
	// Check if $_POST is set
	if(!isset($_POST))
		header("Location: error.php?err=signup1");
	$p = $_POST;
	include "tools.php";
	$first_name = tidy($p["fnam"],false,true);
	$last_name = tidy($p["lnam"],false,true);
	$email = tidy($p["mail"],false,true);
	$user = tidy($p["user"],false,true);
	$pass1 = tidy($p["pas1"],false,true);
	$pass2 = tidy($p["pas2"],false,true);
	
	// Check that passwords match
	if($pass1 !== $pass2)
		header("Location: error.php?err=signup2");
			
	// Check each value
	if(
		!check($first_name,2,50,"plain") ||
		!check($last_name,2,50,"plain") ||
		!check($email,2,50,"email") ||
		!check($user,2,50,"user") ||
		!check($pass1,2,50,"user")
	) {
		header("Location: error.php?err=signup3");
		exit();
	}
	
	// Get server data
	include "server.php";
	
	// Check that no users already have the username
	try {
		$conn = new PDO("mysql:host=$servername;dbname=nobr_user", $username, $password);;
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$users = $conn->prepare("SELECT * FROM user_data WHERE user='$user'");
		$users->execute();
		if($users->fetch(PDO::FETCH_ASSOC) !== false) {
			header("Location: error.php?err=signup4");
			exit();
		}
		
		// Create secure password hash
		$hash = password_hash($pass1,PASSWORD_DEFAULT);
		
		// Create user
		$conn->exec("INSERT INTO user_data (first_name,last_name,email,user,pass) VALUES ('$first_name','$last_name','$email','$user','$hash')");
		
	} catch(PDOException $e) {
		echo $e->getMessage();	
	}
	
	// Create file to store note structure
	$xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?><structure></structure>";
	$file = fopen("../user/notes/$user.xml","x");
	fwrite($file,$xml);
	fclose($file);
	
	// Sign in and redirect
	$_SESSION["user"] = $user;
	header("Location: ../index.php");
?>