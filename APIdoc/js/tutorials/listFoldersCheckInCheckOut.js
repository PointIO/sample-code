var email = ""
var password = ""
var apiKey = ""

var sessionKey = auth(email, password, apiKey)
var rules = listAccessRules(sessionKey)
var folders = rules[2]
var file = {}
for(var i = 0; i < folders.length; i++){
	if(folders[i][2] == "FILE"){
		file = folders[i];
	}
}

//checkout
var checkout = fileCheckout(sessionKey, file[16], file[0], file[1])
console.log(checkout)

//download
var download = fileDownload(sessionKey, file[16], file[0], file[1])
console.log(download)

//edit file from download


//upload
var upload = fileUpload(sessionKey, file[16], file[0], file[1])
console.log(upload)

//check back in
var checkout = fileCheckout(sessionKey, file[16], file[0], file[1])
console.log(checkout)