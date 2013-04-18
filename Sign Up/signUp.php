<?php

require_once ( '../common/common_database.php' );

?>

<?php

$err_no = 0;

$query = "SELECT COUNT(*) FROM `user_auth` WHERE `username`=:username;";
$stmt = $dbh->prepare ( $query );
$stmt->bindParam ( ":username", $_POST['username'] );
$stmt->execute ( );
$rslt = $stmt->fetch ( );

if ( $rslt[0] > 0 )
{
	$err_no = 1;
}
else
{
	$query = "INSERT INTO `user_auth` ( `username`, `password` ) VALUES ( :username, :password );";
	$stmt = $dbh->prepare ( $query );
	$stmt->bindParam ( ":username", $_POST['username'] );
	$randomString = "F()(K()";
	$stmt->bindParam ( ":password", hash ( "sha256", ( $_POST['password'] . $randomString ) ) );
	$stmt->execute ( );
		
	$err_no = 0;
}

?>

<?php

if ( $err_no == 0 )
{
	header ( "Location: signUp_success.html" );
}
else if ( $err_no == 1 )
{
	header ( "Location: signUp_front.php?err_no=$err_no" );
}
else
{
	echo "Technical error, something went wrong!";
}

?>
