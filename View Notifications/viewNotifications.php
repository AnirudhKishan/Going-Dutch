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

$query = "SELECT `ID`, `message` FROM `notification` WHERE `user_id`='" . $_SESSION['id'] . "' ORDER BY `time` DESC;";
$stmt = $dbh->prepare ( $query );
$stmt->execute ( );
$rslt = $stmt->fetchAll ( );
foreach ( $rslt as $notification )
{
	array_push ( $notifications, $notification['message'] );
}

$notifications_output = "";
foreach ( $notifications as $notification )
{
	$notifications_output .= "<li>" . $notification . "</li>\n\t\t";
}
/**/

?>

<!DOCTYPE html>

<html>

<head>
	<title>View Notifications</title>
</head>

<body>
	
	<div>
	
	<ul>
		<?php echo $notifications_output; ?>
	</ul>
	
	</div>
	
	<br><br>
	
	<a href="../Home/home.php">Go back to home</a>	
	
</body>

</html>
