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

$query = "SELECT `ID` FROM `friendRelation` WHERE ( `friend1`=:ID OR `friend2`=:ID );";
$stmt = $dbh->prepare ( $query );
$stmt->bindParam ( ":ID", $_SESSION['id'] );
$stmt->execute ( );
$rslt = $stmt->fetchAll ( );

$frndRels = array ( );
foreach ( $rslt as $val )
{
	array_push ( $frndRels, $val['ID'] );
}

$query = "SELECT `friend1`, `friend2`, `status` FROM `status`, `friendRelation` WHERE ( `friendRelation`.`ID`=`status`.`friendRelation` ) AND ( `friendRelation`=:frndRel );";
$stmt = $dbh->prepare ( $query );
$stmt->bindParam ( ":frndRel", $frndRel );

$query2 = "SELECT `username` FROM `user_auth` WHERE `ID`=:ID;";
$stmt2 = $dbh->prepare ( $query2 );
$stmt2->bindParam ( ":ID", $frndID );

$info = array ( );
foreach ( $frndRels as $frndRel )
{
	$stmt->execute ( );
	$rslt = $stmt->fetch ( );
	
	if ( $stmt->rowCount ( ) != 0 )
	{
		$status = $rslt['status'];
	
		$frndID = $rslt['friend1'];
		$stmt2->execute ( );
		$rslt2 = $stmt2->fetch ( );	
		$frnd1 = $rslt2['username'];
	
		$frndID = $rslt['friend2'];
		$stmt2->execute ( );
		$rslt2 = $stmt2->fetch ( );	
		$frnd2 = $rslt2['username'];
	
		array_push ( $info, array ( $frnd1, $frnd2, $status ) );
	}
}

foreach ( $info as $key=>$val )
{
	$info[$key][0] = XSS_encode ( $val[0], 0 )[1];
}

$query = "SELECT `username` FROM `user_auth` WHERE `ID`=:ID;";
$stmt = $dbh->prepare ( $query );
$stmt->bindParam ( ":ID", $_SESSION['id'] );
$stmt->execute ( );
$rslt = $stmt->fetch ( );
$ourGuy = $rslt['username'];

?>

<?php

$outputProfit = "";
foreach ( $info as $val )
{
	if ( $val[0]==$ourGuy && $val[2]<0 )
	{
		$outputProfit .= "<div class=\"cell\">\n";
		$outputProfit .= "\t<div class=\"cell\">" . $val[1] . "</div>\n";
		$outputProfit .= "\t<div class=\"cell\">" . ( -1 * $val[2] ) . "</div>\n";
		$outputProfit .= "</div>\n\n";
	}
	
	if ( $val[1]==$ourGuy && $val[2]>0 )
	{
		$outputProfit .= "<div class=\"cell\">\n";
		$outputProfit .= "\t<div class=\"cell\">" . $val[0] . "</div>\n";
		$outputProfit .= "\t<div class=\"cell\">" . $val[2] . "</div>\n";
		$outputProfit .= "</div>\n\n";
	}
}

$outputNeutral = "";
foreach ( $info as $val )
{
	if ( $val[0]==$ourGuy && $val[2]==0 )
	{
		$outputNeutral .= "<div class=\"cell\">\n";
		$outputNeutral .= "\t<div class=\"cell\">" . $val[1] . "</div>\n";
		$outputNeutral .= "\t<div class=\"cell\">" . $val[2] . "</div>\n";
		$outputNeutral .= "</div>\n\n";
	}
	
	if ( $val[1]==$ourGuy && $val[2]==0 )
	{
		$outputNeutral .= "<div class=\"cell\">\n";
		$outputNeutral .= "\t<div class=\"cell\">" . $val[0] . "</div>\n";
		$outputNeutral .= "\t<div class=\"cell\">" . $val[2] . "</div>\n";
		$outputNeutral .= "</div>\n\n";
	}
}

$outputLoss = "";
foreach ( $info as $val )
{
	if ( $val[0]==$ourGuy && $val[2]>0 )
	{
		$outputLoss .= "<div class=\"cell\">\n";
		$outputLoss .= "\t<div class=\"cell\">" . $val[1] . "</div>\n";
		$outputLoss .= "\t<div class=\"cell\">" . $val[2] . "</div>\n";
		$outputLoss .= "</div>\n\n";
	}
	
	if ( $val[1]==$ourGuy && $val[2]<0 )
	{
		$outputLoss .= "<div class=\"cell\">\n";
		$outputLoss .= "\t<div class=\"cell\">" . $val[0] . "</div>\n";
		$outputLoss .= "\t<div class=\"cell\">" . ( -1 * $val[2] ) . "</div>\n";
		$outputLoss .= "</div>\n\n";
	}
}

?>

<!DOCTYPE html>

<html>

<head>
	<title>Current Status</title>
	
	<link rel="stylesheet" href="../common/CSS/temp3.css">
</head>

<body>
	
	People who owe you money
	<br>	
	<div class="table">
		<?php echo $outputProfit; ?>
	</div>
	
	<br><br>
	
	People, with whom, everything is settled
	<br>	
	<div class="table">
		<?php echo $outputNeutral; ?>
	</div>
	
	<br><br>
	
	People to whom you owe money
	<br>	
	<div class="table">
		<?php echo $outputLoss; ?>
	</div>
	
	<br><br>
	
	<a href="../Home/home.php">Go back to home</a>	
	
</body>

</html>
