$email = "";
$password = "";
$apiKey = "";
$sessionKey = auth($email, $password, $apiKey);

$rules = list_access_rules($sessionKey)["RESULT"]["DATA"];
$folders = $list_folders($sessionKey, $rules[2]);
foreach($folders as $f){	
	if($f[2] == "FILE"){		
		$download = file_download(sessionKey, $f[16], $f[0], $f[1]);
		echo $download;
	}
}