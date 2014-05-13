require 'net/http'
require 'uri'
require 'rubygems'
require 'json'

class APIFlow

	def initialize(email, password, apiKey)
		@BASE = "http://pointflow.point.io/"
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
		uri = URI(@BASE + "processes/" + processName + "?Authorization=" + sessionKey)
		http = Net::HTTP.new(uri.host, uri.port)
		req = Net::HTTP::Post.new(uri.path)
		req["Content-Type"] = "application/json"
		req.set_form_data({})

		res = http.request(req)

		puts res.body
		JSON.parse(res.body)["REQUEST"]["PROCESS"]
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

	# def fileCreateLink(sessionKey, folderId, fileId, fileName, remotePath, containerId)
	# 	uri = URI(@BASE + "links/create.json")
	# 	http = Net::HTTP.new(uri.host, uri.port)
	# 	req = Net::HTTP::Post.new(uri.path)
	# 	req["Authorization"] = sessionKey
	# 	req.set_form_data({"shareid" => folderId, "fileId" => fileId, "fileName" => fileName, "remotePath" => remotePath, "containerId" => containerId})

	# 	res = http.request(req)
	# 	JSON.parse(res.body)["RESULT"]["DATA"]
	# end	

	# def fileCheckout(sessionKey, folderId, fileId, fileName)
	# 	uri = URI(@BASE + "folders/files/checkout.json")
	# 	http = Net::HTTP.new(uri.host, uri.port)
	# 	req = Net::HTTP::Get.new(uri.path)
	# 	req["Authorization"] = sessionKey
	# 	req.set_form_data({"folderId" => folderId, "fileId" => fileId, "fileName" => fileName})

	# 	res = http.request(req)
	# 	JSON.parse(res.body)["RESULT"]["DATA"]
	# end	

	# def fileCheckin(sessionKey, folderId, fileId, fileName)
	# 	uri = URI(@BASE + "folders/files/checkin.json")
	# 	http = Net::HTTP.new(uri.host, uri.port)
	# 	req = Net::HTTP::Get.new(uri.path)
	# 	req["Authorization"] = sessionKey
	# 	req.set_form_data({"folderId" => folderId, "fileId" => fileId, "fileName" => fileName})

	# 	res = http.request(req)
	# 	JSON.parse(res.body)["RESULT"]["DATA"]
	# end	

	# def listStorageTypes(sessionKey)
	# 	uri = URI(@BASE + "storagetypes/list.json")
	# 	http = Net::HTTP.new(uri.host, uri.port)
	# 	req = Net::HTTP::Get.new(uri.path)
	# 	req["Authorization"] = sessionKey

	# 	res = http.request(req)
	# 	JSON.parse(res.body)["RESULT"]["DATA"]
	# end	

	# def listStorageTypeParams(sessionKey, siteTypeId)
	# 	uri = URI(@BASE + "storagetypes/" + siteTypeId + "/list.json")
	# 	http = Net::HTTP.new(uri.host, uri.port)
	# 	req = Net::HTTP::Get.new(uri.path)
	# 	req["Authorization"] = sessionKey

	# 	res = http.request(req)
	# 	JSON.parse(res.body)["RESULT"]["DATA"]
	# end	

	# def defaultStorageFlags
	# 	{
	# 		"enabled"=> "1",
	# 		"loggingEnabled"=> "0",
	# 		"indexingEnabled"=> "0",
	# 		"revisionControl"=> "0",
	# 		"maxRevisions"=> "0",
	# 		"checkinCheckout"=> "0"
	# 	}
	# end

	# def createStorageSite(sessionKey, siteTypeId, name, flags, siteArguments = defaultStorageFlags())
	# 	uri = URI(@BASE + "storagesites/create.json")
	# 	http = Net::HTTP.new(uri.host, uri.port)
	# 	req = Net::HTTP::Post.new(uri.path)
	# 	req["Authorization"] = sessionKey
	# 	req.set_form_data({"siteTypeId" => siteTypeId, "name" => name, "flags" => flags, "siteArguments" => siteArguments})

	# 	res = http.request(req)
	# 	JSON.parse(res.body)["RESULT"]["DATA"]
	# end
end