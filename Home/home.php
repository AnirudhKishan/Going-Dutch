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

?>

<!DOCTYPE html>

<html>

<head>
	<title>Home</title>
</head>

<body>
	
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
	<a href="../Log Out/logOut.php">Log Out</a>
	
</body>

</html>
