email, password, apiKey = "", "" ,""

sessionKey = pio_auth(email, password, apiKey)

accessRules = pio_list_access_rules(sessionKey)

folders = pio_list_folders(sessionKey, accessRules["RESULT"]["DATA"][2][1])["RESULT"]["DATA"]

for f in folders:
	if(f[2] == "FILE"):
		download = pio_file_download(sessionKey, f[16], f[0], f[1])
		print(download)