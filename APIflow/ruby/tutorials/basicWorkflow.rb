require_relative '../APIFlow.rb'

email, password, apiKey = ARGV[0], ARGV[1], ARGV[2]

flow = APIFlow.new(email, password, apiKey)

key = flow.sessionKey()

processtypes = flow.listProcesstypes(key)

for p in processtypes
	if p["name"] == "demo"
		start = flow.startProcess(key, p["name"])
		puts start
	end		
end	