var BASE = "http://pointflow.point.io/";

function auth(email, password, apiKey){
	var sessionKey = ""
	var params = "?email=" + encodeURIComponent(email) + "&password=" + password + "&apikey=" + apiKey

	$.ajax({
	  type: "POST",
	  async: false,
	  url: BASE + "auth" + params,
	  crossDomain: true,
	  success: function(data){
	  	sessionKey = data.RESULT.SESSIONKEY
	  }
	});

	return sessionKey
}

