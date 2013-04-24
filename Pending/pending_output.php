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
