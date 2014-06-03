require_relative '../APIDoc.rb'

email, password, apiKey = ARGV[0], ARGV[1], ARGV[2]

apiDoc = APIDoc.new(email, password, apiKey)

sessionKey = apiDoc.sessionKey()

accessRules = apiDoc.listAccessRules(sessionKey)

folders = apiDoc.listFolders(sessionKey, accessRules[2][1])

for f in folders
	if (f[2] == "FILE")
		checkout = apiDoc.fileCheckout(sessionKey, f[16], f[0], f[1])

		download = apiDoc.fileDownload(sessionKey, f[16], f[0], f[1])
		#follow download link, edit file, and upload
		newFileContents = ""

		upload = apiDoc.fileUpload(sessionKey, f[16], f[0], f[1])

		checkin = apiDoc.fileCheckin(sessionKey, f[16], f[0], f[1])
		print(checkin)
	end		
end