<?php

require_once ( '../common/PHP/common_session.php' );
require_once ( '../common/PHP/common_session validate.php' );

?>

<!DOCTYPE html>

<html>

<head>
	<title>Select Friend</title>
</head>

<body>
	
	<form action="befriend_request.php" method="post">
		<label for="friendUsername">Enter Username of Friend : </label>
		<input name="friendUsername" id="friendUsername">
		<input type="submit" value="Add as Friend">
	</form>
	
</body>

</html>
