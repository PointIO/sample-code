email, password, apiKey = "", "" ,""

sessionKey = pio_auth(email, password, apiKey)

accessRules = pio_list_access_rules(sessionKey)

folders = pio_list_folders(sessionKey, accessRules["RESULT"]["DATA"][2][1])["RESULT"]["DATA"]

for f in folders:
	if(f[2] == "FILE"):
		checkout = pio_file_checkout(sessionKey, f[16], f[0], f[1])

		download = pio_file_download(sessionKey, f[16], f[0], f[1])

		#follow download link, edit file, and upload
		newFileContents = ""

		upload = pio_file_upload(sessionKey, f[16], f[0], f[1])

		checkin = pio_file_checkin(sessionKey, f[16], f[0], f[1])
		print(checkin)