<?php
	// Check for error ($_GET). If is not set, then redirect back to homepage
	include "tools.php";
	if(!isset($_GET["err"]) || tidy($_GET["err"]) == "")
		header("Location: ../index.php");
		
	// Check the error id; if it is not a "registered" one, then redirect back to homepage
	// I will add new errors here as the website progresses
	switch($_GET["err"]) {
		case "signup1":
			$err = "The form is not filled out.";
			break;
		case "signup2":
			$err = "The form is not filled out.";
			break;
		case "signup3":
			$err = "The form is not filled out.";
			break;
		case "signup4":
			$err = "The form is not filled out.";
			break;
		default:
			header("Location: ../index.php");
			exit();
	}
	include "../part/head.php"; ini("NoteBrain");
?>

<h1>Error</h1>
<p><?php echo $_GET["err"] . ": " . $err ?></p>
<a href="../index.php">Home.</a>
<p>You will automatically be redirected to the homepage in <span id="timer">10</span> seconds.</p>

<script>
	// The script for the timer countdown before the redirect
	setInterval(function() {
		var elem = document.getElementById("timer");
		elem.innerHTML = parseInt(elem.innerHTML)-1;
		if(elem.innerHTML == 0)
			window.location = "../index.php";
	}, 1000)
</script>

<?php
	include "../part/foot.php";
 ?>