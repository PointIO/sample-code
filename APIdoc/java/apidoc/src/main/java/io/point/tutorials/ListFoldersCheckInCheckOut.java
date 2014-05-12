package io.point.tutorials;

import io.point.Pio;
import org.codehaus.jackson.JsonNode;
import org.codehaus.jackson.node.ArrayNode;

import java.util.Iterator;

/**
 * User: jconley
 * Date: 5/6/2014
 */
public class ListFoldersCheckInCheckOut {

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
                Pio.checkout(sessionKey, file.get(16).asText(), file.get(0).asText(), file.get(1).asText());

                String downloadUrl = Pio.fileDownload(sessionKey, file.get(16).asText(), file.get(0).asText(), file.get(1).asText());

                //follow link and download file

                //edit file
                String localPath = "";

                Pio.fileUpload(sessionKey, file.get(16).asText(), file.get(0).asText(), file.get(1).asText(), localPath);

                Pio.checkin(sessionKey, file.get(16).asText(), file.get(0).asText(), file.get(1).asText());

                break;
            }
        }
    }
}
