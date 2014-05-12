package io.point.apiflow.tutorials;

import io.point.apiflow.APIFlow;
import org.codehaus.jackson.JsonNode;
import org.codehaus.jackson.node.ArrayNode;

import java.util.Iterator;

/**
 * User: jconley
 * Date: 5/6/2014
 */
public class Test {

    public static void main(String[] args) throws Exception{
        if(args.length != 3){
            System.err.println("Valid arguments are email password apiKey");
            System.exit(-1);
        }

        String email = args[0];
        String password = args[1];
        String apiKey = args[2];

        String sessionKey = APIFlow.authenticate(email, password, apiKey);
        ArrayNode processTypesArray = APIFlow.listProcessTypes(sessionKey);

        Iterator<JsonNode> processTypes = processTypesArray.getElements();
        while(processTypes.hasNext()) {
            JsonNode processType = processTypes.next();
            System.out.println(processType.toString());
        }
    }
}