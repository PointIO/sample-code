import sys, getopt

exec(open("../APIFlow.py").read())

email, password, apiKey = sys.argv[1], sys.argv[2], sys.argv[3]

sessionKey = auth(email, password, apiKey)

#we've already setup simple.bpmn20.xml on staging
processId = startProcessWithMsg(sessionKey, "simpleMsg")
process = getProcess(sessionKey, processId)

#complete tasks with empty json body
for t in process["TASKS"]:
	res = completeTask(sessionKey, t["ID"])
	print(res)