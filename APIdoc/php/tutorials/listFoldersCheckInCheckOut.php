$email = "";
$password = "";
$apiKey = "";
$sessionKey = APIDoc_auth($email, $password, $apiKey);

$rules = APIDoc_list_access_rules($sessionKey)["RESULT"]["DATA"];
$folders = $APIDoc_list_folders($sessionKey, $rules[2]);
foreach($folders as $f){	
	if($f[2] == "FILE"){
		$checkout = APIDoc_file_checkout(sessionKey, $f[16], $f[0], $f[1]);

		$download = APIDoc_file_download(sessionKey, $f[16], $f[0], $f[1]);

		##follow download link, download file and make edits, load new file into contents
		$contents = "";

		$upload = APIDoc_file_upload(sessionKey, $f[16], $f[0], $f[1], $contents);

		$checkin = APIDoc_file_checkin(sessionKey, $f[16], $f[0], $f[1]);
		echo $checkin;
	}
}