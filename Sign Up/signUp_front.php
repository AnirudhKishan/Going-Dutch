<?php

if ( isset ( $_GET['err_no'] ) )
{
	$err_no = $_GET['err_no'];
}
else
{
	$err_no = 0;
}

?>

<?php

if ( $err_no == 1 )
{
	$output = "Username already taken";
}

?>

<!DOCTYPE html>

<html>

<head>
	<title>Sign Up</title>
</head>

<body>

	<form action="signUp.php" method="post">
		<label for="username">Username : </label>
		<input name="username" id="username">
	
		<br>
	
		<label for="password">Password : </label>
		<input name="password" id="password" type="password">
		
		<br>
		
		<input type="submit">
	</form>
	
	<?php
	
	if ( isset ( $output ) )
	{
		echo "\n\n<br><br>\n\n<div class=\"error\">$output</div>";
	}
	
	?>
	
</body>

</html>
