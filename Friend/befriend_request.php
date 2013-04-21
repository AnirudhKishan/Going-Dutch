<?php

require_once ( '../common/PHP/common_session.php' );
require_once ( '../common/PHP/common_session validate.php' );
require_once ( '../common/PHP/common_database.php' );

?>

<?php

/*
	Checking if a user with the given username exists
*/

$query = "SELECT COUNT(*), `ID` FROM `user_auth` WHERE `username`=:username;";
$stmt = $dbh->prepare ( $query );
$stmt->bindParam ( ":username", $_POST['friendUsername'] );
$stmt->execute ( );
$rslt = $stmt->fetch();

if ( $rslt[0] == 0 )
{
	header ( "Location: befriend_request_output.php?err_no=1" );
	exit ( );
}
else
{
	$frndID = $rslt[1];
}

/**/

/*
	Checking if the friend request is not to self
*/

$query = "SELECT COUNT(*) FROM `user_auth` WHERE `ID`=:id AND `username`=:username;";
$stmt = $dbh->prepare ( $query );
$stmt->bindParam ( ":id", $_SESSION['id'] );
$stmt->bindParam ( ":username", $_POST['friendUsername'] );
$stmt->execute ( );
$rslt = $stmt->fetch();

if ( $rslt[0] == 1 )
{
	header ( "Location: befriend_request_output.php?err_no=5" );
	exit ( );
}

/**/

/*
	Checking if they're not friends, to begin with
*/
$query = "SELECT COUNT(*) FROM `friendRelation` WHERE ( `friend1`=:friend11 AND `friend2`=:friend12  ) OR ( `friend1`=:friend21 AND `friend2`=:friend22  ) ;";
$stmt = $dbh->prepare ( $query );
$stmt->bindParam ( ":friend11", $_SESSION['id'] );
$stmt->bindParam ( ":friend12", $frndID );
$stmt->bindParam ( ":friend21", $frndID );
$stmt->bindParam ( ":friend22", $_SESSION['id'] );
$stmt->execute ( );
$rslt = $stmt->fetch();

if ( $rslt[0] != 0 )
{
	header ( "Location: befriend_request_output.php?err_no=2" );
	exit ( );
}
/**/

/*
	Checking if a request is already pending
*/
$query = "SELECT COUNT(*) FROM `friendRequest` WHERE `from`=:from AND `to`=:to;";
$stmt = $dbh->prepare ( $query );
$stmt->bindParam ( ":from", $_SESSION['id'] );
$stmt->bindParam ( ":to", $frndID );
$stmt->execute ( );
$rslt = $stmt->fetch();

if ( $rslt[0] != 0 )
{
	header ( "Location: befriend_request_output.php?err_no=3" );
	exit ( );
}

$query = "SELECT COUNT(*) FROM `friendRequest` WHERE `from`=:from AND `to`=:to;";
$stmt = $dbh->prepare ( $query );
$stmt->bindParam ( ":from", $frndID );
$stmt->bindParam ( ":to", $_SESSION['id'] );
$stmt->execute ( );
$rslt = $stmt->fetch();

if ( $rslt[0] != 0 )
{
	header ( "Location: befriend_request_output.php?err_no=4" );
	exit ( );
}
/**/

/*
	Generate a new Friend Request
*/
$query = "INSERT INTO `friendRequest` ( `from`, `to`, `status` ) VALUES ( :from, :to, '0' );";
$stmt = $dbh->prepare ( $query );
$stmt->bindParam ( ":from", $_SESSION['id'] );
$stmt->bindParam ( ":to", $frndID );
$stmt->execute ( );

header ( "Location: befriend_request_output.php" );
exit ( );
/**/

?>
