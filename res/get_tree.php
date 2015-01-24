<?php
	
	// Make sure user is signed in
	// Make sure $_GET["id"] is set
	// Make sure $_GET["nested"] is set
	session_start();
	if(
		!isset($_SESSION["user"]) ||
		!isset($_GET["id"]) ||
		!is_numeric($_GET["id"]) ||
		!isset($_GET["nested"]) ||
		($_GET["nested"] != "true" && $_GET["nested"] != "false")
	) {
		header("Location: ../index.php");
		exit();
	}
	$user = $_SESSION["user"];
	$id = $_GET["id"];
	$nested = ($_GET["nested"] == "true") ? true : false;
	
	// Load notes
	include "../ver/server.php";
	try {
		// Get notes and note structures
		$note = new PDO("mysql:host=$servername;dbname=nobr_note",$username,$password);
		$note->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		$conn = new PDO("mysql:host=$servername;dbname=nobr_folder",$username,$password);
		$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		
		// Print "cookie crumb trail" for navigational ease
		$parent_id = $id;
		$crumb_trail = "";
		while(true) {
			$trail_query = $note->prepare("SELECT * FROM nobr_folder.$user WHERE id=$parent_id");
			$trail_query->execute();
			$trail = $trail_query->fetch(PDO::FETCH_ASSOC);
			$crumb_trail = $trail["name"] . " > " . $crumb_trail;
			$parent_id = $trail["parent_id"];
			if($parent_id == 0)
				break;
		}
		echo $crumb_trail . "<br /><br />";
		
		// Print notes and note structures
		if($nested) {
			include "../res/loopDB.php";
			
			$notes_query = $note->prepare("SELECT * FROM $user WHERE folder_id=$id");
			$notes_query->execute();
			$notes = $notes_query->fetchAll(PDO::FETCH_ASSOC);
			foreach($notes as $a_note)
				echo $a_note["content"] . "<br />";
			if(gettype($array = loopDB(query($id),0)) == "array")
				foreach($array as $folder) {
					$notes_query = $note->prepare("SELECT * FROM $user WHERE folder_id=" . $folder[0]);
					$notes_query->execute();
					$notes = $notes_query->fetchAll(PDO::FETCH_ASSOC);
					foreach($notes as $a_note) {
						for($i=0;$i<$folder[2]+1;$i++)
							echo "&nbsp;&nbsp;&nbsp;&nbsp;";
						echo $folder[1] . ": " . $a_note["content"] . "<br />";
					}
				}
		} else {
			$structure_query = $note->prepare("SELECT * FROM $user FULL JOIN nobr_folder.$user ON nobr_folder.$user.id=folder_id WHERE folder_id=$id");
			$structure_query->execute();
			$structure = $structure_query->fetchAll(PDO::FETCH_ASSOC);
			foreach($structure as $note)
				echo $note["content"] . "<br />";
		}
	} catch(PDOException $e) {
		echo $e;
		//header("Location: ../ver/error.php?err=pdoexception&msg=" . str_replace("\n"," ",$e));
		exit();
	}
		
?>