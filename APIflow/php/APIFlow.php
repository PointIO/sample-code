<?php

$BASE = "http://pf-staging.point.io/";

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

	return json_decode($response, true)["REQUEST"]["PROCESS"];
}

function startProcessWithMsg($sessionKey, $messageName){
	global $BASE;
	$bodyMap= array("Authorization" => $sessionKey, "");
	$paramStr = http_build_query($bodyMap, '', '&');

	$ch = curl_init($BASE . "messages/" . $messageName . "?" . $paramStr);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
	curl_setopt($ch, CURLOPT_POSTFIELDS, "{}");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$response = curl_exec($ch);
	curl_close($ch);

	return json_decode($response, true)["RESPONSE"]["PROCESSID"];
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
?>