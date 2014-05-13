<?php

$BASE = "http://pointflow.point.io/";

function auth($email, $password, $apiKey){
	global $BASE;
	$bodyMap= array("email"=>$email, "password"=> $password, "apikey"=> $apiKey);
	$paramStr = http_build_query($bodyMap, '', '&');

	$ch = curl_init($BASE . "auth?" . $paramStr);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$response = curl_exec($ch);
	curl_close($ch);

	return json_decode($response, true)["RESULT"]["SESSIONKEY"];
}

function listProcesstypes($sessionKey){
	global $BASE;
	$bodyMap= array("Authorization" => $sessionKey);
	$paramStr = http_build_query($bodyMap, '', '&');

	$ch = curl_init($BASE . "processtypes?" . $paramStr);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$response = curl_exec($ch);
	curl_close($ch);

	return json_decode($response, true)["REQUEST"]["PROCESSTYPES"];
}

function startProcess($sessionKey, $processName){
	global $BASE;
	$bodyMap= array("Authorization" => $sessionKey, "");
	$paramStr = http_build_query($bodyMap, '', '&');

	$ch = curl_init($BASE . "processes/" . $processName . "?" . $paramStr);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
	curl_setopt($ch, CURLOPT_POSTFIELDS, "{}");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$response = curl_exec($ch);
	curl_close($ch);

	echo $response;

	return json_decode($response, true)["REQUEST"]["PROCESS"];
}

function getProcess($sessionKey, $processId){
	global $BASE;
	$bodyMap= array("Authorization" => $sessionKey);
	$paramStr = http_build_query($bodyMap, '', '&');

	$ch = curl_init($BASE . "processes/" . $processId . "?" . $paramStr);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$response = curl_exec($ch);
	curl_close($ch);

	return json_decode($response, true)["RESPONSE"]["PROCESS"];	
}

function completeTask($sessionKey, $taskId){
	global $BASE;
	$bodyMap= array("Authorization" => $sessionKey, "");
	$paramStr = http_build_query($bodyMap, '', '&');

	$ch = curl_init($BASE . "tasks/" . $taskId . "?" . $paramStr);
	curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
	curl_setopt($ch, CURLOPT_POSTFIELDS, "{}");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$response = curl_exec($ch);
	curl_close($ch);

	return json_decode($response, true);
}

$sessionKey = auth($argv[1], $argv[2], $argv[3]);
$processtypes = listProcesstypes($sessionKey);

foreach($processtypes as $t){
	if($t["name"] == "demo"){
		$demo = $t;

		$started = startProcess($sessionKey, $demo["name"]);
		$process = getProcess($sessionKey, $started["id"]);
		foreach($process["TASKS"] as $t){
			$res = completeTask($sessionKey, $t["ID"]);
			echo $res;
		}
	}
}

// function file_create_link($sessionKey, $shareid, $fileid, $filename, $remotepath, $containerid){
// 	global $BASE;
// 	$paramMap = array("shareid"=>$shareid, "fileid"=>$fileid, "filename"=>$filename, "remotepath"=>$remotepath, "containerid"=>$containerid);
// 	$paramStr = http_build_query($paramMap, '', '&');

// 	$ch = curl_init($BASE . "links/create.json");
// 	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: " . $sessionKey));
// 	curl_setopt($ch, CURLOPT_POST, true);
// 	curl_setopt($ch, CURLOPT_POSTFIELDS, $paramStr);
// 	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// 	$response = curl_exec($ch);
// 	curl_close($ch);

// 	return json_decode($response, true);		
// }

// function file_upload($sessionKey, $folderid, $fileid, $filename, $filecontents){
// 	global $BASE;
// 	$params = array("folderid"=>$folderid, "fileid"=>$fileid, "filename"=>$filename, "filecontents"=>"@".$filecontents);

// 	$ch = curl_init($BASE . "folders/files/upload.json");
// 	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: " . $sessionKey));
// 	curl_setopt($ch, CURLOPT_POST, true);
// 	curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
// 	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// 	$response = curl_exec($ch);
// 	curl_close($ch);

// 	return json_decode($response, true);		
// }

// function file_checkout($sessionKey, $folderid, $fileid, $filename){
// 	global $BASE;
// 	$paramMap= array("folderid"=>$folderid, "fileid"=>$fileid, "filename"=>$filename);
// 	$paramStr = http_build_query($paramMap, '', '&');

// 	$ch = curl_init($BASE . "folders/files/checkout.json?" . $paramStr);
// 	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: " . $sessionKey));
// 	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// 	$response = curl_exec($ch);
// 	curl_close($ch);

// 	return json_decode($response, true);		
// }

// function file_checkin($sessionKey, $folderid, $fileid, $filename){
// 	global $BASE;
// 	$paramMap= array("folderid"=>$folderid, "fileid"=>$fileid, "filename"=>$filename);
// 	$paramStr = http_build_query($paramMap, '', '&');

// 	$ch = curl_init($BASE . "folders/files/checkin.json?" . $paramStr);
// 	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: " . $sessionKey));
// 	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// 	$response = curl_exec($ch);
// 	curl_close($ch);

// 	return json_decode($response, true);		
// }

// function list_storage_types($sessionKey){
// 	global $BASE;

// 	$ch = curl_init($BASE . "storagetypes/list.json");
// 	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: " . $sessionKey));
// 	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// 	$response = curl_exec($ch);
// 	curl_close($ch);

// 	return json_decode($response, true);	
// }

// function list_storage_type_params($sessionKey, $siteTypeId){
// 	global $BASE;

// 	$ch = curl_init($BASE . "storagetypes/" . $siteTypeId . "/params.json");
// 	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: " . $sessionKey));
// 	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// 	$response = curl_exec($ch);
// 	curl_close($ch);

// 	return json_decode($response, true);	
// }

// function default_flags(){
// 	$flags = array("enabled" => "1", "loggingEnabled" => "0", "indexingEnabled" => "0", "revisionControl" => "0", "maxRevisions" => "0", "checkinCheckout" => "0");
// 	return json_encode($flags);
// }

// function create_storage_site($sessionKey, $siteTypeId, $name, $flags, $siteArgs){
// 	global $BASE;
// 	$paramMap = array("siteTypeId"=>$siteTypeId, "name"=>$name, "siteArguments"=>$siteArgs, "flags"=> $flags);
// 	$paramStr = http_build_query($paramMap, '', '&');

// 	$ch = curl_init($BASE . "storagesites/create.json");
// 	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: " . $sessionKey));
// 	curl_setopt($ch, CURLOPT_POST, true);
// 	curl_setopt($ch, CURLOPT_POSTFIELDS, $paramStr);
// 	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// 	$response = curl_exec($ch);
// 	curl_close($ch);

// 	return json_decode($response, true);		
// }

// function aasort (&$array, $key) {
//     $sorter=array();
//     $ret=array();
//     reset($array);
//     foreach ($array as $ii => $va) {
//         $sorter[$ii]=$va[$key];
//     }
//     asort($sorter);
//     foreach ($sorter as $ii => $va) {
//         $ret[$ii]=$array[$ii];
//     }
//     $array=$ret;
// }

?>