<?php

require_once ( '../common/PHP/common_session.php' );
require_once ( '../common/PHP/common_session validate.php' );

?>

<?php

if ( isset ( $_GET['err_no'] ) )
{
	switch ( $_GET['err_no'] )
	{
		case 1	:	$output = "Username does not exist";
							break;
		case 2	:	$output = "Already a friend";
							break;
		case 3	:	$output = "A friend request FROM YOU, to the specified user is already pending";
							break;
		case 4	:	$output = "A friend request FROM SPECIFIED USER, to you is already pending";
							break;
		case 5	:	$output = "You cannot send a friend request to yourself";
							break;
		
		default	:	$output = "Technical error, something went wrong!";
							exit ( );
	}
}
else
{
	$output = "Friend Request Sent Successfully";
}

?>

<!DOCTYPE html>

<html>

<head>
	<title>Befrinding Report</title>
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../common/bootstrap/css/theme/bootstrap.min.css" media="screen">
	
	<link rel="stylesheet" href="../common/CSS/myCSS.css">
	
</head>

<body>

	<?php include_once ( "../common/PHP/header.php" ); ?>
	
	<?php echo $output; ?>
	
	<br><br>
	
	<a href="../Home/home.php">Go back to home</a>
	
	<script src="../common/bootstrap/jQuery/jquery.js"></script>
	<script src="../common/bootstrap/js/bootstrap.min.js"></script>
	
</body>

</html>
