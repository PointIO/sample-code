var email = ""
var password = ""
var apiKey = ""

var sessionKey = auth(email, password, apiKey)
var rules = listAccessRules(sessionKey)
var folders = rules[2]
for(var i = 0; i < folders.length; i++){
	if(folders[i][2] == "FILE"){
		var link = fileCreateLink(sessionKey, folders[i][16], folders[i][0], folders[i][1], folders[i][4], folders[i][3])
		console.log(link)
	}
}