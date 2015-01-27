<?php

	// Delete a note
	
	// Check if user is signed in and id is given
	include "tools.php";
	session_start();
	if(!isset($_SESSION["user"]) || !isset($_POST["id"]) || !check($_POST["id"],1,5,"integer")) {
		header("../index.php");
		exit();
	}
	$user = $_SESSION["user"];
	$id = $_POST["id"];
	
	// Connect to database
	include "server.php";
	try {
		$conn = new PDO("mysql:host=$servername;dbname=nobr_note",$username,$password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		$conn->exec("DELETE FROM $user WHERE id=$id");
	} catch(PDOException $e) {
		echo $e;
		exit();
	}

?>