import sys, getopt

exec(open("../APIDoc.py").read())

email, password, apiKey = sys.argv[1], sys.argv[2], sys.argv[3]

sessionKey = auth(email, password, apiKey)

storageTypes = list_storage_types(sessionKey)
aws = storageTypes[0]

params = list_storage_type_params(sessionKey, aws[0])
paramsJson = {}
for p in params:
	paramsJson[p[4]] = ""

flags = default_flags()

create_storage_site(sessionKey, aws[0], "New Storage Site", flags, params)