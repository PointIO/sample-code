<?php

$BASE = "http://api.point.io/api/v2/";

function auth($email, $password, $apiKey){
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

function list_access_rules($sessionKey){
	global $BASE;
	$ch = curl_init($BASE . "accessrules/list.json");
	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: " . $sessionKey));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$response = curl_exec($ch);
	curl_close($ch);

	return json_decode($response, true);	
}

function list_folders($sessionKey, $folderId){
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

function file_preview($sessionKey, $folderid, $fileid, $filename){
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

function file_download($sessionKey, $folderid, $fileid, $filename){
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

function file_create_link($sessionKey, $shareid, $fileid, $filename, $remotepath, $containerid){
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

function file_upload($sessionKey, $folderid, $fileid, $filename, $filecontents){
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

function file_checkout($sessionKey, $folderid, $fileid, $filename){
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

function file_checkin($sessionKey, $folderid, $fileid, $filename){
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

function list_storage_types($sessionKey){
	global $BASE;

	$ch = curl_init($BASE . "storagetypes/list.json");
	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: " . $sessionKey));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$response = curl_exec($ch);
	curl_close($ch);

	return json_decode($response, true);	
}

function list_storage_type_params($sessionKey, $siteTypeId){
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

function create_storage_site($sessionKey, $siteTypeId, $name, $flags, $siteArgs){
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