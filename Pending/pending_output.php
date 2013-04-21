<?php

require_once ( '../common/PHP/common_session validate.php' );
require_once ( '../common/PHP/common_database.php' );

?>

<?php

if ( isset ( $_GET['err_no'] ) )
{
	switch ( $_GET['err_no'] )
	{
		case 1	:	$output = "You have no pending transactions";
							break;
		
		default	:	$output = "Technical error, something went wrong!";
	}
}
else
{
	$output = "Pending Transactions processed successfully";
}

?>

<!DOCTYPE html>

<html>

<head>
	<title>Pending Transactions Report</title>
</head>

<body>
	
	<?php echo $output; ?>
	
	<br><br>
	
	<a href="../Home/home.php">Go back to home</a>
	
</body>

</html>
