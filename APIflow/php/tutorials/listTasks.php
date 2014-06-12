<?php

include('../APIFlow.php');

if(count($argv) > 0){
	$sessionKey = auth($argv[1], $argv[2], $argv[3]);	
}else if(count($_GET) > 0){
	$sessionKey = auth($_GET["email"], $_GET["password"], $_GET["apiKey"]);	
}

$tasks = listTasks($sessionKey);

foreach($tasks as $t){
	print_r($t);
}

//complete a task
// $res = completeTask($sessionKey, $t["ID"]);

?>