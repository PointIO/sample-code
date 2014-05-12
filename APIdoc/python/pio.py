import requests
import urllib.parse
import json

BASE = "http://api.point.io/api/v2/";

def pio_auth(email, password, apiKey):
	params =  {'email' :  email ,  'password' :  password ,  'apiKey' :  apiKey}
	r = requests.post(BASE  + "auth.json", data=params)
	return r.json()

def pio_auth_header(sessionKey):
	return {"Authorization" : sessionKey}

def pio_list_access_rules(sessionKey):
	r = requests.get(BASE + "accessrules/list.json", headers=pio_auth_header(sessionKey))
	return r.json()

def pio_list_folders(sessionKey, folderId):
	params = {"folderId": folderId}
	r = requests.get(BASE + "folders/list.json", headers=pio_auth_header(sessionKey), params=params)
	return r.json()

def pio_file_preview(sessionKey, folderId, fileId, fileName):
	params = {"folderid": folderId, "fileid": fileId, "filename": fileName}
	r = requests.get(BASE + "folders/files/preview.json", headers=pio_auth_header(sessionKey), params=params)
	return r.json()

def pio_file_download(sessionKey, folderId, fileId, fileName):
	params = {"folderid": folderId, "fileid": fileId, "filename": fileName}
	r = requests.get(BASE + "folders/files/download.json", headers=pio_auth_header(sessionKey), params=params)
	return r.json()		

def pio_file_create_link(sessionKey, folderId, fileId, fileName, remotePath, containerId):
	params = {"shareid": folderId, "fileid": fileId, "filename": fileName, "remotepath": remotePath, "containerid": containerId}
	r = requests.post(BASE + "links/create.json", headers=pio_auth_header(sessionKey), data=params)
	return r.json()	

#RFC1867
def pio_file_upload(sessionKey, folderId, fileId, fileName, fileContents):
	params = {"folderid": folderId, "fileid": fileId, "filename": fileName, "filecontents": fileContents}
	r = requests.post(BASE + "folders/files/upload.json", headers=pio_auth_header(sessionKey), data=params)
	return r.json()

def pio_file_checkout(sessionKey, folderId, fileId, fileName):
	params = {"folderid": folderId, "fileid": fileId, "filename": fileName}
	r = requests.get(BASE + "folders/files/checkout.json", headers=pio_auth_header(sessionKey), params=params)
	return r.json()		

def pio_file_checkin(sessionKey, folderId, fileId, fileName):
	params = {"folderid": folderId, "fileid": fileId, "filename": fileName}
	r = requests.get(BASE + "folders/files/checkout.json", headers=pio_auth_header(sessionKey), params=params)
	return r.json()		

def pio_list_storage_types(sessionKey):
	r = requests.get(BASE + "storagetypes/list.json", headers=pio_auth_header(sessionKey))
	return r.json()

def pio_list_storage_type_params(sessionKey, siteTypeId):
	r = requests.get(BASE + "storagetypes/" + siteTypeId + "/params.json", headers=pio_auth_header(sessionKey))
	return r.json()

def pio_default_flags:
	return {
		"enabled": "1",
		"loggingEnabled": "0",
		"indexingEnabled": "0",
		"revisionControl": "0",
		"maxRevisions": "0",
		"checkinCheckout": "0"
	}

def pio_create_storage_site(sessionKey, siteTypeId, name, flags, siteArguments)	:
	params = {"siteTypeId": siteTypeId, "name": name, flags, "siteArguments": siteArguments}
	r = requests.post(BASE + "storagesites/create.json", headers=pio_auth_header(sessionKey), data=params)
	return r.json()	

#auth using demo creds
(email, password, apiKey) = ("", "", "")

sessionKey = pio_auth(email, password, apiKey)["RESULT"]["SESSIONKEY"]

#list access rules
accessRules = pio_list_access_rules(sessionKey)

#get all objects (either file or dir)
allObjects = []
for row in accessRules["RESULT"]["DATA"]:
	objects = pio_list_folders(sessionKey, row[1])["RESULT"]["DATA"]
	for o in objects:
		allObjects.append(o)

print(len(allObjects))

#partition
folders = [o for o in allObjects if o[2] == "DIR"]
files = [o for o in allObjects if o[2] == "FILE"]

print(len(folders))
print(len(files))

#create link for the first file
# file = files[0]
# print(file)
# newLink = pio_file_create_link(sessionKey, file[16], file[0], file[1], file[4], file[3])
# print(newLink)

#upload local file
dir = folders[16]
print(dir)
res = pio_file_upload(sessionKey, dir[16], "test.txt", "test.txt", open("upload.txt", 'rb'))
print(res)