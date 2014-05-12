<?php
	session_start();
	unset($_SESSION["sessionKey"]);
	header( 'Location: /login.php' );
?>