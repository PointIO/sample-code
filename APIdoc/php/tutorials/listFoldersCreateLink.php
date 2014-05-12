$email = "";
$password = "";
$apiKey = "";
$sessionKey = auth($email, $password, $apiKey);

$rules = list_access_rules($sessionKey)["RESULT"]["DATA"];
$folders = $list_folders($sessionKey, $rules[2]);
foreach($folders as $f){	
	if($f[2] == "FILE"){		
		$link = file_create_link(sessionKey, $f[16], $f[0], $f[1], $f[4], $f[3]);
		echo $link;
	}
}