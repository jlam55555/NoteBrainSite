<?php

	include "tools.php";

	// Make sure a user is signed in (if not, redirect)
	session_start();
	if(
		!isset($_SESSION["user"]) ||
		!isset($_POST["folder_id"]) ||
		!check($_POST["folder_id"],1,5,"integer") ||
		!isset($_POST["type"]) ||
		($_POST["type"] != "note" && $_POST["type"] != "folder")
	) {
		header("Location: ../index.php");
		exit();
	}
	
	// Make sure a note is typed and the appropriate length and it is text
	if(!isset($_POST["note"]) || ($note = tidy($_POST["note"],null,true)) == "" || !check($note,3,500,"text")) {
		header("Location: error.php?err=note1");
		exit();
	}
	
	$user = $_SESSION["user"];
	$folder_id = $_POST["folder_id"];
	include "server.php";
	if($_POST["type"] == "note") {
		// Add it to database
		try {
			$conn = new PDO("mysql:host=$servername;dbname=nobr_note", $username, $password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$conn->exec("INSERT INTO $user(content,folder_id) VALUES('$note',$folder_id)");
		} catch(PDOException $e) {
			header("Location: error.php?err=pdoexception&msg=" . str_replace("\n"," ",$e));
			exit();
		}
	} else {
		try {
			$conn = new PDO("mysql:host=$servername;dbname=nobr_folder", $username, $password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$conn->exec("INSERT INTO $user(name,parent_id) VALUES('$note',$folder_id)");
			echo $conn->lastInsertId();
		} catch(PDOException $e) {
			header("Location: error.php?err=pdoexception&msg=" . str_replace("\n"," ",$e));
			exit();
		}
	}
	
?>