require 'net/http'
require 'rubygems'
require 'json'

class APIDoc

	def initialize(email, password, apiKey)
		@BASE = "http://api.point.io/api/v2/"
		@email = email
		@password = password
		@apiKey = apiKey			
	end		

	def sessionKey(email = @email, password = @password, apiKey = @apiKey)		
		uri = URI(@BASE + "auth.json")
		res = Net::HTTP.post_form(uri, "email" => email, "password" => password, "apiKey" => apiKey)
		JSON.parse(res.body)["RESULT"]["SESSIONKEY"]
	end	

	def listAccessRules(sessionKey)
		uri = URI(@BASE + "accessrules/list.json")
		http = Net::HTTP.new(uri.host, uri.port)
		req = Net::HTTP::Get.new(uri.path)
		req["Authorization"] = sessionKey

		res = http.request(req)
		JSON.parse(res.body)["RESULT"]["DATA"]
	end		

	def listFolders(sessionKey, folderId)
		uri = URI(@BASE + "folders/list.json")
		http = Net::HTTP.new(uri.host, uri.port)
		req = Net::HTTP::Get.new(uri.path)
		req["Authorization"] = sessionKey
		req.set_form_data({"folderId" => folderId})

		res = http.request(req)
		JSON.parse(res.body)["RESULT"]["DATA"]
	end	

	def filePreview(sessionKey, folderId, fileId, fileName)
		uri = URI(@BASE + "folders/files/preview.json")
		http = Net::HTTP.new(uri.host, uri.port)
		req = Net::HTTP::Get.new(uri.path)
		req["Authorization"] = sessionKey
		req.set_form_data({"folderId" => folderId, "fileId" => fileId, "fileName" => fileName})

		res = http.request(req)
		JSON.parse(res.body)["RESULT"]["DATA"]
	end

	def fileDownload(sessionKey, folderId, fileId, fileName)
		uri = URI(@BASE + "folders/files/download.json")
		http = Net::HTTP.new(uri.host, uri.port)
		req = Net::HTTP::Get.new(uri.path)
		req["Authorization"] = sessionKey
		req.set_form_data({"folderId" => folderId, "fileId" => fileId, "fileName" => fileName})

		res = http.request(req)
		JSON.parse(res.body)["RESULT"]["DATA"]
	end	

	def fileUpload(sessionKey, folderId, fileId, fileName, filePath)
		uri = URI(@BASE + "folders/files/upload.json")
		http = Net::HTTP.new(uri.host, uri.port)
		req = Net::HTTP::Post.new(uri.path)
		req["Authorization"] = sessionKey
		# req.body_stream=File.open(filePath)
		req["Content-Type"] = "multipart/form-data"
		# req.add_field('Content-Length', File.size(filePath))
		req.set_form_data({"folderId" => folderId, "fileId" => fileId, "fileName" => fileName, "filecontents" => "@upload.txt"})

		res = http.request(req)
		JSON.parse(res.body)
	end	

	def fileCreateLink(sessionKey, folderId, fileId, fileName, remotePath, containerId)
		uri = URI(@BASE + "links/create.json")
		http = Net::HTTP.new(uri.host, uri.port)
		req = Net::HTTP::Post.new(uri.path)
		req["Authorization"] = sessionKey
		req.set_form_data({"shareid" => folderId, "fileId" => fileId, "fileName" => fileName, "remotePath" => remotePath, "containerId" => containerId})

		res = http.request(req)
		JSON.parse(res.body)["RESULT"]["DATA"]
	end	

	def fileCheckout(sessionKey, folderId, fileId, fileName)
		uri = URI(@BASE + "folders/files/checkout.json")
		http = Net::HTTP.new(uri.host, uri.port)
		req = Net::HTTP::Get.new(uri.path)
		req["Authorization"] = sessionKey
		req.set_form_data({"folderId" => folderId, "fileId" => fileId, "fileName" => fileName})

		res = http.request(req)
		JSON.parse(res.body)["RESULT"]["DATA"]
	end	

	def fileCheckin(sessionKey, folderId, fileId, fileName)
		uri = URI(@BASE + "folders/files/checkin.json")
		http = Net::HTTP.new(uri.host, uri.port)
		req = Net::HTTP::Get.new(uri.path)
		req["Authorization"] = sessionKey
		req.set_form_data({"folderId" => folderId, "fileId" => fileId, "fileName" => fileName})

		res = http.request(req)
		JSON.parse(res.body)["RESULT"]["DATA"]
	end	

	def listStorageTypes(sessionKey)
		uri = URI(@BASE + "storagetypes/list.json")
		http = Net::HTTP.new(uri.host, uri.port)
		req = Net::HTTP::Get.new(uri.path)
		req["Authorization"] = sessionKey

		res = http.request(req)
		JSON.parse(res.body)["RESULT"]["DATA"]
	end	

	def listStorageTypeParams(sessionKey, siteTypeId)
		uri = URI(@BASE + "storagetypes/" + siteTypeId + "/list.json")
		http = Net::HTTP.new(uri.host, uri.port)
		req = Net::HTTP::Get.new(uri.path)
		req["Authorization"] = sessionKey

		res = http.request(req)
		JSON.parse(res.body)["RESULT"]["DATA"]
	end	

	def defaultStorageFlags
		{
			"enabled"=> "1",
			"loggingEnabled"=> "0",
			"indexingEnabled"=> "0",
			"revisionControl"=> "0",
			"maxRevisions"=> "0",
			"checkinCheckout"=> "0"
		}
	end

	def createStorageSite(sessionKey, siteTypeId, name, flags, siteArguments = defaultStorageFlags())
		uri = URI(@BASE + "storagesites/create.json")
		http = Net::HTTP.new(uri.host, uri.port)
		req = Net::HTTP::Post.new(uri.path)
		req["Authorization"] = sessionKey
		req.set_form_data({"siteTypeId" => siteTypeId, "name" => name, "flags" => flags, "siteArguments" => siteArguments})

		res = http.request(req)
		JSON.parse(res.body)["RESULT"]["DATA"]
	end
end

email, password, apiKey = "", "", ""

APIDoc = APIDoc.new(email, password, apiKey)
key = APIDoc.sessionKey()
rules = APIDoc.listAccessRules(key)
folders = APIDoc.listFolders(key, rules[2][1])

upload = APIDoc.fileUpload(key, folders[0][16], "test.txt", "test.txt", "upload.txt")
puts upload