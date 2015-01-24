<?php

	// Set these to the values for your server. Actual values are hidden for security reasons. If you use this section, delete the following section.
	$servername = "yourserver";	// servername (change this)
	$username = "youruser";		// username (change this)
	$password = "yourpassword";	// password (change this)

	// These are my values (stored in a non-server file). Delete this section if you modified the values above, or, store your server data in a similar way by creating a file named "servdata.txt" with the three comma-separated values.
	$hndl = fopen($_SERVER["DOCUMENT_ROOT"] . "/servdata.txt","r");
	$rval = explode(",",fread($hndl,2048));
	fclose($hndl);
	$servername = $rval[0];
	$username = $rval[1];
	$password = $rval[2];
	
?>