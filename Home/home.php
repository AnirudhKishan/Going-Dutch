<?php

require_once ( '../common/PHP/common_session.php' );
require_once ( '../common/PHP/common_session validate.php' );
require_once ( '../common/PHP/common_database.php' );

if ( ! @include_once ( 'https://raw.github.com/Fa773NM0nK/Fa773N_M0nK-library/master/PHP/XSS%20Protection/XSS_encode.php' ) )
{
	require_once ( '../common/Fa773N_M0nK-library/PHP/XSS Protection/XSS_encode.php' );
}

?>

<?php

/*
	Check if there are any pending requests wrt. this user
*/
$query = "SELECT COUNT(*) FROM `transaction` WHERE `to`='" . $_SESSION['id'] . "' AND `status`='0';";
$stmt = $dbh->prepare ( $query );
$stmt->execute ( );
$rslt = $stmt->fetch ( );

if ( $rslt[0] == 0 )
{
	$pendingDiv_display = "none";
}
else
{
	$pendingDiv_dispaly = "block";
}
/**/

/*
	Generating Alerts
*/
$alerts = array ( );

$query = "SELECT COUNT(*) FROM `friendRequest` WHERE `to`='" . $_SESSION['id'] . "' AND `status`='0';";
$stmt = $dbh->prepare ( $query );
$stmt->execute ( );
$rslt = $stmt->fetch ( );
if ( $rslt[0] > 0 )
{
	array_push ( $alerts, "You have pending friend requests." );
}

$query = "SELECT COUNT(*) FROM `transaction` WHERE `to`='" . $_SESSION['id'] . "' AND `status`='0';";
$stmt = $dbh->prepare ( $query );
$stmt->execute ( );
$rslt = $stmt->fetch ( );
if ( $rslt[0] > 0 )
{
	array_push ( $alerts, "There are transactions waiting for your approval." );
}

$alerts_output = "";
foreach ( $alerts as $alert )
{
	$alerts_output .= "<li>" . $alert . "</li>\n\t\t\t\t\t\t";
}
/**/

?>

<!DOCTYPE html>

<html>

<head>
	<title>Home</title>
	
	<link rel="stylesheet" href="../common/CSS/temp4.css">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../common/bootstrap/css/theme/bootstrap.min.css" media="screen">
	
	<link rel="stylesheet" href="../common/CSS/myCSS.css">
	
</head>

<body>

	<?php include_once ( "../common/PHP/header.php" ); ?>
	
	<div id="mycontainer">
		<div id="notification">
				<div id="alerts">
					<b>Alerts</b><br>
					<ul>
					
						<?php echo $alerts_output; ?>
						
					</ul>
				</div>
				<br><hr><br>
				<div id="notifications">
					<b>New Notifications</b><br>
					<ul>
					
						<?php echo $notifications_output; ?>
						
					</ul>
				</div>
		</div>
	</div>
	
	
	<a href="../Friend/befriend_front.php">Add a User as Your Friend</a>
	<br>
	<a href="../Friend/friendRequest_action_front.php">Accept/Reject Friend Request</a>
	<br>
	<a href="../Record/record_front.php">Record a New Transaction</a>
	<br>
	<div id="pending" style="display: <?php echo $pendingDiv_display; ?>">
		<a href="../Pending/pending_front.php">Accept/Reject Pending Transaction(s)</a>
		<br>
	</div>
	<a href="../View Transactions/viewTransactions_front.php">View Transactions</a>
	<br>
	<a href="../View Status/viewStatus.php">View Status</a>
	<br>
	<a href="../View Notifications/viewNotifications.php">View Notifications</a>
	<br><br>
	<a href="../Log Out/logOut.php">Log Out</a>
	
	<script src="../common/bootstrap/jQuery/jquery.js"></script>
	<script src="../common/bootstrap/js/bootstrap.min.js"></script>
	
</body>

</html>
