<?php

include('../APIFlow.php');

if(count($argv) > 0){
	$sessionKey = auth($argv[1], $argv[2], $argv[3]);	
}else if(count($_GET) > 0){
	$sessionKey = auth($_GET["email"], $_GET["password"], $_GET["apiKey"]);	
}

$processtypes = listProcesstypes($sessionKey);

foreach($processtypes as $t){
	if($t["name"] == "simple"){
		$simple = $t;

		$started = startProcess($sessionKey, $simple["name"]);
		$process = getProcess($sessionKey, $started["id"]);
		foreach($process["TASKS"] as $t){
			$res = completeTask($sessionKey, $t["ID"]);
			print_r($res);
		}
	}
}

?>