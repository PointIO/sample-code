import sys, getopt

exec(open("../APIFlow.py").read())

email, password, apiKey = sys.argv[1], sys.argv[2], sys.argv[3]

sessionKey = auth(email, password, apiKey)

processTypes = listProcesstypes(sessionKey)

for d in processTypes:
	if(d["name"] == "demo"):
		procAck = startProcess(sessionKey, d["name"])
		process = getProcess(sessionKey, procAck["id"])
		for t in process["TASKS"]:
			res = completeTask(sessionKey, t["ID"])
			print(res)