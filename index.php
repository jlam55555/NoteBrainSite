<?php
	include "part/head.php"; ini("NoteBrain");
	
	// If user is signed in, then...
	if(isset($_SESSION["user"])) {
		$user = $_SESSION["user"];
?>
<div id="show_options">
	<h3>Create a <span class="to_change">note</span></h3>
	<form id="create" autocomplete="off">
		Begin typing a search query, and press enter to create a <span class="to_change">note</span>.<br />
		<input name="note" onkeydown="search(this.value);char_count(this.value)" onkeyup="search(this.value);char_count(this.value)" maxlength="500" autofocus />
		<button>Create <span class="to_change">note</span></button><br />
		Note <input type="radio" name="type" value="note" checked /> |
		Folder <input type="radio" name="type" value="folder" />
		<p id="char_count">3 more characters to submit.</p>
	</form>
	<h3>Viewing Options</h3>
	View folder:
	<select id="folders" name="folders" onchange="request();">";
	<?php 
		// Dynamically generate dropdown box options to select folder
		include "part/select_folder.php";
	?>
	</select>
	<br />Include nested folders and notes
	<input type="checkbox" id="nested" onchange="request()" />
</div><!--
	This is to remove whitespace
--><div id="show_notes">
	<p id="notes"></p>
</div>
<?php
	// If user is not signed in, then
	} else {
?>

<!-- Allow users to sign in if they have an account -->
<div id="sign_in">
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
</div>

<div id="sign_up" style="display:none">
	<h3>Sign Up</h3>
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
</div>

<button onclick="$('#sign_up, #sign_in').toggle();this.innerHTML = (this.innerHTML == 'Or, Sign Up') ? 'Or, Sign In' : 'Or, Sign Up';">Or, Sign Up</button>

<?php 
	}
	include "part/foot.php";
?>