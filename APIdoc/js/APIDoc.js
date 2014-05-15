var BASE = "http://api.point.io/api/v2/";

function auth(email, password, apiKey){
	var sessionKey = ""
	$.ajax({
	  type: "POST",
	  async: false,
	  url: BASE + "auth.json",
	  data: {'email' :  email ,  'password' :  password ,  'apiKey' :  apiKey},
	  success: function(data){
	  	sessionKey = data.RESULT.SESSIONKEY
	  }
	});

	return sessionKey
}

function listAccessRules(sessionKey){
	var rules = []

	$.ajax({
	  type: "GET",
	  async: false,
	  headers: {"Authorization": sessionKey},
	  url: BASE + "accessrules/list.json",
	  success: function(data){
	  	rules = data.RESULT.DATA
	  }
	});	

	return rules
}

function listFolders(sessionKey, folderId){
	var folders = []

	$.ajax({
	  type: "GET",
	  async: false,
	  data: {"folderId": folderId},
	  headers: {"Authorization": sessionKey},
	  url: BASE + "folders/list.json",
	  success: function(data){
	  	folders = data.RESULT.DATA
	  }
	});	

	return folders
}

function filePreview(sessionKey, folderId, fileId, fileName){
	var preview = {};

	$.ajax({
	  type: "GET",
	  async: false,
	  data: {"folderid": folderId, "fileid": fileId, "filename": fileName},
	  headers: {"Authorization": sessionKey},
	  url: BASE + "folders/files/preview.json",
	  success: function(data){
	  	preview = data
	  }
	});	

	return preview
}

function fileDownload(sessionKey, folderId, fileId, fileName){
	var download = {};

	$.ajax({
	  type: "GET",
	  async: false,
	  data: {"folderid": folderId, "fileid": fileId, "filename": fileName},
	  headers: {"Authorization": sessionKey},
	  url: BASE + "folders/files/download.json",
	  success: function(data){
	  	download = data
	  }
	});	

	return download
}

function fileCreateLink(sessionKey, folderId, fileId, fileName, remotePath, containerId){
	var link = {};

	$.ajax({
	  type: "POST",
	  async: false,
	  data: {"shareid": folderId, "fileid": fileId, "filename": fileName, "remotepath": remotePath, "containerid": containerId},
	  headers: {"Authorization": sessionKey},
	  url: BASE + "links/create.json",
	  success: function(data){
	  	link = data
	  }
	});	

	return link
}

//TODO
function fileUpload(sessionKey, folderId, fileId, formData){
 //    $.ajax({
	//     url: BASE + "folders/files/upload.json",
	//     type: 'POST',
	//     data: formData,
	//     success: function(data){
	//     	console.log(data);
	//     }
	// });
}

function fileCheckout(sessionKey, folderId, fileId, fileName){
	var res = {};

	$.ajax({
	  type: "GET",
	  async: false,
	  data: {"folderid": folderId, "fileid": fileId, "filename": fileName},
	  headers: {"Authorization": sessionKey},
	  url: BASE + "folders/files/checkout.json",
	  success: function(data){
	  	res = data
	  }
	});	

	return res
}

function fileCheckin(sessionKey, folderId, fileId, fileName){
	var res = {};

	$.ajax({
	  type: "GET",
	  async: false,
	  data: {"folderid": folderId, "fileid": fileId, "filename": fileName},
	  headers: {"Authorization": sessionKey},
	  url: BASE + "folders/files/checkin.json",
	  success: function(data){
	  	res = data
	  }
	});	

	return res
}

function listStorageTypes(sessionKey){
	var res = []

	$.ajax({
	  type: "GET",
	  async: false,
	  headers: {"Authorization": sessionKey},
	  url: BASE + "storagetypes/list.json",
	  success: function(data){
	  	res = data.RESULT.DATA
	  }
	});	

	return res
}

function getStorageTypeParams(sessionKey, siteTypeId){
	var res = []

	$.ajax({
	  type: "GET",
	  async: false,
	  headers: {"Authorization": sessionKey},
	  url: BASE + "storagetypes/" + siteTypeId + "/params.json",
	  success: function(data){
	  	res = data.RESULT.DATA
	  }
	});	

	return res
}

function defaultFlags(){
	return {
		"enabled": "1",
		"loggingEnabled": "0",
		"indexingEnabled": "0",
		"revisionControl": "0",
		"maxRevisions": "0",
		"checkinCheckout": "0"
	}
}

function createStorageSite(sessionKey, siteTypeId, name, flags, siteArguments){
	var link = {};

	var params = {"siteTypeId": siteTypeId, "name": name, "siteArguments": siteArguments}
	for (var attrname in flags) { params[attrname] = flags[attrname]; }

	$.ajax({
	  type: "POST",
	  async: false,
	  data: params,
	  headers: {"Authorization": sessionKey},
	  url: BASE + "storagesites/create.json",
	  success: function(data){
	  	link = data
	  }
	});	

	return link
}