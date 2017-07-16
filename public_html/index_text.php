header("Location: http://example.com/myOtherPage.php");
die();
<?php
	session_start();
	if($_SESSION["username"]==null)
	{
		header("Location: login_test.php");
die();
	}
	echo 'hello';

?>
