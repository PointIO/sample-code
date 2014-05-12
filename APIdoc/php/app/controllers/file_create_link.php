<?php 
	session_start();
	include('APIDoc.php');
	$preview = APIDoc_file_create_link($_SESSION["sessionKey"], $_POST['shareid'], $_POST['fileid'], $_POST['filename'], $_POST['remotepath'], $_POST['containerid']);
	echo $preview["LINKURL"];
?>