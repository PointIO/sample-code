<?php

include('../APIFlow.php');

$sessionKey = auth($argv[1], $argv[2], $argv[3]);
$processtypes = listProcesstypes($sessionKey);

foreach($processtypes as $t){
	if($t["name"] == "simple"){
		$simple = $t;

		$started = startProcess($sessionKey, $simple["name"]);
		$process = getProcess($sessionKey, $started["id"]);
		foreach($process["TASKS"] as $t){
			$res = completeTask($sessionKey, $t["ID"]);
			echo $res;
		}
	}
}

?>