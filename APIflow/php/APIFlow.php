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

?>