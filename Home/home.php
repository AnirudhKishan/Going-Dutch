<?php

require_once ( '../common/PHP/common_database.php' );
require_once ( '../common/PHP/common_session.php' );
require_once ( '../common/PHP/common_session validate.php' );

if ( ! @include_once ( 'https://raw.github.com/Fa773NM0nK/Fa773N_M0nK-library/master/PHP/XSS%20Protection/XSS_encode.php' ) )
{
	require_once ( '../common/Fa773N_M0nK-library/PHP/XSS Protection/XSS_encode.php' );
}

?>

<!DOCTYPE html>

<html>

<head>
	<title>Home</title>
</head>

<body>
	
	<a href="../Friend/befriend_front.php">Add a User as Your Friend</a>
	<br>
	<a href="../Friend/friendRequest_action_front.php">Accept/Reject Friend Request</a>
	<br>
	<a href="../Record/record_front.php">Record a New Transaction</a>
	<br>
	<a href="../Log Out/logOut.php">Log Out</a>
	
</body>

</html>
