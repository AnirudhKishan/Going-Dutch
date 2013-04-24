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

$query = "SELECT * FROM `transaction` WHERE `to`='" . $_SESSION['id'] . "' AND `status`='0';";
$stmt = $dbh->prepare ( $query );
$stmt->execute ( );
$rslt = $stmt->fetchAll ( );

if ( $stmt->rowCount ( ) == 0 )
{
	header ( "Location: pending_output.php?err_no=1" );
	exit ( );
}
else
{
	$query2 = "SELECT `username` FROM `user_auth` WHERE `ID`=:ID;";
	$stmt2 = $dbh->prepare ( $query2 );
	
	$output = "";
	
	foreach ( $rslt as $trans )
	{
		$stmt2->bindParam ( ":ID", $trans['from'] );
		$stmt2->execute ( );		
		$rslt2 = $stmt2->fetch ( );
		$fromName = $rslt2[0];
		
		$ID = $trans['ID'];
		
		$output .= "<div class=\"row\">\n";
		$output .= "\t\t\t<div class=\"cell\">" . XSS_encode ( $trans['purpose'], 0 )[1] . "</div>\n";
		$output .= "\t\t\t<div class=\"cell\">" . XSS_encode ( $trans['amount'], 0 )[1] . "</div>\n";
		$output .= "\t\t\t<div class=\"cell\">" . XSS_encode ( $trans['date'], 0 )[1] . "</div>\n";
		$output .= "\t\t\t<div class=\"cell\">" . XSS_encode ( $fromName, 0 )[1] . "</div>\n";
		$output .= "\t\t\t<div class=\"cell\">" . "<input type=\"radio\" name=\"_[$ID]\" value=\"1\" checked=\"checked\">" .  "</div>\n";
		$output .= "\t\t\t<div class=\"cell\">" . "<input type=\"radio\" name=\"_[$ID]\" value=\"-1\">" .  "</div>\n";
		$output .= "\t\t</div>\n";
		
		$output .= "\t\t";
	}
}

?>

<!DOCTYPE html>

<html>

<head>
	<title>Pending Transactions</title>
	
	<link rel="stylesheet" href="../common/CSS/temp3.css">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../common/bootstrap/css/theme/bootstrap.min.css" media="screen">
	
	<link rel="stylesheet" href="../common/CSS/myCSS.css">
	
</head>

<body>

	<?php include_once ( "../common/PHP/header.php" ); ?>
	
	<form action="pending_action.php" method="post">
		
		<div class="row">
			<div class="cell"><b>Purpose</b></div>
			<div class="cell"><b>Amount</b></div>
			<div class="cell"><b>Date</b></div>
			<div class="cell"><b>From</b></div>
			<div class="cell"><b>Accept</b></div>
			<div class="cell"><b>Reject</b></div>
		</div>
		
		<?php echo $output; ?>
		
		<input type="submit">
		
	</form>
	
	<script src="../common/bootstrap/jQuery/jquery.js"></script>
	<script src="../common/bootstrap/js/bootstrap.min.js"></script>
	
</body>

</html>
