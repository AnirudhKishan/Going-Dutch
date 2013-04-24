<?php

require_once ( '../common/PHP/common_session.php' );
require_once ( '../common/PHP/common_session validate.php' );

?>

<!DOCTYPE html>

<html>

<head>
	<title>Select Friend</title>
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../common/bootstrap/css/theme/bootstrap.min.css" media="screen">
	
	<link rel="stylesheet" href="../common/CSS/myCSS.css">
</head>

<body>

	<?php include_once ( "../common/PHP/header.php" ); ?>
	
	<form action="befriend_request.php" method="post">
		<label for="friendUsername">Enter Username of Friend : </label>
		<input name="friendUsername" id="friendUsername">
		<input type="submit" value="Add as Friend">
	</form>
	
	<script src="../common/bootstrap/jQuery/jquery.js"></script>
	<script src="../common/bootstrap/js/bootstrap.min.js"></script>
	
</body>

</html>
