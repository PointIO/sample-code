var email = ""
var password = ""
var apiKey = ""

var sessionKey = auth(email, password, apiKey)
var processId = startProcessWithMsg(sessionKey, "simpleMsg")
var process = getProcess(sessionKey, processId)

for(var t = 0; t < process.tasks.length; t++){
	var res = completeTask(sessionKey, t.ID);
	console.log(res);
}