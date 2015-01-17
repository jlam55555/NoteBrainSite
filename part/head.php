<?php
	// This document is to create a simple unity among the headers of any page. It includes the <head> and enclosing tags, as well as a header.
	function ini($title) {
		// Get user details if user is logged in
		session_start();
		if(isset($_SESSION["user"]))
			$user_details = "<p>User: " . $_SESSION["user"] . " | <a href=\"/notebrain/res/signout.php\">Sign Out</a></p>";
		else
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
		<link rel="stylesheet" type="text/css" href="res/style.css" />
		<script src="res/script.js"></script>
	</head>
	<body>
		<div id="header">
			<h1>NoteBrain</h1>
			<p>Quick, easy notes for new ideas or facts - simple, fast creation and search all in one for convenient storage; Made for studying, sharing and building on ideas, and research for the multitasking mind.</p>
			<?php echo $user_details ?>
			<hr />
		</div>
<?php
	}
?>