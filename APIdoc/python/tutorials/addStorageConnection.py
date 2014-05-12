email, password, apiKey = "", "" ,""

sessionKey = pio_auth(email, password, apiKey)

storageTypes = pio_list_storage_types(sessionKey)
aws = storageTypes[0]

params = pio_list_storage_type_params(sessionKey, aws[0])
paramsJson = {}
for p in params:
	paramsJson[p[4]] = ""

flags = pio_default_flags()

pio_create_storage_site(sessionKey, aws[0], "New Storage Site", flags, params)