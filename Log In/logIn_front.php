<?php

require_once( '../common/PHP/common_session.php' );

if ( isset ( $_SESSION['logged-in'] ) && $_SESSION['logged-in'] == true )
{
	header ( "Location: ../Home/home.php" );
}

?>

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
	$output = "Username does not exist";
}
else if ( $err_no == 2 )
{
	$output = "Username & Password do not match";
}
else if ( $err_no == 3 )
{
	$output = "You have been Logged Out!";
}
else if ( $err_no == 4 )
{
	$output = "You need to be Logged In to view that page";
}

?>

<!DOCTYPE html>

<html>

<head>
	<title>Log In</title>
</head>

<body>

	<form action="logIn.php" method="post">
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
	
	<br><br>
	
	Not Registered? <a href="../Sign Up/signUp_front.php">Sign Up</a>

</body>

</html>
