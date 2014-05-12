require_relative '../APIFlow.rb'

email, password, apiKey = ARGV[0], ARGV[1], ARGV[2]

flow = APIFlow.new(email, password, apiKey)

puts flow.sessionKey()

#key = APIDoc.sessionKey()
#rules = APIDoc.listAccessRules(key)
#folders = APIDoc.listFolders(key, rules[2][1])

#upload = APIDoc.fileUpload(key, folders[0][16], "test.txt", "test.txt", "upload.txt")
#puts upload