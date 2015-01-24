<?php

	// Get all folders
	function query($parent_id) {
		global $user, $conn;
		$sql = "SELECT * FROM $user WHERE parent_id=$parent_id ORDER BY parent_id,name";
		$structure_query = $conn->prepare($sql);
		$structure_query->execute();
		return $structure_query->fetchAll(PDO::FETCH_ASSOC);
	}

	// Loop through all the folders (and print)
	function loopDB($array,$level,$type) {

		$return = ($type == "option") ? "" : null;
	
		// Loop through nested folders
		foreach($array as $folder) {
		
			// Formatting the printing
			if($type == "option") {
				$return .= "<option value=\"" . $folder["id"] . "\">";
				for($i=0; $i<$level; $i++)
					$return .= "&nbsp;&nbsp;";
				if($folder["id"] != 1)
					$return .= "&rdsh; ";
				$return .= $folder["name"];
				$return .= "</option>";
			} else {
				//$type[$level][] = $folder["name"];
				$type[$folder["id"]] = $level;
			}
			
			// Go through further nested folders
			$return .= loopDB(query($folder["id"]),$level+1,$type);
		}
		
		return $return;
	}
	
?>