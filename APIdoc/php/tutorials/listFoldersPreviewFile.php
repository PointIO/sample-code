$email = "";
$password = "";
$apiKey = "";
$sessionKey = pio_auth($email, $password, $apiKey);

$rules = pio_list_access_rules($sessionKey)["RESULT"]["DATA"];
$folders = $pio_list_folders($sessionKey, $rules[2]);
foreach($folders as $f){	
	if($f[2] == "FILE"){		
		$preview = pio_file_preview(sessionKey, $f[16], $f[0], $f[1]);
		echo $preview;
	}
}