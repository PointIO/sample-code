package io.point.apidoc.tutorials;

import io.point.apidoc.APIDoc;
import org.codehaus.jackson.JsonNode;
import org.codehaus.jackson.node.ArrayNode;
import org.codehaus.jackson.node.JsonNodeFactory;
import org.codehaus.jackson.node.ObjectNode;

import java.util.Iterator;

/**
 * User: jconley
 * Date: 5/6/2014
 */
public class AddStorageConnection {

    public static void main(String[] args) throws Exception{
        if(args.length != 3){
            System.err.println("Valid arguments are email password apiKey");
            System.exit(-1);
        }

        String email = args[0];
        String password = args[1];
        String apiKey = args[2];

        String sessionKey = APIDoc.authenticate(email, password, apiKey);

        ArrayNode storageTypesArray = APIDoc.listStorageTypes(sessionKey);
        JsonNode firstType = storageTypesArray.get(0);

        ArrayNode paramsArray = APIDoc.getStorageSiteParams(sessionKey, firstType.get(0).asInt());

        ObjectNode params = JsonNodeFactory.instance.objectNode();
        Iterator<JsonNode> rootObjects = paramsArray.getElements();
        while(rootObjects.hasNext()) {
            ArrayNode file = (ArrayNode)rootObjects.next();
            params.put(file.get(4).asText(), "");
        }

        APIDoc.addStorageSite(sessionKey, firstType.get(0).asInt(), "Joe Test", APIDoc.getDefaultFlags(), params);
    }
}
