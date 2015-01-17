<?php
	include "part/head.php"; ini("NoteBrain");
	
	// If user is signed in, then...
	if(isset($_SESSION["user"])) {
?>
<form action="newNote.php" method="post">
	Begin typing a search query, and press enter to create a note.<br />
	<input name="note" type="text" />
	<button>Create Note</button>
</form>
<?php
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