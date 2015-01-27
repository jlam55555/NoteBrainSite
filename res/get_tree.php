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
	include "../ver/tools.php";
	try {
		// Get notes and note structures
		$note = new PDO("mysql:host=$servername;dbname=nobr_note",$username,$password);
		$note->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		$conn = new PDO("mysql:host=$servername;dbname=nobr_folder",$username,$password);
		$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		
		// Print "cookie crumb trail" for navigational ease
		$parent_id = $id;
		$crumb_trail = "";
		$first = true;
		while(true) {
			$trail = get($note,"SELECT * FROM nobr_folder.$user WHERE id=$parent_id",false);
			if($first)
				$crumb_trail = $trail["id"] . " > " . $crumb_trail;
			else
				$crumb_trail = "<button onclick=\"select(" . $trail["id"] . ")\">" . $trail["name"] . "</button> > " . $crumb_trail;
			$parent_id = $trail["parent_id"];
			if($parent_id == 0)
				break;
		}
		echo $crumb_trail . "<br /><br />";
		
		// Print notes and note structures
		if($nested) {
			include "../res/loopDB.php";
			$notes = get($note,"SELECT * FROM $user WHERE folder_id=$id");
			foreach($notes as $a_note)
				echo $a_note["content"] . "<br />";
			if(gettype($array = loopDB(query($id),0)) == "array")
				foreach($array as $folder) {
					$notes = get($note,"SELECT * FROM $user WHERE folder_id=" . $folder[0]);
					foreach($notes as $a_note) {
						for($i=0;$i<$folder[2]+1;$i++)
							echo "&nbsp;&nbsp;&nbsp;&nbsp;";
						echo "<b>" . $folder[1] . "</b>: " . $a_note["content"] . "<br />";
					}
				}
		} else {
			foreach(get($note,"SELECT * FROM $user FULL JOIN nobr_folder.$user ON nobr_folder.$user.id=folder_id WHERE folder_id=$id") as $note)
				echo $note["content"] . "<br />";
		}
	} catch(PDOException $e) {
		echo $e;
		//header("Location: ../ver/error.php?err=pdoexception&msg=" . str_replace("\n"," ",$e));
		exit();
	}
		
?>