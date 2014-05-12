<?php 
	session_start();
	include('APIDoc.php');
	$_SESSION["sessionKey"] = APIDoc_auth($_POST['email'], $_POST['password'], "51C54CDB-D278-4CFD-B8378EF13462E5FB")["RESULT"]["SESSIONKEY"];
	header( 'Location: /' ) ;
?>