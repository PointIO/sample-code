require 'net/http'
require 'uri'
require 'rubygems'
require 'json'

class APIFlow

	def initialize(email, password, apiKey)
		@BASE = "http://pf-staging.point.io/"
		@email = email
		@password = password
		@apiKey = apiKey			
	end		

	def sessionKey(email = @email, password = @password, apiKey = @apiKey)		
		uri = URI(@BASE + "auth?email=" + URI.encode(email) + "&password=" + URI.encode(password) + "&apikey=" + URI.encode(apiKey))
		res = Net::HTTP.post_form(uri, {})

		JSON.parse(res.body)["RESULT"]["SESSIONKEY"]
	end	

	def listProcesstypes(sessionKey)
		uri = URI(@BASE + "processtypes?Authorization=" + sessionKey)
		res = Net::HTTP.get_response(uri)
		JSON.parse(res.body)["REQUEST"]["PROCESSTYPES"]
	end		

	def startProcess(sessionKey, processName)
		uri = URI(@BASE + "processes/" + processName)

		http = Net::HTTP.new(uri.host, uri.port)		
		req = Net::HTTP::Post.new(uri.path + "?Authorization=" + sessionKey)
		req.body = "{}"
		req.content_type = 'application/json'

		res = http.request(req)
		JSON.parse(res.body)["REQUEST"]["PROCESS"]
	end		

	def startProcessWithMsg(sessionKey, messageName, messageJson = "{}")
		uri = URI(@BASE + "messages/" + messageName)

		http = Net::HTTP.new(uri.host, uri.port)		
		req = Net::HTTP::Post.new(uri.path + "?Authorization=" + sessionKey)
		req.body = messageJson
		req.content_type = 'application/json'

		res = http.request(req)
		JSON.parse(res.body)["RESPONSE"]["PROCESSID"]
	end	

	def getProcess(sessionKey, processId)
		uri = URI(@BASE + "processes/" + processId + "?Authorization=" + sessionKey)
		res = Net::HTTP.get_response(uri)
		JSON.parse(res.body)["RESPONSE"]["PROCESS"]
	end		

	def listTasks(sessionKey)
		uri = URI(@BASE + "tasks?Authorization=" + sessionKey)
		res = Net::HTTP.get_response(uri)
		JSON.parse(res.body)["RESPONSE"]["GROUPS"][0]["TASKS"]
	end	

	def completeTask(sessionKey, taskId, bodyJson = "{}")
		uri = URI(@BASE + "tasks/" + taskId)

		http = Net::HTTP.new(uri.host, uri.port)		
		req = Net::HTTP::Put.new(uri.path + "?Authorization=" + sessionKey)
		req.body = bodyJson
		req.content_type = 'application/json'

		res = http.request(req)
		JSON.parse(res.body)
	end	


	# def fileUpload(sessionKey, folderId, fileId, fileName, filePath)
	# 	uri = URI(@BASE + "folders/files/upload.json")
	# 	http = Net::HTTP.new(uri.host, uri.port)
	# 	req = Net::HTTP::Post.new(uri.path)
	# 	req["Authorization"] = sessionKey
	# 	# req.body_stream=File.open(filePath)
	# 	req["Content-Type"] = "multipart/form-data"
	# 	# req.add_field('Content-Length', File.size(filePath))
	# 	req.set_form_data({"folderId" => folderId, "fileId" => fileId, "fileName" => fileName, "filecontents" => "@upload.txt"})

	# 	res = http.request(req)
	# 	JSON.parse(res.body)
	# end
end