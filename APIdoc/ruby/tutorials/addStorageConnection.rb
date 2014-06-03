require_relative '../APIDoc.rb'

email, password, apiKey = ARGV[0], ARGV[1], ARGV[2]

apiDoc = APIDoc.new(email, password, apiKey)

sessionKey = apiDoc.sessionKey()

storageTypes = apiDoc.listStorageTypes(sessionKey)
aws = storageTypes[0]

params = apiDoc.listStorageTypeParams(sessionKey, aws[0])
paramsJson = {}
for p in params:
	paramsJson[p[4]] = ""

apiDoc.createStorageSite(sessionKey, aws[0], "New Storage Site", apiDoc.defaultFlags(), params)