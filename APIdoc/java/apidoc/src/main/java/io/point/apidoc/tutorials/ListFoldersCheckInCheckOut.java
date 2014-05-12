package io.point.apidoc.tutorials;

import io.point.apidoc.APIDoc;
import org.codehaus.jackson.JsonNode;
import org.codehaus.jackson.node.ArrayNode;

import java.util.Iterator;

/**
 * User: jconley
 * Date: 5/6/2014
 */
public class ListFoldersCheckInCheckOut {

    public static void main(String[] args) throws Exception{
        if(args.length != 3){
            System.err.println("Valid arguments are email password apiKey");
            System.exit(-1);
        }

        String email = args[0];
        String password = args[1];
        String apiKey = args[2];

        String sessionKey = APIDoc.authenticate(email, password, apiKey);

        ArrayNode accessRulesArray = APIDoc.listAccessRules(sessionKey);
        JsonNode firstRule = accessRulesArray.get(0);

        ArrayNode folderArray = APIDoc.listFolders(sessionKey, firstRule.get(1).getTextValue());
        Iterator<JsonNode> rootObjects = folderArray.getElements();
        while(rootObjects.hasNext()) {
            ArrayNode file = (ArrayNode)rootObjects.next();

            //if it's a director, create a link for it and exit
            if(file.get(2).getTextValue().equals("FILE")){
                APIDoc.checkout(sessionKey, file.get(16).asText(), file.get(0).asText(), file.get(1).asText());

                String downloadUrl = APIDoc.fileDownload(sessionKey, file.get(16).asText(), file.get(0).asText(), file.get(1).asText());

                //follow link and download file

                //edit file
                String localPath = "";

                APIDoc.fileUpload(sessionKey, file.get(16).asText(), file.get(0).asText(), file.get(1).asText(), localPath);

                APIDoc.checkin(sessionKey, file.get(16).asText(), file.get(0).asText(), file.get(1).asText());

                break;
            }
        }
    }
}
