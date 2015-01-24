<?php

	// Get all folders
	function query($parent_id) {
		global $user, $conn;
		$sql = "SELECT * FROM $user WHERE parent_id=$parent_id ORDER BY parent_id,name";
		$structure_query = $conn->prepare($sql);
		$structure_query->execute();
		return $structure_query->fetchAll(PDO::FETCH_ASSOC);
	}
	
	// Loop through the DB folders and return an array
	function loopDB($array,$level) {
	
		$return = null;
	
		// Loop through nested folders
		foreach($array as $folder) {
		
			// Add the folder and level
			$return[] = array($folder["id"],$folder["name"],$level);
			
			// Go through further nested folders, merge it with $return
			if(($new = loopDB(query($folder["id"]),$level+1)) != null)
				$return = array_merge($return,loopDB(query($folder["id"]),$level+1));
			
		}
		
		return $return;
	}
	
?>