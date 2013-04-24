<?php

require_once ( 'getNumberUnreadNotifications.php' );

$no = getNumberUnreadNotifications ( );

if ( $no == 0 )
{
	$output_notifications = "";
}
else
{
	$output_notifications = " ( <span class=\"noOfMessages\">$no</span> )";
}

?>

<div class="navbar">
  <div class="navbar-inner background-color-blue-gradient">
  
		<a class="brand" href="http://localhost/going-dutch/">Going Dutch</a>
		
		<ul class="nav nav-pills pull-right">
		
			<li class="divider-vertical"></li>
			
			<li>
				<a href="http://localhost/going-dutch/View Notifications/viewNotifications.php">
					<i class="icon-envelope"></i>
					<?php echo $output_notifications; ?>
				</a>
			</li>
			
			<li class="divider-vertical"></li>
		
			<li class="dropdown">
			<a class="dropdown-toggle" data-toggle="dropdown"	href="#">
				Hi, <?php echo $_SESSION['name']; ?>
				<b class="caret"></b>
			</a>
			<ul class="dropdown-menu">
        <li><a href="http://localhost/going-dutch/Log Out/logOut.php">Log Out</a></li>
			</ul>
			</li>
			
		</ul>
		
  </div>
</div>
