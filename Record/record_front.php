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

$query = "SELECT `friend1`, `friend2` FROM `friendRelation` WHERE `friend1`=:ID OR `friend2`=:ID;";
$stmt = $dbh->prepare ( $query );
$stmt->bindParam ( ":ID", $_SESSION['id'] );
$stmt->execute ( );
$rslt = $stmt->fetchAll ( );

$frndList = array ( );
foreach ( $rslt as $val )
{
	if ( $val['friend1'] == $_SESSION['id'] )
	{
		array_push ( $frndList, $val['friend2'] );
	}
	else
	{
		array_push ( $frndList, $val['friend1'] );
	}
}
array_push ( $frndList, $_SESSION['id'] );

?>

<?php

$query = "SELECT `username` FROM `user_auth` WHERE `ID`=:ID;";
$stmt = $dbh->prepare ( $query );
$stmt->bindParam ( ":ID", $frndID );

$content = array ( );
foreach ( $frndList as $key=>$frndID )
{
	$stmt->execute ( );
	$rslt = $stmt->fetch ( );
	
	$frndName = XSS_encode ( $rslt[0], 0 )[1];
	
	array_push ( $content , "<input type=\"checkbox\" name=\"involved[]\" id=\"frnd_$key\" value=\"$frndID\"><label for=\"frnd_$key\">$frndName</label>" );
}

$output = "";
foreach ( $content as $val )
{
	$output .= "<div class=\"box\">\n\t\t\t\t$val\n\t\t\t</div>\n\t\t\t";
}

?>

<!DOCTYPE html>

<html>

<head>
	<title>Record New Transaction</title>
	
	<link rel="stylesheet" href="../common/CSS/temp2.css">
</head>

<body>
	
	<form action="record.php" method="post">
		
		<label for="amount">Amount : </label>
		<input id="amount" name="amount">
		
		<br>
		
		<label for="date">Date of Transaction : </label>
		<input type="date" id="date" name="date">
		
		<br>
		
		How is the amount distributed?
		<input type="radio" name="distribution" id="equally" value="1" checked="checked"><label for="equally">Divided equally</label>
		<input type="radio" name="distribution" id="individually" value="2"><label for="individually">Individually</label>
		
		<br>
		
		Friends involved in this transaction: -
		
		<div>
		
			<?php echo $output; ?>
		
		</div>
		
		<br>
		
		<label for="purpose">Purpose : </label>
		<input id="purpose" name="purpose">
		
		<br>
		
		<input type="submit">
		
	</form>
	
</body>

</html>
