package io.point.apidoc;

import org.apache.http.NameValuePair;
import org.apache.http.client.ClientProtocolException;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.CloseableHttpResponse;
import org.apache.http.client.methods.HttpGet;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.client.utils.URIBuilder;
import org.apache.http.entity.mime.MultipartEntityBuilder;
import org.apache.http.entity.mime.content.FileBody;
import org.apache.http.impl.client.CloseableHttpClient;
import org.apache.http.impl.client.HttpClients;
import org.apache.http.message.BasicNameValuePair;
import org.apache.http.util.EntityUtils;
import org.codehaus.jackson.JsonNode;
import org.codehaus.jackson.map.ObjectMapper;
import org.codehaus.jackson.node.ArrayNode;
import org.codehaus.jackson.node.JsonNodeFactory;
import org.codehaus.jackson.node.ObjectNode;

import java.io.File;
import java.io.IOException;
import java.net.URISyntaxException;
import java.util.*;

/**
 * User: jconley
 * Date: 5/5/2014
 */
public class APIDoc {

    private static CloseableHttpClient httpclient = HttpClients.createDefault();
    private static String BASE = "http://api.point.io/api/v2/";
    private static ObjectMapper mapper = new ObjectMapper();

    public static String authenticate(String email, String password, String apiKey) throws IOException {
        HttpPost httpPost = new HttpPost(BASE + "auth.json");

        List<NameValuePair> params = new ArrayList<NameValuePair>();
        params.add(new BasicNameValuePair("email", email));
        params.add(new BasicNameValuePair("password", password));
        params.add(new BasicNameValuePair("apiKey", apiKey));

        CloseableHttpResponse res = null;
        String sessionKey = null;
        try {
            httpPost.setEntity(new UrlEncodedFormEntity(params));
            res = httpclient.execute(httpPost);

            String resBody = EntityUtils.toString(res.getEntity());
            JsonNode jsonBody = mapper.readValue(resBody, JsonNode.class);
            sessionKey = jsonBody.get("RESULT").get("SESSIONKEY").getTextValue();
        } catch (Exception e) {
            e.printStackTrace();
        } finally {
            if(res != null){
                res.close();
            }
        }
        return sessionKey;
    }

    public static ArrayNode listAccessRules(String sessionKey) throws IOException {
        HttpGet httpGet = new HttpGet(BASE + "accessrules/list.json");
        httpGet.addHeader("Authorization", sessionKey);

        CloseableHttpResponse res = null;
        ArrayNode response = null;
        try {
            res = httpclient.execute(httpGet);
            String resBody = EntityUtils.toString(res.getEntity());
//            System.out.println(resBody);
            response = (ArrayNode) mapper.readValue(resBody, JsonNode.class).get("RESULT").get("DATA");
        } catch (ClientProtocolException e) {
            e.printStackTrace();
        } catch (IOException e) {
            e.printStackTrace();
        } finally {
            res.close();
        }

        return response;
    }

    public static ArrayNode listFolders(String sessionKey, String folderId) throws URISyntaxException, IOException {
        URIBuilder uri = new URIBuilder(BASE + "folders/list.json");
        uri.addParameter("folderId", folderId);

        HttpGet httpGet = new HttpGet(uri.build());
        httpGet.addHeader("Authorization", sessionKey);

        CloseableHttpResponse res = null;
        ArrayNode response = null;
        try {
            res = httpclient.execute(httpGet);
            String resBody = EntityUtils.toString(res.getEntity());
            response = (ArrayNode) mapper.readValue(resBody, JsonNode.class).get("RESULT").get("DATA");
        } catch (ClientProtocolException e) {
            e.printStackTrace();
        } catch (IOException e) {
            e.printStackTrace();
        } finally {
            res.close();
        }

        return response;
    }

    public static String filePreview(String sessionKey, String folderId, String fileId, String fileName) throws URISyntaxException, IOException {
        URIBuilder uri = new URIBuilder(BASE + "folders/files/preview.json");
        uri.addParameter("folderid", folderId);
        uri.addParameter("fileid", fileId);
        uri.addParameter("filename", fileName);

        HttpGet httpGet = new HttpGet(uri.build());
        httpGet.addHeader("Authorization", sessionKey);

        CloseableHttpResponse res = null;
        String response = null;
        try {
            res = httpclient.execute(httpGet);
            String resBody = EntityUtils.toString(res.getEntity());
//            System.out.println(resBody);
            response = mapper.readValue(resBody, JsonNode.class).get("RESULT").asText();
        } catch (ClientProtocolException e) {
            e.printStackTrace();
        } catch (IOException e) {
            e.printStackTrace();
        } finally {
            res.close();
        }

        return response;
    }

