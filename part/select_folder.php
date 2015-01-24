<?php
	
	// Get folder structure from database
	include "ver/server.php";
	try {
		$conn = new PDO("mysql:host=$servername;dbname=nobr_folder",$username,$password);
		$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		
		// Start loop with "root" folder
		include "res/loopDB.php";
		echo loopDB(query(0),0,"option");
			
	} catch(PDOException $e) {
		header("Location: ver/error.php?err=pdoexception?msg=" . str_replace("\n"," ",$e));
		exit();
	}

?>