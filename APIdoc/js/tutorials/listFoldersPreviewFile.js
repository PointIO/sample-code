var email = ""
var password = ""
var apiKey = ""

var sessionKey = auth(email, password, apiKey)
var rules = listAccessRules(sessionKey)
var folders = rules[2]
for(var i = 0; i < folders.length; i++){
	if(folders[i][2] == "FILE"){
		var preview = filePreview(sessionKey, folders[i][16], folders[i][0], folders[i][1])
		console.log(preview)
	}
}