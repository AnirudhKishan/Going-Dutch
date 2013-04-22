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

$query2 = "SELECT `from`, `to`, `amount` FROM `transaction` WHERE `ID`=:ID";
$stmt2 = $dbh->prepare ( $query2 );
$stmt2->bindParam ( ":ID", $ID );

$query3 = "SELECT COUNT(*), `ID` FROM `friendRelation` WHERE `friend1`=:from AND `friend2`=:to;";
$stmt3 = $dbh->prepare ( $query3 );
$stmt3->bindParam ( ":from", $from );
$stmt3->bindParam ( ":to", $to );

$query4 = "UPDATE `status` SET `status`=`status`+:amount WHERE `friendRelation`=:frndRel;";
$stmt4 = $dbh->prepare ( $query4 );
$stmt4->bindParam ( ":amount", $finalAmount );
$stmt4->bindParam ( ":frndRel", $frndRelID );

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
	
	if ( $status == 1 )
	{
		$stmt2->execute ( );
		$rslt2 = $stmt2->fetch ( );
		$from = $rslt2['from'];
		$to = $rslt2['to'];
		$amount = $rslt2['amount'];
		
		$stmt3->execute();
		$rslt3 = $stmt3->fetch();	
		
		if ( $rslt3[0] == 1 )
		{
			$factor = -1;
			$finalAmount = $factor * $amount;
			$frndRelID = $rslt3['ID'];
		}
		else
		{
			$temp = $from;
			$from = $to;
			$to = $temp;
			
			$stmt3->execute();
			$rslt3 = $stmt3->fetch();
			
			if ( $rslt3[0] == 1 )
			{
				$factor = 1;
				$finalAmount = $factor * $amount;
				$frndRelID = $rslt['ID'];
			}
			else
			{
				echo "Technical error, something went wrong!";
				exit ( );
			}
		}
		
		$stmt4->execute ( );
		
		echo $dbh->errorInfo()[2];
		
	}
}

header ( "Location: pending_output.php" );
exit ( );

?>
