package io.point.tutorials;

import io.point.Pio;
import org.codehaus.jackson.JsonNode;
import org.codehaus.jackson.node.ArrayNode;

import java.util.Iterator;

/**
 * User: jconley
 * Date: 5/6/2014
 */
public class ListFoldersCreateLink {

    public static void main(String[] args) throws Exception{
        String email = "";
        String password = "";
        String apiKey = "";

        String sessionKey = authenticate(email, password, apiKey);

        ArrayNode accessRulesArray = Pio.listAccessRules(sessionKey);
        JsonNode firstRule = accessRulesArray.get(0);

        ArrayNode folderArray = Pio.listFolders(sessionKey, firstRule.get(1).getTextValue());
        Iterator<JsonNode> rootObjects = folderArray.getElements();
        while(rootObjects.hasNext()) {
            ArrayNode file = (ArrayNode)rootObjects.next();

            //if it's a director, create a link for it and exit
            if(file.get(2).getTextValue().equals("FILE")){
                String link = Pio.fileCreateLink(sessionKey, file.get(16).asText(), file.get(0).asText(), file.get(1).asText(), file.get(4).asText(), file.get(3).asText());
                System.out.println(link);
                break;
            }
        }
    }
}
