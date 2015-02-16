<?php
	// This document is to create a simple unity among the headers of any page. It includes the <head> and enclosing tags, as well as a header.
	function ini($title) {
		// Include "tools.php" for some convenient tools
		include $_SERVER["DOCUMENT_ROOT"] . "/NoteBrain/ver/tools.php";
		include $_SERVER["DOCUMENT_ROOT"] . "/NoteBrain/ver/server.php";
		
		// Get user details if user is logged in
		session_start();
		if(isset($_SESSION["user"])) {
			$user = $_SESSION["user"];
			try {
				$conn = new PDO("mysql:host=$servername;dbname=nobr_user",$username,$password);
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$data = get($conn,"SELECT first_name,last_name,email FROM user_data WHERE user='$user'",false);
				$first_name = $data["first_name"];
				$last_name = $data["last_name"];
			} catch(PDOException $e) {
				header("ver/error.php?err=PDOException&msg=$e");
				exit();
			}
			$user_details = "<div id=\"user_det\">" . $_SESSION["user"] . "<br />$first_name $last_name<br /><a href=\"/notebrain/res/signout.php\">Sign Out</a> | <a href=\"/notebrain/ver/delete_user.php\" onclick=\"del_user();return false;\">Delete User</a></div>";
		} else
			$user_details = "";
?>
<!doctype html>
<html>
	<head>
		<title><?php echo $title ?></title>
		<meta charset="utf-8" />
		<meta name="author" content="Jonathan Lam" />
		<meta name="description" content="Quick, easy notes for new ideas or facts - simple, fast creation and search all in one for convenient storage; Made for studying, sharing and building on ideas, and research for the multitasking mind." />
		<meta name="keywords" content="jonathan, lam, note, search, share, research, study, research, multitask, fast, convenient, ideas, facts, store" />
		<link rel="stylesheet" type="text/css" href="/NoteBrain/res/style.css" />
		<script src="/NoteBrain/res/jquery.js"></script>
		<script src="/NoteBrain/res/script.js"></script>
	</head>
	<body>
	<div id="all">
		<div id="header">
			<div id="header_1">
				<h1>NoteBrain</h1>
				<span id="desc"><span style="font-family:SSPSBold">Quick, Easy notes - Simple, Quick Creation - Convenient, Relevant Search</span><br />Built for studying, sharing, research, and invention for the multitasking mind.</span>
			</div><!--
		 --><?php echo $user_details ?>
			<hr />
		</div>
<?php
	}
?>