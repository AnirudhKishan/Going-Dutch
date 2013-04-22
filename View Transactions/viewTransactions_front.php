<?php

require_once ( '../common/PHP/common_session.php' );
require_once ( '../common/PHP/common_session validate.php' );

?>

<!DOCTYPE html>

<html>

<head>
	<title>View Transactions</title>
</head>

<body>
	
	<form action="viewTransactions.php" method="post">
		<input type="checkbox" name="type_payer" id="type_payer" value="1"><label for="type_payer">Transaction where you payed</label>
		<br>
		<input type="checkbox" name="type_payee" id="type_payee" value="2"><label for="type_payee">Transaction where your friends payed for you</label>
		
		<br><br><br>
		
		<input type="checkbox" name="approved" id="approved" checked="chekced"><label for="approved">Approved Transactions</label>
		<br>
		<input type="checkbox" name="pending" id="pending"><label for="pending">Pending Transactions</label>
		<br>
		<input type="checkbox" name="rejected" id="rejected"><label for="rejected">Rejected Transactions</label>
		
		<br><br>
		
		<input type="submit">
	</form>
	
</body>

</html>
