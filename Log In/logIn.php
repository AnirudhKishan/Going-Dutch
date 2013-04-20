<?php

require_once ( '../common/PHP/common_database.php' );

?>

<?php

$err_no = 0;

$query = "SELECT * FROM `user_auth` WHERE `username`=:username";
$stmt = $dbh->prepare ( $query );
$stmt->bindParam ( ":username", $_POST['username'] );
$stmt->execute ( );

if ( $stmt->rowCount ( ) == 0 )
{
	$err_no = 1;
}
else
{
	$rslt = $stmt->fetch ( );
	
	$randomString = "F()(K()";
	if ( hash ( "sha256", ( $_POST['password'] . $randomString ) ) == $rslt['password'] )
	{
		session_destroy ( );
		session_start ( );
		
		$_SESSION['logged-in'] = true;
		$_SESSION['id'] = $rslt['ID'];
		
		$err_no = 0;
	}
	else
	{
		$err_no = 2;
	}
}

?>

<?php

if ( $err_no == 0 )
{
	header ( "Location: ../Home/home.php" );
}
else if ( $err_no == 1 )
{
	header ( "Location: logIn_front.php?err_no=$err_no" );
}
else if ( $err_no == 2 )
{
	header ( "Location: logIn_front.php?err_no=$err_no" );
}
else
{
	echo "Technical error, something went wrong!";
}

?>
