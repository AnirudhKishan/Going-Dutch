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

$firstFlag = true;

function put ( $when, $what, $whatElse, &$flag, &$query )	//0: first;	1: not first
{
	if ( ( $when == 0 && $flag == true ) || ( $when == 1 && $flag == false ) )
	{
		$query .= " $what";
		
		if ( $flag == true ) $flag = false;
		
		return true;
	}
	else if ( ( $when == 0 && $flag == false ) || ( $when == 0 && $flag == true ) )
	{
		$query .= " $whatElse";
		
		if ( $flag == true ) $flag = false;
		
		return true;
	}
	else
	{
		return false;
	}
}

$query = "SELECT * FROM `transaction`";

if ( ! ( isset ( $_POST['type_payer'] ) || isset ( $_POST['type_payee'] ) ) )
{
	$anyFlag = false;
}
else
{
	if ( isset ( $_POST['type_payer'] ) )
	{
		put ( 0, "WHERE (", "OR", $firstFlag, $query );
	
		$query .= " `from`='" . $_SESSION['id'] . "'";
	}

	if ( isset ( $_POST['type_payee'] ) )
	{
		put ( 0, "WHERE", "OR", $firstFlag, $query );
	
		$query .= " `to`='" . $_SESSION['id'] . "'";
	}
	
	if ( $firstFlag == false )
	{
		$query .= " )";
	}

	$firstFlag = true;

	if ( ! ( isset ( $_POST['approved'] ) || isset ( $_POST['pending'] ) || isset ( $_POST['rejected'] ) ) )
	{
		$anyFlag = false;
	}
	else
	{
		$anyFlag = true;
	
		if ( isset ( $_POST['approved'] ) )
		{
			put ( 0, "AND (", "OR", $firstFlag, $query );
		
			$query .= " `status`='1'";
		}
	
		if ( isset ( $_POST['pending'] ) )
		{
			put ( 0, "AND (", "OR", $firstFlag, $query );
		
			$query .= " `status`='0'";
		}
	
		if ( isset ( $_POST['rejected'] ) )
		{
			put ( 0, "AND (", "OR", $firstFlag, $query );
		
			$query .= " `status`='-1'";
		}
	}
}

if ( $firstFlag == false )
{
	$query .= " )";
}

$query .= ";";


if ( $anyFlag == false )
{
	$output = "No type of transaction selected";
	$headingDiv_style = " style=\"display: none\"";
}
else
{
	$stmt = $dbh->prepare ( $query );
	$stmt->execute ( );
	$rslt = $stmt->fetchAll ( );
	
	echo $stmt->errorInfo()[2];

	if ( $stmt->rowCount ( ) == 0 )
	{
		$output = "No transactions match the given criterion";
		$headingDiv_style = " style=\"display: none\"";
	}
	else
	{
		$headingDiv_style = "";
		
		$query2 = "SELECT `username` FROM `user_auth` WHERE `ID`=:ID;";
		$stmt2 = $dbh->prepare ( $query2 );
	
		$output = "";
	
		foreach ( $rslt as $trans )
		{
			$stmt2->bindParam ( ":ID", $trans['from'] );
			$stmt2->execute ( );		
			$rslt2 = $stmt2->fetch ( );
			$fromName = $rslt2[0];
			
			$stmt2->bindParam ( ":ID", $trans['to'] );
			$stmt2->execute ( );		
			$rslt2 = $stmt2->fetch ( );
			$toName = $rslt2[0];
		
			if ( $trans['status'] == -1 )
			{
				$status = "Rejected";
			}
			else if ( $trans['status'] == 0 )
			{
				$status = "Pending";
			}
			else if ( $trans['status'] == 1 )
			{
				$status = "Approved";
			}
			else
			{
				echo "Technical error, something went wrong!";
				exit ( );
			}
		
			$output .= "<div class=\"row\">\n";
			$output .= "\t\t\t<div class=\"cell\">" . XSS_encode ( $trans['purpose'], 0 )[1] . "</div>\n";
			$output .= "\t\t\t<div class=\"cell\">" . XSS_encode ( $trans['amount'], 0 )[1] . "</div>\n";
			$output .= "\t\t\t<div class=\"cell\">" . XSS_encode ( $trans['date'], 0 )[1] . "</div>\n";
			$output .= "\t\t\t<div class=\"cell\">" . XSS_encode ( $fromName, 0 )[1] . "</div>\n";
			$output .= "\t\t\t<div class=\"cell\">" . XSS_encode ( $toName, 0 )[1] . "</div>\n";
			$output .= "\t\t\t<div class=\"cell\">" . $status . "</div>\n";
			$output .= "\t\t</div>\n";
		
			$output .= "\t\t";

		}
	}
}
?>

<!DOCTYPE html>

<html>

<head>
	<title>Pending Transactions</title>
	
	<link rel="stylesheet" href="../common/CSS/temp3.css">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../common/bootstrap/css/theme/bootstrap.min.css" media="screen">
	
	<link rel="stylesheet" href="../common/CSS/myCSS.css">
	
</head>

<body>

	<?php include_once ( "../common/PHP/header.php" ); ?>
	
	<div class="table">
	
		<div class="row"<?php echo $headingDiv_style; ?>>
			<div class="cell"><b>Purpose</b></div>
			<div class="cell"><b>Amount</b></div>
			<div class="cell"><b>Date</b></div>
			<div class="cell"><b>From</b></div>
			<div class="cell"><b>To</b></div>
			<div class="cell"><b>Status</b></div>
		</div>

		<?php echo $output; ?>
	
	</div>
	
	<br><br>
	
	<a href="../Home/home.php">Go back to home</a>
	
	<script src="../common/bootstrap/jQuery/jquery.js"></script>
	<script src="../common/bootstrap/js/bootstrap.min.js"></script>
	
</body>

</html>
