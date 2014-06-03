require_relative '../APIDoc.rb'

email, password, apiKey = ARGV[0], ARGV[1], ARGV[2]

apiDoc = APIDoc.new(email, password, apiKey)

sessionKey = apiDoc.sessionKey()

accessRules = apiDoc.listAccessRules(sessionKey)

folders = apiDoc.listFolders(sessionKey, accessRules[2][1])

for f in folders
	if (f[2] == "FILE")
		preview = apiDoc.filePreview(sessionKey, f[16], f[0], f[1])
		print(preview)
	end		
end