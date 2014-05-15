package io.point.apiflow.tutorials;

import io.point.apiflow.APIFlow;
import org.codehaus.jackson.JsonNode;
import org.codehaus.jackson.map.ObjectMapper;
import org.codehaus.jackson.node.ArrayNode;
import org.codehaus.jackson.node.ObjectNode;

import java.util.Iterator;

/**
 * User: jconley
 * Date: 5/6/2014
 */
public class SimpleMsg {

    public static void main(String[] args) throws Exception{
        if(args.length != 3){
            System.err.println("Valid arguments are email password apiKey");
            System.exit(-1);
        }

        //auth
        String email = args[0];
        String password = args[1];
        String apiKey = args[2];
        String sessionKey = APIFlow.authenticate(email, password, apiKey);

        Integer processId = APIFlow.startProcessWithMsg(sessionKey, "simpleMsg");

        //get the process we just started
        JsonNode newProcess = APIFlow.getProcess(sessionKey, processId);

        //complete all tasks with empty body
        ObjectNode body = new ObjectMapper().createObjectNode();
        Iterator<JsonNode> tasks = ((ArrayNode)newProcess.get("TASKS")).getElements();
        while(tasks.hasNext()){
            JsonNode task = tasks.next();
            JsonNode res = APIFlow.completeTask(sessionKey, task.get("ID").asInt(), body);
            System.out.println(res);
        }
    }
}