<?php 
	session_start();
	include('APIDoc.php');
	$filepath = $_FILES["filecontents"]["tmp_name"];
	$upload = file_upload($_SESSION["sessionKey"], $_POST['folderid'], $_POST['filename'], $_POST['filename'], $filepath);

	header( 'Location: /' ) ;
?>