email, password, apiKey = "", "" ,""

sessionKey = APIDoc_auth(email, password, apiKey)

accessRules = APIDoc_list_access_rules(sessionKey)

folders = APIDoc_list_folders(sessionKey, accessRules["RESULT"]["DATA"][2][1])["RESULT"]["DATA"]

for f in folders:
	if(f[2] == "FILE"):
		checkout = APIDoc_file_checkout(sessionKey, f[16], f[0], f[1])

		download = APIDoc_file_download(sessionKey, f[16], f[0], f[1])

		#follow download link, edit file, and upload
		newFileContents = ""

		upload = APIDoc_file_upload(sessionKey, f[16], f[0], f[1])

		checkin = APIDoc_file_checkin(sessionKey, f[16], f[0], f[1])
		print(checkin)