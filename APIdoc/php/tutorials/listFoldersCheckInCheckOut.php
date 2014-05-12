$email = "";
$password = "";
$apiKey = "";
$sessionKey = pio_auth($email, $password, $apiKey);

$rules = pio_list_access_rules($sessionKey)["RESULT"]["DATA"];
$folders = $pio_list_folders($sessionKey, $rules[2]);
foreach($folders as $f){	
	if($f[2] == "FILE"){
		$checkout = pio_file_checkout(sessionKey, $f[16], $f[0], $f[1]);

		$download = pio_file_download(sessionKey, $f[16], $f[0], $f[1]);

		##follow download link, download file and make edits, load new file into contents
		$contents = "";

		$upload = pio_file_upload(sessionKey, $f[16], $f[0], $f[1], $contents);

		$checkin = pio_file_checkin(sessionKey, $f[16], $f[0], $f[1]);
		echo $checkin;
	}
}