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

$query = "SELECT `user_auth`.`ID`, `user_auth`.`username` FROM `friendRequest`, `user_auth`  WHERE ( `friendRequest`.`status`='0' ) AND ( `friendRequest`.`to`=:to ) AND ( `friendRequest`.`from`=`user_auth`.`ID` );";
$stmt = $dbh->prepare ( $query );
$stmt->bindParam ( ":to", $_SESSION['id'] );
$stmt->execute ( );
$rslt = $stmt->fetchAll();

$reqFrndNames = array ( );

foreach ( $rslt as $key=>$var )
{
	$reqFrndNames[$key] = XSS_encode ( $var[1], 0 )[1];
}

?>

<?php

if ( count ( $reqFrndNames ) == 0 )
{
	$rqsts_displayProperty = "style=\"display: none;\"";
	$noRqstsMessage_displayProperty = "";
}
else
{
	$noRqstsMessage_displayProperty = "style=\"display: none;\"";
	$rqsts_displayProperty = "";
	
	$output = "";
	foreach ( $reqFrndNames as $key=>$var )
	{
		$output .= "\n\t\t\t\t<div class=\"row\">\n";
		$output .= "\n\t\t\t\t\t<div class=\"cell\">$var</div>";
		$output .= "\n\t\t\t\t\t<div class=\"cell\"><input type=\"radio\" name=\"frnd[" . $rslt[$key][0] . "]\" value=\"1\"></div>";
		$output .= "\n\t\t\t\t\t<div class=\"cell rightmost\"><input type=\"radio\" name=\"frnd[" . $rslt[$key][0] . "]\" value=\"0\"></div>";
		$output .= "\n\n\t\t\t\t</div>\n";
	}
}

?>

<!DOCTYPE html>

<html>

<head>
	<title>Pending Friend Requests</title>
	
	<link rel="stylesheet" href="../common/CSS/temp1.css">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../common/bootstrap/css/theme/bootstrap.min.css" media="screen">
	
	<link rel="stylesheet" href="../common/CSS/myCSS.css">
	
</head>

<body>

	<?php include_once ( "../common/PHP/header.php" ); ?>
	
	<div <?php echo $rqsts_displayProperty; ?>>
	
		Friend Requests
	
		<br><br>
	
		<div class="table">
	
			<form action="friendRequest_action.php" method="post">
		
				<div class="row">
	
					<div class="cell">From</div>
					<div class="cell">Accept</div>
					<div class="cell rightmost">Reject</div>		
	
				</div>
		
				<?php if ( isset ( $output ) ) echo $output; ?>
			
				<br><br>
			
				<input type="submit">
		
			</form>
	
		</div>
	
	</div>
	
	<div <?php echo $noRqstsMessage_displayProperty; ?>>
	No Friend Requests!
	</div>
	
	<br><br>
	
	<a href="../Home/home.php">Go back to home</a>
	
	<script src="../common/bootstrap/jQuery/jquery.js"></script>
	<script src="../common/bootstrap/js/bootstrap.min.js"></script>
	
</body>

</html>
