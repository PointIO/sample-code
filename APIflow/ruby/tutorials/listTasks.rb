require_relative '../APIFlow.rb'

email, password, apiKey = ARGV[0], ARGV[1], ARGV[2]

flow = APIFlow.new(email, password, apiKey)

sessionKey = flow.sessionKey()
tasks = flow.listTasks(sessionKey)

#review my tasks
for t in tasks
	print(t)
end

#complete tasks with empty body
# flow.completeTask(sessionKey, t["ID"])