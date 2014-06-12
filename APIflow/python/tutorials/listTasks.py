import sys, getopt

exec(open("../APIFlow.py").read())

email, password, apiKey = sys.argv[1], sys.argv[2], sys.argv[3]

sessionKey = auth(email, password, apiKey)
tasks = listTasks(sessionKey)

#review my tasks
for t in tasks:
	print(t)

#complete tasks with empty json body
# completeTask(sessionKey, t["ID"])