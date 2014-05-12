<?php 
	session_start();
	include('pio.php');
	$_SESSION["sessionKey"] = pio_auth($_POST['email'], $_POST['password'], "51C54CDB-D278-4CFD-B8378EF13462E5FB")["RESULT"]["SESSIONKEY"];
	header( 'Location: /' ) ;
?>