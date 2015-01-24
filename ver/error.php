<?php

	include "../part/head.php"; ini("NoteBrain");
	
	// Check for error ($_GET). If is not set, then redirect back to homepage
	if(!isset($_GET["err"]) || ($get_err = tidy($_GET["err"],null,true)) == "")
		header("Location: ../index.php");
		
	// Check the error id; if it is not a "registered" one, then redirect back to homepage
	// I will add new errors here as the website progresses
	switch($get_err) {
	// SIGNIN/UP ERRORS
		case "signup1":
		case "signin1":
			$err = "The form is not filled out.";
			break;
		case "signup2":
			$err = "The passwords don't match.";
			break;
		case "signup3":
			$err = "The values are not valid. Each field must be 2-50 characters in length. Avoid using special characters.";
			break;
		case "signup4":
			$err = "Username is taken.";
			break;
		case "signin2":
			$err = "User not found.";
			break;
		case "signin3":
			$err = "Password is incorrect.";
			break;
		// CREATE NOTE ERRORS
		case "note1":
			$err = "Note is empty or whitespace, or note is the wrong length (has to be 3-500 characters).";
			break;
		// PDOEXCEPTION
		case "pdoexception":
			$err = tidy($_GET["msg"],null,true);
			break;
		// WEBSITE ERRORS
		case "400":
			$err = "Bad Request.";
			break;
		case "401":
			$err = "Unauthorized.";
			break;
		case "403":
			$err = "Forbidden.";
			break;
		case "404":
			$err = "Page not Found.";
			break;
		case "500":
			$err = "Internal Server Error.";
			break;
		default:
			header("Location: ../index.php");
			exit();
	}

?>

<h1>Error</h1>
<p><?php echo "Error: " . $get_err . " ($err)" ?></p>
<a href="/notebrain/index.php">Home</a>.
<p>You will automatically be redirected to the homepage in <span id="timer">5</span> seconds.</p>
<button onclick="clearInterval(t); elem.innerHTML = 'STOPPED';">Click to stop timer (debugging).</button>

<script>
	// The script for the timer countdown before the redirect
	t = setInterval(function() {
		elem = document.getElementById("timer");
		elem.innerHTML = parseInt(elem.innerHTML)-1;
		if(elem.innerHTML == 0)
			window.location = "/notebrain/index.php";
	}, 1000)
</script>

<?php
	include "../part/foot.php";
 ?>