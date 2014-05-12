<?php 
	session_start();
	include('pio.php');
	$preview = pio_file_checkout($_SESSION["sessionKey"], $_POST['folderid'], $_POST['fileid'], $_POST['filename']);
	echo $preview["RESULT"];
?>