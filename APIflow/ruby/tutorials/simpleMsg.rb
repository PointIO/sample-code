require_relative '../APIFlow.rb'

email, password, apiKey = ARGV[0], ARGV[1], ARGV[2]

flow = APIFlow.new(email, password, apiKey)

sessionKey = flow.sessionKey()

#we've already setup simple.bpmn20.xml on staging
processId = flow.startProcessWithMsg(sessionKey, "simpleMsg")
process = flow.getProcess(sessionKey, processId)

#complete tasks with empty json body
for t in process["TASKS"]
	res = flow.completeTask(sessionKey, t["ID"])
	print(res)
end