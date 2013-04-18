<?php

require_once( '../common/common_session.php' );

require_once ( '../common/common_session validate.php' );

?>

<?php

session_destroy();

header ( "Location: ../Log In/logIn_front.php?err_no=3" );

?>
