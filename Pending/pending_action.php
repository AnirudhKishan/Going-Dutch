<?php

require_once ( '../common/PHP/common_session.php' );
require_once ( '../common/PHP/common_session validate.php' );
require_once ( '../common/PHP/common_database.php' );

?>
<?php

/*
TODO:
	If the user modifies the name of the radio button,
	He may end up accepting a transaction, of which he has no right to

	check for such a condition the handle its error
*/

/*
TODO:
	What to do if no radio button of a name is checked?
*/

$query = "UPDATE `transaction` SET `status`=:status WHERE `ID`=:ID;";
$stmt = $dbh->prepare ( $query );
$stmt->bindParam ( ":ID", $ID );
$stmt->bindParam ( ":status", $status );

foreach ( $_POST['_'] as $ID=>$val )
{
	if ( $val == 1 )	
	{
		$status = 1;
	}
	else if ( $val == -1 )
	{
		$status = -1;
	}
	else
	{
		echo "Technical error, something went wrong!";
		exit ( );
	}
	
	
	$stmt->execute ( );
}

header ( "Location: pending_output.php" );
exit ( );

?>