    public static String fileDownload(String sessionKey, String folderId, String fileId, String fileName) throws URISyntaxException, IOException {
        URIBuilder uri = new URIBuilder(BASE + "folders/files/download.json");
        uri.addParameter("folderid", folderId);
        uri.addParameter("fileid", fileId);
        uri.addParameter("filename", fileName);

        HttpGet httpGet = new HttpGet(uri.build());
        httpGet.addHeader("Authorization", sessionKey);

        CloseableHttpResponse res = null;
        String response = null;
        try {
            res = httpclient.execute(httpGet);
            String resBody = EntityUtils.toString(res.getEntity());
//            System.out.println(resBody);
            response = mapper.readValue(resBody, JsonNode.class).get("RESULT").asText();
        } catch (ClientProtocolException e) {
            e.printStackTrace();
        } catch (IOException e) {
            e.printStackTrace();
        } finally {
            res.close();
        }

        return response;
    }

    public static String fileCreateLink(String sessionKey, String folderId, String fileId, String fileName, String remotePath, String containerId) throws IOException {
        HttpPost httpPost = new HttpPost(BASE + "links/create.json");
        httpPost.addHeader("Authorization", sessionKey);

        List<NameValuePair> params = new ArrayList<NameValuePair>();
        params.add(new BasicNameValuePair("shareid", folderId));
        params.add(new BasicNameValuePair("fileid", fileId));
        params.add(new BasicNameValuePair("filename", fileName));
        params.add(new BasicNameValuePair("remotepath", remotePath));
        params.add(new BasicNameValuePair("containerid", containerId));

        CloseableHttpResponse res = null;
        String response = null;
        try {
            httpPost.setEntity(new UrlEncodedFormEntity(params));
            res = httpclient.execute(httpPost);

            String resBody = EntityUtils.toString(res.getEntity());
//            System.out.println(resBody);
            JsonNode jsonBody = mapper.readValue(resBody, JsonNode.class);
            response = mapper.readValue(resBody, JsonNode.class).get("LINKURL").asText();
        } catch (Exception e) {
            e.printStackTrace();
        } finally {
            if(res != null){
                res.close();
            }
        }
        return response;
    }

    public static String fileUpload(String sessionKey, String folderId, String fileId, String fileName, String fileContentsPath) throws IOException {
        HttpPost httpPost = new HttpPost(BASE + "folders/files/upload.json");
        httpPost.addHeader("Authorization", sessionKey);

        MultipartEntityBuilder body = MultipartEntityBuilder.create();
        body.addTextBody("folderid", folderId);
        body.addTextBody("fileid", fileId);
        body.addTextBody("filename", fileName);
        body.addPart("filecontents", new FileBody(new File(fileContentsPath)));
        httpPost.setEntity(body.build());

        CloseableHttpResponse res = null;
        String response = null;
        try {
            res = httpclient.execute(httpPost);

            System.out.println("Getting upload body");
            System.out.println(res.getStatusLine());
            String resBody = EntityUtils.toString(res.getEntity());
//            JsonNode jsonBody = mapper.readValue(resBody, JsonNode.class);
            response = resBody;
        } catch (Exception e) {
            e.printStackTrace();
        } finally {
            if(res != null){
                res.close();
            }
        }
        return response;
    }

    public static JsonNode checkout(String sessionKey, String folderId, String fileName, String fileId) throws IOException, URISyntaxException {
        URIBuilder uri = new URIBuilder(BASE + "folders/files/checkout.json");
        uri.addParameter("folderid", folderId);
        uri.addParameter("fileid", fileId);
        uri.addParameter("filename", fileName);

        HttpGet httpGet = new HttpGet(uri.build());
        httpGet.addHeader("Authorization", sessionKey);

        CloseableHttpResponse res = null;
        JsonNode response = null;
        try {
            res = httpclient.execute(httpGet);
            String resBody = EntityUtils.toString(res.getEntity());
            response = mapper.readValue(resBody, JsonNode.class);
        } catch (ClientProtocolException e) {
            e.printStackTrace();
        } catch (IOException e) {
            e.printStackTrace();
        } finally {
            res.close();
        }

        return response;
    }

