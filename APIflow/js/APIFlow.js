var BASE = "http://pf-staging.point.io/";

function auth(email, password, apiKey){
	var sessionKey = ""
	$.ajax({
	  type: "POST",
	  async: false,
	  url: BASE + "auth",
	  data: {'email' :  email ,  'password' :  password ,  'apiKey' :  apiKey},
	  success: function(data){
	  	sessionKey = data.RESULT.SESSIONKEY
	  }
	});

	return sessionKey
}

function listProcesstypes(sessionKey){
	var processtypes = []

	$.ajax({
	  type: "GET",
	  async: false,
	  url: BASE + "processtypes?Authorization=" + sessionKey,
	  success: function(data){
	  	processtypes = data.REQUEST.PROCESSTYPES
	  }
	});	

	return processtypes
}

function startProcess(sessionKey, processName){
	var proc = {};

	$.ajax({
	  type: "POST",
	  async: false,
	  contentType: "application/json",
	  data: {},
	  url: BASE + "processes/" + processName + "?Authorization=" + sessionKey,
	  success: function(data){
	  	proc = data
	  }
	});	

	return proc
}

function startProcessWithMsg(sessionKey, messageName){
	var proc = {};

	$.ajax({
	  type: "POST",
	  async: false,
	  contentType: "application/json",
	  data: {},
	  url: BASE + "messages/" + messageName + "?Authorization=" + sessionKey,
	  success: function(data){
	  	proc = data.RESPONSE.PROCESSID
	  }
	});	

	return proc
}

function getProcess(sessionKey, processId){
	var proc = {}

	$.ajax({
	  type: "GET",
	  async: false,
	  url: BASE + "processes/" + processId + "?Authorization=" + sessionKey,
	  success: function(data){
	  	proc = data.RESPONSE.PROCESS
	  }
	});	

	return proc	
}

function listTasks(sessionKey){
	var proc = {}

	$.ajax({
	  type: "GET",
	  async: false,
	  url: BASE + "tasks?Authorization=" + sessionKey,
	  success: function(data){
	  	proc = data.RESPONSE.GROUPS[0].TASKS
	  }
	});	

	return proc	
}

function completeTask(sessionKey, taskId){
	var res = {}

	$.ajax({
	  type: "PUT",
	  async: false,
	  data: {},
	  contentType: "application/json",
	  url: BASE + "tasks/" + taskId + "?Authorization=" + sessionKey,
	  success: function(data){
	  	res = data
	  }
	});	

	return res
}