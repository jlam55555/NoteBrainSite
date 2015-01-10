<?php include "part/head.php"; ini("NoteBrain"); ?>
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
<?php include "part/foot.php" ?>