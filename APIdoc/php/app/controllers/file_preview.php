<?php 
	session_start();
	include('APIDoc.php');
	$preview = APIDoc_file_preview($_SESSION["sessionKey"], $_POST['folderid'], $_POST['fileid'], $_POST['filename']);
	echo $preview["RESULT"];
?>