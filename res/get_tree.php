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
			if($first) {
				$crumb_trail = $trail["name"] . " > " . $crumb_trail;
				$first = false;
			} else
				$crumb_trail = "<button onclick=\"select(" . $trail["id"] . ")\">" . $trail["name"] . "</button> > " . $crumb_trail;
			$parent_id = $trail["parent_id"];
			if($parent_id == 0)
				break;
		}
		echo $crumb_trail . "<br /><br />";
		
		// Create table
?>
	<table>
		<thead>
			<tr>
				<?php if($nested) echo "<th>Folder</th>"; ?>
				<th>Note</th>
				<th>Delete?</th>
			</tr>
		</thead>
		<tbody>
<?php
		// Print notes and note structures
		include "../res/loopDB.php";
		$notes = get($note,"SELECT * FROM $user WHERE folder_id=$id");
		$folder_td = ($nested) ? "<td><br /></td>" : "";
		foreach($notes as $a_note)
			echo "<tr id=\"" . $a_note["id"] . "\">$folder_td<td>" . $a_note["content"] . "</td><td><button onclick=\"delete(" . $a_note["id"] . ")\">Delete</button></td></tr>";
		
		if($nested) {
			// Print nested structures
			if(gettype($array = loopDB(query($id),0)) == "array")
				foreach($array as $folder) {
					$notes = get($note,"SELECT * FROM $user WHERE folder_id=" . $folder[0]);
					foreach($notes as $a_note) {
						for($i=0;$i<$folder[2]+1;$i++)
							echo "&nbsp;&nbsp;&nbsp;&nbsp;";
						echo "<tr id=\"" . $a_note["id"] . "\"><td>" . $folder[1] . "</td><td>" . $a_note["content"] . "</td><td><button onclick=\"delete(" . $a_note["id"] . ")\">Delete</button></td></tr>";
					}
				}
		}
		
?>
	
		</tbody>
		<tfoot>
			<tr>
				<?php if($nested) echo "<th>Folder</th>"; ?>
				<th>Note</th>
				<th>Delete?</th>
			</tr>
		</tfoot>
	</table>
	
<?php
	} catch(PDOException $e) {
		header("Location: ../ver/error.php?err=pdoexception&msg=" . str_replace("\n"," ",$e));
		exit();
	}
		
?>