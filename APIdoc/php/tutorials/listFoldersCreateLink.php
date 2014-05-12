$email = "";
$password = "";
$apiKey = "";
$sessionKey = pio_auth($email, $password, $apiKey);

$rules = pio_list_access_rules($sessionKey)["RESULT"]["DATA"];
$folders = $pio_list_folders($sessionKey, $rules[2]);
foreach($folders as $f){	
	if($f[2] == "FILE"){		
		$link = pio_file_create_link(sessionKey, $f[16], $f[0], $f[1], $f[4], $f[3]);
		echo $link;
	}
}