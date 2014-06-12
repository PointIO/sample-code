var email = ""
var password = ""
var apiKey = ""

var sessionKey = auth(email, password, apiKey)
var tasks = listTasks(sessionKey)
for(var i = 0; i < tasks.length; i++){
	console.log(tasks[i]);
}