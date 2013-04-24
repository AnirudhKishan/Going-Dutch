<?php

require_once ( '../common/PHP/common_session.php' );
require_once ( '../common/PHP/common_session validate.php' );
require_once ( '../common/PHP/common_database.php' );

?>

<?php

/*
	Generating Notifications
*/
$notifications = array ( );

$query = "SELECT `ID`, `message`, `status` FROM `notification` WHERE `user_id`='" . $_SESSION['id'] . "' ORDER BY `time` DESC;";
$stmt = $dbh->prepare ( $query );
$stmt->execute ( );
$rslt = $stmt->fetchAll ( );

$query2 = "UPDATE `notification` SET `status`='1' WHERE `ID`=:ID;";
$stmt2 = $dbh->prepare ( $query2 );
$stmt2->bindParam ( ":ID", $ID );

foreach ( $rslt as $notification )
{
	array_push ( $notifications, array ( $notification['message'], $notification['status'] ) );
	
	if ( $notification['status'] == 0 )
	{
		$ID = $notification['ID'];
		$stmt2->execute();
	}
}

$notifications_output = "";
foreach ( $notifications as $notification )
{
	if ( $notification[1] == 1 )
	{
		$notifications_output .= "<li>" . $notification[0] . "</li>\n\t\t";
	}
	else
	{
		$notifications_output .= "<li class=\"new-notification\">" . $notification[0] . "</li>\n\t\t";
	}
}
/**/

?>

<!DOCTYPE html>

<html>

<head>
	<title>View Notifications</title>
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../common/bootstrap/css/theme/bootstrap.min.css" media="screen">
	
	<link rel="stylesheet" href="../common/CSS/myCSS.css">
	
</head>

<body>

	<?php include_once ( "../common/PHP/header.php" ); ?>
	
	<div>
	
	<ul>
	
		<?php echo $notifications_output; ?>
		
	</ul>
	
	</div>
	
	<br><br>
	
	<a href="../Home/home.php">Go back to home</a>
	
	<script src="../common/bootstrap/jQuery/jquery.js"></script>
	<script src="../common/bootstrap/js/bootstrap.min.js"></script>
	
</body>

</html>
