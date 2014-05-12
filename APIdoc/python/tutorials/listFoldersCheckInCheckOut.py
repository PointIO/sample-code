import sys, getopt

email, password, apiKey = sys.argv[1], sys.argv[2], sys.argv[3]

exec(open("../APIDoc.py").read())

sessionKey = auth(email, password, apiKey)

accessRules = list_access_rules(sessionKey)

folders = list_folders(sessionKey, accessRules["RESULT"]["DATA"][2][1])["RESULT"]["DATA"]

for f in folders:
	if(f[2] == "FILE"):
		checkout = file_checkout(sessionKey, f[16], f[0], f[1])

		download = file_download(sessionKey, f[16], f[0], f[1])

		#follow download link, edit file, and upload
		newFileContents = ""

		upload = file_upload(sessionKey, f[16], f[0], f[1])

		checkin = file_checkin(sessionKey, f[16], f[0], f[1])
		print(checkin)