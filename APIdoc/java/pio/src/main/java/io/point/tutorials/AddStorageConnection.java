package io.point.tutorials;

import io.point.Pio;
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
        String email = "";
        String password = "";
        String apiKey = "";

        String sessionKey = authenticate(email, password, apiKey);

        ArrayNode storageTypesArray = Pio.listStorageTypes(sessionKey);
        JsonNode firstType = storageTypesArray.get(0);

        ArrayNode paramsArray = Pio.getStorageSiteParams(sessionKey, firstType.get(0).asInt());

        ObjectNode params = JsonNodeFactory.instance.objectNode();
        Iterator<JsonNode> rootObjects = paramsArray.getElements();
        while(rootObjects.hasNext()) {
            ArrayNode file = (ArrayNode)rootObjects.next();
            params.put(file.get(4).asText(), "");
        }

        Pio.addStorageSite(sessionKey, firstType.get(0).asInt(), "Joe Test", Pio.getDefaultFlags(), params);
    }
}
