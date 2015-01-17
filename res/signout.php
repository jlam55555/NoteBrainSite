<?php
	
	// Make sure user is logged in
	session_start();
	if(isset($_SESSION["user"]))
		// If user logged in, then sign out (remove them from session).
		session_destroy();
		
	// Go back to homepage (even if they were not logged in - nothing to do here).
	header("Location: ../index.php");

?>