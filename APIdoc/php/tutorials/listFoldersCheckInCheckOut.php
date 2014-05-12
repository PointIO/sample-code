$email = "";
$password = "";
$apiKey = "";
$sessionKey = auth($email, $password, $apiKey);

$rules = list_access_rules($sessionKey)["RESULT"]["DATA"];
$folders = $list_folders($sessionKey, $rules[2]);
foreach($folders as $f){	
	if($f[2] == "FILE"){
		$checkout = file_checkout(sessionKey, $f[16], $f[0], $f[1]);

		$download = file_download(sessionKey, $f[16], $f[0], $f[1]);

		##follow download link, download file and make edits, load new file into contents
		$contents = "";

		$upload = file_upload(sessionKey, $f[16], $f[0], $f[1], $contents);

		$checkin = file_checkin(sessionKey, $f[16], $f[0], $f[1]);
		echo $checkin;
	}
}