import requests
import urllib.parse
import json
import sys, getopt

BASE = "http://pf-staging.point.io/";

def auth(email, password, apiKey):
	params =  {'email' :  email ,  'password' :  password ,  'apikey' :  apiKey}
	r = requests.post(BASE + "auth", params=params)
	return r.json()["RESULT"]["SESSIONKEY"]

def listProcesstypes(sessionKey):
	params =  {'Authorization' :  sessionKey}
	r = requests.get(BASE + "processtypes", params=params)
	return r.json()["REQUEST"]["PROCESSTYPES"]

def startProcess(sessionKey, processName):
	params =  {'Authorization' :  sessionKey}
	headers = {'content-type': 'application/json'}
	r = requests.post(BASE + "processes/" + processName, params=params, data="{}", headers=headers)
	return r.json()["REQUEST"]["PROCESS"]

def startProcessWithMsg(sessionKey, messageName, messageJson="{}"):
	params =  {'Authorization' :  sessionKey}
	headers = {'content-type': 'application/json'}
	r = requests.post(BASE + "messages/" + messageName, params=params, data="{}", headers=headers)
	return r.json()["RESPONSE"]["PROCESSID"]

def getProcess(sessionKey, processId):
	params =  {'Authorization' :  sessionKey}
	r = requests.get(BASE + "processes/" + processId, params=params)
	return r.json()["RESPONSE"]["PROCESS"]

def listTasks(sessionKey):
	params =  {'Authorization' :  sessionKey}
	r = requests.get(BASE + "tasks", params=params)
	return r.json()["RESPONSE"]["GROUPS"]["TASKS"]	

def completeTask(sessionKey, taskId, bodyJson="{}"):
	params =  {'Authorization' :  sessionKey}
	headers = {'content-type': 'application/json'}
	r = requests.put(BASE + "tasks/" + taskId, params=params, data=bodyJson, headers=headers)
	return r.json()