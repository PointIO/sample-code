import sys, getopt

email, password, apiKey = sys.argv[1], sys.argv[2], sys.argv[3]

exec(open("../APIDoc.py").read())

sessionKey = auth(email, password, apiKey)

accessRules = list_access_rules(sessionKey)

folders = list_folders(sessionKey, accessRules["RESULT"]["DATA"][2][1])["RESULT"]["DATA"]

for f in folders:
	if(f[2] == "FILE"):
		link = file_create_link(sessionKey, f[16], f[0], f[1], f[4], f[3])
		print(link)