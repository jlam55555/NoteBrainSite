<?php

	include "tools.php";

	// Make sure a user is signed in (if not, redirect)
	session_start();
	if(!isset($_SESSION["user"])) {// || !isset($_POST["folder_id"]) || !check($_POST["folder_id"]),1,5,"integer")) {
		header("Location: ../index.php");
		exit();
	}
	$user = $_SESSION["user"];
	$folder_id = $_POST["folder_id"];
	
	// Make sure a note is typed and the appropriate length
	if(!isset($_POST["note"]) || ($note = tidy($_POST["note"],null,true)) == "" || !check($note,3,500,"text")) {
		header("Location: error.php?err=note1");
		exit();
	}
	
	// Add it to database
	include "server.php";
	try {
		$conn = new PDO("mysql:host=$servername;dbname=nobr_note", $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$conn->exec("INSERT INTO $user(content,folder_id) VALUES('$note',$folder_id)");
	} catch(PDOException $e) {
		header("Location: error.php?err=pdoexception&msg=" . str_replace("\n"," ",$e));
		exit();
	}
		
?>