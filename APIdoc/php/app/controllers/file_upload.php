<?php 
	session_start();
	include('pio.php');
	$filepath = $_FILES["filecontents"]["tmp_name"];
	$upload = pio_file_upload($_SESSION["sessionKey"], $_POST['folderid'], $_POST['filename'], $_POST['filename'], $filepath);

	header( 'Location: /' ) ;
?>