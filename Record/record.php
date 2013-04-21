<?php

require_once ( '../common/PHP/common_session.php' );
require_once ( '../common/PHP/common_session validate.php' );
require_once ( '../common/PHP/common_database.php' );

?>

<?php

$amnt = $_POST['amount'];
$date = $_POST['date'];
$dist = $_POST['distribution'];
$purpose = $_POST['purpose'];

$frndsInvolved = $_POST['involved'];
/*
	TODO:
	
	If the user modifies the value of the checkbox 'involved', inconsistency will arise.
	Because, the value of the checkbox decides to which user the transaction has to be remitted
		what if they're not friends?

	check for such a condition the handle its error
*/

/*
	TODO: Validation
*/

if ( $dist == 1 )
{
	$each = $amnt / count ( $frndsInvolved );
}
else if ( $dist == 2 )
{
	$each = $amnt;
}
else
{
	echo "Technical error, something went wrong!";
	exit ( );
}

$query = "INSERT INTO `transaction`( `amount`, `date`, `from`, `to`, `purpose`, `status`) VALUES ( :amount, :date, :from, :to, :purpose, :status );";
$stmt = $dbh->prepare ( $query );
$stmt->bindParam ( ":amount", $amnt );
$stmt->bindParam ( ":date", $date );
$stmt->bindParam ( ":from", $from );
$stmt->bindParam ( ":to", $to );
$stmt->bindParam ( ":purpose", $purpose );
$stmt->bindParam ( ":status", $status );

$amnt = round ( $each, 2 );
$from = $_SESSION['id'];

foreach ( $frndsInvolved as $to )
{
	if ( $to == $_SESSION['id'] )
	{
		$status = 1;
	}
	else
	{
		$status = 0;
	}
	
	$stmt->execute ( );
	
}

header ( "Location: record_output.php" );
exit ( );

?>
