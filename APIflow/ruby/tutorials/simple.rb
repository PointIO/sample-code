require_relative '../APIFlow.rb'

email, password, apiKey = ARGV[0], ARGV[1], ARGV[2]

flow = APIFlow.new(email, password, apiKey)

sessionKey = flow.sessionKey()

processtypes = flow.listProcesstypes(sessionKey)

for p in processtypes
	if p["name"] == "simple"
		procAck = flow.startProcess(sessionKey, p["name"])
		process = flow.getProcess(sessionKey, procAck["id"])
		for t in process["TASKS"]
			res = flow.completeTask(sessionKey, t["ID"])
			print(res)
		end
	end		
end