    public static JsonNode checkin(String sessionKey, String folderId, String fileName, String fileId) throws IOException, URISyntaxException {
        URIBuilder uri = new URIBuilder(BASE + "folders/files/checkin.json");
        uri.addParameter("folderid", folderId);
        uri.addParameter("fileid", fileId);
        uri.addParameter("filename", fileName);

        HttpGet httpGet = new HttpGet(uri.build());
        httpGet.addHeader("Authorization", sessionKey);

        CloseableHttpResponse res = null;
        JsonNode response = null;
        try {
            res = httpclient.execute(httpGet);
            String resBody = EntityUtils.toString(res.getEntity());
            response = mapper.readValue(resBody, JsonNode.class);
        } catch (ClientProtocolException e) {
            e.printStackTrace();
        } catch (IOException e) {
            e.printStackTrace();
        } finally {
            res.close();
        }

        return response;
    }

    public static ArrayNode listStorageTypes(String sessionKey) throws IOException {
        HttpGet httpGet = new HttpGet(BASE + "storagetypes/list.json");
        httpGet.addHeader("Authorization", sessionKey);

        CloseableHttpResponse res = null;
        ArrayNode response = null;
        try {
            res = httpclient.execute(httpGet);
            String resBody = EntityUtils.toString(res.getEntity());
//            System.out.println(resBody);
            response = (ArrayNode) mapper.readValue(resBody, JsonNode.class).get("RESULT").get("DATA");
        } catch (ClientProtocolException e) {
            e.printStackTrace();
        } catch (IOException e) {
            e.printStackTrace();
        } finally {
            res.close();
        }

        return response;
    }

    public static ArrayNode getStorageSiteParams(String sessionKey, int siteTypeId) throws IOException {
        HttpGet httpGet = new HttpGet(BASE + "storagetypes/" + siteTypeId + "/params.json");
        httpGet.addHeader("Authorization", sessionKey);

        CloseableHttpResponse res = null;
        ArrayNode response = null;
        try {
            res = httpclient.execute(httpGet);
            String resBody = EntityUtils.toString(res.getEntity());
//            System.out.println(resBody);
            response = (ArrayNode) mapper.readValue(resBody, JsonNode.class).get("RESULT").get("DATA");
        } catch (ClientProtocolException e) {
            e.printStackTrace();
        } catch (IOException e) {
            e.printStackTrace();
        } finally {
            res.close();
        }

        return response;
    }

    public static Map<String, Boolean> getDefaultFlags(){
        Map<String, Boolean> flags = new HashMap<String, Boolean>();
        flags.put("enabled", true);
        flags.put("loggingEnabled", false);
        flags.put("indexingEnabled", false);
        flags.put("revisionControl", false);
        flags.put("maxRevisions", false);
        flags.put("checkinCheckout", false);

        return flags;
    }

    public static JsonNode addStorageSite(String sessionKey, int siteTypeId, String name, Map<String, Boolean> flags, ObjectNode params) throws IOException {
        HttpPost httpPost = new HttpPost(BASE + "storagesites/create.json");
        httpPost.addHeader("Authorization", sessionKey);

        List<NameValuePair> formData = new ArrayList<NameValuePair>();
        formData.add(new BasicNameValuePair("siteTypeId", Integer.toString(siteTypeId)));
        formData.add(new BasicNameValuePair("name", name));
        for(Map.Entry<String, Boolean> flag : flags.entrySet()){
            formData.add(new BasicNameValuePair(flag.getKey(), flag.getValue() ? "1" : "0"));
        }

        formData.add(new BasicNameValuePair("siteArguments", params.toString()));

        CloseableHttpResponse res = null;
        JsonNode response = null;
        try {
            httpPost.setEntity(new UrlEncodedFormEntity(formData));
            res = httpclient.execute(httpPost);

            String resBody = EntityUtils.toString(res.getEntity());
            System.out.println(resBody);
            response = mapper.readValue(resBody, JsonNode.class);
        } catch (Exception e) {
            e.printStackTrace();
        } finally {
            if(res != null){
                res.close();
            }
        }
        return response;
    }
}