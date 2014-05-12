$email = "";
$password = "";
$apiKey = "";
$sessionKey = APIDoc_auth($email, $password, $apiKey);

$rules = APIDoc_list_access_rules($sessionKey)["RESULT"]["DATA"];
$folders = $APIDoc_list_folders($sessionKey, $rules[2]);
foreach($folders as $f){	
	if($f[2] == "FILE"){		
		$download = APIDoc_file_download(sessionKey, $f[16], $f[0], $f[1]);
		echo $download;
	}
}