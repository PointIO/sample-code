var email = ""
var password = ""
var apiKey = ""

var sessionKey = auth(email, password, apiKey)
var types = listStorageTypes(sessionKey)
var aws = types[0]

var params = listStorageTypeParams(sessionKey, aws[0])
var flags = defaultFlags()

var paramsJson = {}
for(var i = 0; i < params; i++){
	paramsJson[params[i][4]] = ""
}

var newSite = createStorageSite(sessionKey, aws[0], "New Storage Site", paramsJson)