var email = ""
var password = ""
var apiKey = ""

var sessionKey = auth(email, password, apiKey)
var processTypes = listProcessTypes(sessionKey)
for(var i = 0; i < processTypes.length; i++){
	if(processTypes[i].name == "simple"){
		var procAck = startProcess(sessionKey, "simple")
		var process = getProcess(sessionKey, procAck.id)

		for(var t = 0; t < process.tasks.length; t++){
			var res = completeTask(sessionKey, t.ID);
			console.log(res);
		}

	}
}