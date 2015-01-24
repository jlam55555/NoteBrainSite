<?php
	
	// This creates the OPTIONS for a select that shows all the folders. (It doesn't create the select itself).
	
	// Get folder structure from database
	include "ver/server.php";
	try {
		$conn = new PDO("mysql:host=$servername;dbname=nobr_folder",$username,$password);
		$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		
		// Start loop with "root" folder
		include "res/loopDB.php";
		foreach(loopDB(query(0),0) as $folder) {
		
			// Format printing to <option>"
			echo "<option value=\"" . $folder[0] . "\">";
			for($i=0; $i<$folder[2]; $i++)
				echo "&nbsp;&nbsp;";
			if($folder[0] != 1)
				echo "&rdsh; ";
			echo $folder[1];
			echo "</option>";
		}
			
	} catch(PDOException $e) {
		header("Location: ver/error.php?err=pdoexception?msg=" . str_replace("\n"," ",$e));
		exit();
	}

?>