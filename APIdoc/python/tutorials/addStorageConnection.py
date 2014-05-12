email, password, apiKey = "", "" ,""

sessionKey = APIDoc_auth(email, password, apiKey)

storageTypes = APIDoc_list_storage_types(sessionKey)
aws = storageTypes[0]

params = APIDoc_list_storage_type_params(sessionKey, aws[0])
paramsJson = {}
for p in params:
	paramsJson[p[4]] = ""

flags = APIDoc_default_flags()

APIDoc_create_storage_site(sessionKey, aws[0], "New Storage Site", flags, params)