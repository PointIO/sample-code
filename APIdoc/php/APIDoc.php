<?php

$BASE = "http://api.point.io/api/v2/";

<<<<<<< HEAD
function auth($email, $password, $apiKey){
=======
function APIDoc_auth($email, $password, $apiKey){
>>>>>>> db60363f24c70985d1b4e6de91aba2a803f1aaf6
	global $BASE;
	$bodyMap= array("email"=>$email, "password"=> $password, "apiKey"=> $apiKey);
	$postString = http_build_query($bodyMap, '', '&');

	$ch = curl_init($BASE . "auth.json");
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$response = curl_exec($ch);
	curl_close($ch);

	return json_decode($response, true);
}

<<<<<<< HEAD
function list_access_rules($sessionKey){
=======
function APIDoc_list_access_rules($sessionKey){
>>>>>>> db60363f24c70985d1b4e6de91aba2a803f1aaf6
	global $BASE;
	$ch = curl_init($BASE . "accessrules/list.json");
	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: " . $sessionKey));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$response = curl_exec($ch);
	curl_close($ch);

	return json_decode($response, true);	
}

<<<<<<< HEAD
function list_folders($sessionKey, $folderId){
=======
function APIDoc_list_folders($sessionKey, $folderId){
>>>>>>> db60363f24c70985d1b4e6de91aba2a803f1aaf6
	global $BASE;
	$paramMap= array("folderId"=>$folderId);
	$paramStr = http_build_query($paramMap, '', '&');

	$ch = curl_init($BASE . "folders/list.json?" . $paramStr);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: " . $sessionKey));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$response = curl_exec($ch);
	curl_close($ch);

	return json_decode($response, true);	
}

<<<<<<< HEAD
function file_preview($sessionKey, $folderid, $fileid, $filename){
=======
function APIDoc_file_preview($sessionKey, $folderid, $fileid, $filename){
>>>>>>> db60363f24c70985d1b4e6de91aba2a803f1aaf6
	global $BASE;
	$paramMap= array("folderid"=>$folderid, "fileid"=>$fileid, "filename"=>$filename);
	$paramStr = http_build_query($paramMap, '', '&');

	$ch = curl_init($BASE . "folders/files/preview.json?" . $paramStr);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: " . $sessionKey));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$response = curl_exec($ch);
	curl_close($ch);

	return json_decode($response, true);		
}

<<<<<<< HEAD
function file_download($sessionKey, $folderid, $fileid, $filename){
=======
function APIDoc_file_download($sessionKey, $folderid, $fileid, $filename){
>>>>>>> db60363f24c70985d1b4e6de91aba2a803f1aaf6
	global $BASE;
	$paramMap= array("folderid"=>$folderid, "fileid"=>$fileid, "filename"=>$filename);
	$paramStr = http_build_query($paramMap, '', '&');

	$ch = curl_init($BASE . "folders/files/download.json?" . $paramStr);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: " . $sessionKey));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$response = curl_exec($ch);
	curl_close($ch);

	return json_decode($response, true);		
}

<<<<<<< HEAD
function file_create_link($sessionKey, $shareid, $fileid, $filename, $remotepath, $containerid){
=======
function APIDoc_file_create_link($sessionKey, $shareid, $fileid, $filename, $remotepath, $containerid){
>>>>>>> db60363f24c70985d1b4e6de91aba2a803f1aaf6
	global $BASE;
	$paramMap = array("shareid"=>$shareid, "fileid"=>$fileid, "filename"=>$filename, "remotepath"=>$remotepath, "containerid"=>$containerid);
	$paramStr = http_build_query($paramMap, '', '&');

	$ch = curl_init($BASE . "links/create.json");
	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: " . $sessionKey));
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $paramStr);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$response = curl_exec($ch);
	curl_close($ch);

	return json_decode($response, true);		
}

<<<<<<< HEAD
function file_upload($sessionKey, $folderid, $fileid, $filename, $filecontents){
=======
function APIDoc_file_upload($sessionKey, $folderid, $fileid, $filename, $filecontents){
>>>>>>> db60363f24c70985d1b4e6de91aba2a803f1aaf6
	global $BASE;
	$params = array("folderid"=>$folderid, "fileid"=>$fileid, "filename"=>$filename, "filecontents"=>"@".$filecontents);

	$ch = curl_init($BASE . "folders/files/upload.json");
	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: " . $sessionKey));
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$response = curl_exec($ch);
	curl_close($ch);

	return json_decode($response, true);		
}

<<<<<<< HEAD
function file_checkout($sessionKey, $folderid, $fileid, $filename){
=======
function APIDoc_file_checkout($sessionKey, $folderid, $fileid, $filename){
>>>>>>> db60363f24c70985d1b4e6de91aba2a803f1aaf6
	global $BASE;
	$paramMap= array("folderid"=>$folderid, "fileid"=>$fileid, "filename"=>$filename);
	$paramStr = http_build_query($paramMap, '', '&');

	$ch = curl_init($BASE . "folders/files/checkout.json?" . $paramStr);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: " . $sessionKey));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$response = curl_exec($ch);
	curl_close($ch);

	return json_decode($response, true);		
}

<<<<<<< HEAD
function file_checkin($sessionKey, $folderid, $fileid, $filename){
=======
function APIDoc_file_checkin($sessionKey, $folderid, $fileid, $filename){
>>>>>>> db60363f24c70985d1b4e6de91aba2a803f1aaf6
	global $BASE;
	$paramMap= array("folderid"=>$folderid, "fileid"=>$fileid, "filename"=>$filename);
	$paramStr = http_build_query($paramMap, '', '&');

	$ch = curl_init($BASE . "folders/files/checkin.json?" . $paramStr);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: " . $sessionKey));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$response = curl_exec($ch);
	curl_close($ch);

	return json_decode($response, true);		
}

<<<<<<< HEAD
function list_storage_types($sessionKey){
=======
function APIDoc_list_storage_types($sessionKey){
>>>>>>> db60363f24c70985d1b4e6de91aba2a803f1aaf6
	global $BASE;

	$ch = curl_init($BASE . "storagetypes/list.json");
	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: " . $sessionKey));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$response = curl_exec($ch);
	curl_close($ch);

	return json_decode($response, true);	
}

<<<<<<< HEAD
function list_storage_type_params($sessionKey, $siteTypeId){
=======
function APIDoc_list_storage_type_params($sessionKey, $siteTypeId){
>>>>>>> db60363f24c70985d1b4e6de91aba2a803f1aaf6
	global $BASE;

	$ch = curl_init($BASE . "storagetypes/" . $siteTypeId . "/params.json");
	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: " . $sessionKey));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$response = curl_exec($ch);
	curl_close($ch);

	return json_decode($response, true);	
}

function default_flags(){
	$flags = array("enabled" => "1", "loggingEnabled" => "0", "indexingEnabled" => "0", "revisionControl" => "0", "maxRevisions" => "0", "checkinCheckout" => "0");
	return json_encode($flags);
}

<<<<<<< HEAD
function create_storage_site($sessionKey, $siteTypeId, $name, $flags, $siteArgs){
=======
function APIDoc_create_storage_site($sessionKey, $siteTypeId, $name, $flags, $siteArgs){
>>>>>>> db60363f24c70985d1b4e6de91aba2a803f1aaf6
	global $BASE;
	$paramMap = array("siteTypeId"=>$siteTypeId, "name"=>$name, "siteArguments"=>$siteArgs, "flags"=> $flags);
	$paramStr = http_build_query($paramMap, '', '&');

	$ch = curl_init($BASE . "storagesites/create.json");
	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: " . $sessionKey));
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $paramStr);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$response = curl_exec($ch);
	curl_close($ch);

	return json_decode($response, true);		
}

function aasort (&$array, $key) {
    $sorter=array();
    $ret=array();
    reset($array);
    foreach ($array as $ii => $va) {
        $sorter[$ii]=$va[$key];
    }
    asort($sorter);
    foreach ($sorter as $ii => $va) {
        $ret[$ii]=$array[$ii];
    }
    $array=$ret;
}

?>