
<?php
	session_start();
	if($_SESSION["username"]==null)
	{
		header("Location: login_test.php");
die();
	}
	echo 'hello';

?>
