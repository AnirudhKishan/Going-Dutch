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

$query1 = "UPDATE `friendRequest` SET `status`=:status;";
$stmt1 = $dbh->prepare ( $query1 );
$stmt1->bindParam ( ":status", $status );

$query2 = "INSERT INTO `friendRelation` ( `friend1`, `friend2` ) VALUES ( :frnd1, :frnd2 );";
$stmt2 = $dbh->prepare ( $query2 );
$stmt2->bindParam ( ":frnd1", $frnd );
$stmt2->bindParam ( ":frnd2", $_SESSION['id'] );

foreach ( $_POST['frnd'] as $key=>$val )
{
	if ( $val == "0" )
	{
		$status = -1;
	}
	else if ( $val == "1" )
	{
		$status = 1;
	}
	else
	{
		echo "Technical error, something went wrong!";
		exit ( );
	}
	
	$stmt1->execute ( );
	
	if ( $status == 1 )
	{
		$frnd = $key;
		
		$stmt2->execute ( );
	}	
}

header ( "Location: friendRequest_action_output.php" );
exit ( );

?>
