<?php
	
	// Check if user is already signed in (if so, redirect)
	session_start();
	if(isset($_SESSION["user"])) {
		header("Location: ../index.php");
		exit();
	}
	
	// Check that user data is submitted
	if(!isset($_POST["user"]) || !isset($_POST["pass"])) {
		header("Location: error.php?err=signin1");
		exit();
	}
	
	$user = $_POST["user"];
	$pass = $_POST["pass"];
	
	// Get server data
	include "server.php";
	
	// Check that user exists.
	try {
		$conn = new PDO("mysql:host=$servername;dbname=nobr_user",$username,$password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		// Find users
		$user_query = $conn->prepare("SELECT * FROM user_data WHERE user='$user'");
		$user_query->execute();
		$user_data = $user_query->fetch(PDO::FETCH_ASSOC);
		
		// If no user is found, redirect to error page
		if($user_data == null) {
			header("Location: error.php?err=signin2");
			exit();
		}
		
		// Check password
		$hash_pass = $user_data["pass"];
		if(!password_verify($pass,$hash_pass)) {
			header("Location: error.php?err=signin3");
			exit();
		}		
	} catch(PDOException $e) {
		header("Location: error.php?err=pdoexception&msg=" . str_replace("\n"," ",$e));
		exit();
	}
	
	// Sign in and redirect
	$_SESSION["user"] = $user;
	header("Location: ../index.php");
	
?>