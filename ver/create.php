<?php

	// Make sure a user is signed in (if not, redirect)
	session_start();
	if(!isset($_SESSION["user"])) {
		header("Location: ../index.php");
		exit();
	}
	$user = $_SESSION["user"];
	
	// Make sure a note is typed and the appropriate length
	include "tools.php";
	if(!isset($_POST["note"]) || ($note = tidy($_POST["note"],null,true)) == "" || !check($note,3,500,"text")) {
		header("Location: error.php?err=note1");
		exit();
	}
	
	// Add it to database
	include "server.php";
	try {
		$conn = new PDO("mysql:host=$servername;dbname=nobr_note", $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$conn->exec("INSERT INTO $user(content,folder_id) VALUES('$note',0)");
	} catch(PDOException $e) {
		header("Location: error.php?err=pdoexception&msg=" . str_replace("\n"," ",$e));
		exit();
	}
	
	// Redirect to main
	header("Location: ../index.php");

?>