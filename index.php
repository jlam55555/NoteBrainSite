<?php
	include "part/head.php"; ini("NoteBrain");
	
	// If user is signed in, then...
	if(isset($_SESSION["user"])) {
		$user = $_SESSION["user"];
?>
<form action="ver/create.php" method="post" autocomplete="off">
	Begin typing a search query, and press enter to create a note.<br />
	<input name="note" onkeydown="search(this.value);char_count(this.value)" onkeyup="search(this.value);char_count(this.value)" maxlength="500" autofocus />
	<button>Create Note</button>
	<p id="char_count">3 more characters to submit.</p>
</form>
<?php
	
	// Create a select element (dropdown box) with the folders dynamically filled in
	echo "<select id=\"folders\" name=\"folders\" onchange=\"request(this.value,document.getElementById('nested').checked);\">";
	// Put in dropdown box to select folder
	echo "View notes: ";
	include "part/select_folder.php";
	echo "</select>";
	echo "<br />Include nested folders and notes";
	echo "<input type=\"checkbox\" id=\"nested\" onchange=\"request(document.getElementById('folders').value,this.checked);\" />";
	
	// Put in empty paragraph to store visual representation of note structure
	echo "<p id=\"notes\"></p>";

	// If user is not signed in, then
	} else {
?>
<h3>Sign In</h3>
<form action="ver/signin.php" method="post">
<table>
	<tr>
		<td>Username</td>
		<td><input name="user" type="text" /></td>
	</tr>
	<tr>
		<td>Password</td>
		<td><input name="pass" type="password" /></td>
	</tr>
	<tr>
		<td colspan="2"><button>Sign In</button></td>
	</tr>
</table>
</form>

<!-- Allow users to sign up if not already -->
<h3>Or, Sign Up</h3>
<form action="ver/signup.php" method="post">
<table>
	<tbody>
		<tr>
			<td>First Name</td>
			<td><input name="fnam" type="text" /></td>
		</tr>
		<tr>
			<td>Last Name</td>
			<td><input name="lnam" type="text" /></td>
		</tr>
		<tr>
			<td>Email</td>
			<td><input name="mail" type="email" /></td>
		</tr>
		<tr>
			<td>Username</td>
			<td><input name="user" type="text" /></td>
		</tr>
		<tr>
			<td>Password</td>
			<td><input name="pas1" type="password" /></td>
		</tr>
		<tr>
			<td>Verify Password</td>
			<td><input name="pas2" type="password" /></td>
		</tr>
		<tr>
			<td colspan="2"><button type="submit">Sign Up</button></td>
		</tr>
	</tbody>
</table>
</form>
<?php 
	}
	include "part/foot.php";
?>