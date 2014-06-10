// A Hello World! program in C#. 
using System;
using System.Net;
using System.IO;
using System.Collections;
using System.Collections.Generic;
using System.Web.Script.Serialization;

namespace Pio{
    public class APIDoc{
        public static String BASE = "http://api.point.io/api/v2/";

        public static string authenticate(String email, String password, String apiKey){
            string parameters = "?email=" + email + "&password=" + password + "&apiKey=" + apiKey;

            //POST
            WebRequest req = WebRequest.Create(BASE + "auth.json" + parameters);
            req.ContentType = "application/x-www-form-urlencoded";
            req.Method = "POST"; 

            WebResponse res = req.GetResponse();
            String body = new System.IO.StreamReader(res.GetResponseStream()).ReadToEnd().ToString();

            var jss = new JavaScriptSerializer();
            var dict = jss.Deserialize<Dictionary<string,dynamic>>(body);

            return dict["RESULT"]["SESSIONKEY"];
        }


        public static ArrayList listAccessRules(String sessionKey) {
            WebRequest req = WebRequest.Create(BASE + "accessrules/list.json");
            req.Headers.Add("Authorization", sessionKey);

            WebResponse res = req.GetResponse();
            String body = new System.IO.StreamReader(res.GetResponseStream()).ReadToEnd().ToString();

            var jss = new JavaScriptSerializer();
            var dict = jss.Deserialize<Dictionary<string,dynamic>>(body);
            
            return dict["RESULT"]["DATA"];
        }

        public static ArrayList listFolders(String sessionKey, String folderId) {
            WebRequest req = WebRequest.Create(BASE + "folders/list.json?folderId=" + folderId);
            req.Headers.Add("Authorization", sessionKey);

            WebResponse res = req.GetResponse();
            String body = new System.IO.StreamReader(res.GetResponseStream()).ReadToEnd().ToString();

            var jss = new JavaScriptSerializer();
            var dict = jss.Deserialize<Dictionary<string,dynamic>>(body);
            
            return dict["RESULT"]["DATA"];
        }


        public static string filePreview(String sessionKey, String folderId, String fileId, String fileName) {
            String parameters = "folderid=" + folderId + "&fileid=" + fileId + "&filename=" + fileName;
            WebRequest req = WebRequest.Create(BASE + "folders/files/preview.json?" + parameters);
            req.Headers.Add("Authorization", sessionKey);

            WebResponse res = req.GetResponse();
            String body = new System.IO.StreamReader(res.GetResponseStream()).ReadToEnd().ToString();

            var jss = new JavaScriptSerializer();
            var dict = jss.Deserialize<Dictionary<string,dynamic>>(body);
            
            return dict["RESULT"];
        }

        public static string fileDownload(String sessionKey, String folderId, String fileId, String fileName) {
            String parameters = "folderid=" + folderId + "&fileid=" + fileId + "&filename=" + fileName;
            WebRequest req = WebRequest.Create(BASE + "folders/files/download.json?" + parameters);
            req.Headers.Add("Authorization", sessionKey);

            WebResponse res = req.GetResponse();
            String body = new System.IO.StreamReader(res.GetResponseStream()).ReadToEnd().ToString();

            var jss = new JavaScriptSerializer();
            var dict = jss.Deserialize<Dictionary<string,dynamic>>(body);
            
            return dict["RESULT"];
        }

        public static string fileCreateLink(String sessionKey, String folderId, String fileId, String fileName, String remotePath, String containerId){
            string parameters = "?shareid=" + folderId + "&fileid=" + fileId + "&filename=" + fileName + "&remotepath=" + remotePath + "&containerid=" + containerId;

            //POST
            WebRequest req = WebRequest.Create(BASE + "links/create.json" + parameters);
            req.ContentType = "application/x-www-form-urlencoded";
            req.Method = "POST"; 
            req.Headers.Add("Authorization", sessionKey);

            //body
            // byte [] bytes = System.Text.Encoding.ASCII.GetBytes(parameters);
            // req.ContentLength = bytes.Length;
            // System.IO.Stream os = req.GetRequestStream ();
            // os.Write (bytes, 0, bytes.Length); //Push it out there
            // os.Close ();

            WebResponse res = req.GetResponse();
            String body = new System.IO.StreamReader(res.GetResponseStream()).ReadToEnd().ToString();
            Console.WriteLine(body);

            var jss = new JavaScriptSerializer();
            var dict = jss.Deserialize<Dictionary<string,dynamic>>(body);

            return dict["LINKURL"];
        }

        public static string fileUpload(String sessionKey, String folderId, String fileId, String fileName, byte[] fileBytes){
            string parameters = "?shareid=" + folderId + "&fileid=" + fileId + "&filename=" + fileName;

            //POST
            WebRequest req = WebRequest.Create(BASE + "links/create.json" + parameters);
            req.ContentType = "application/x-www-form-urlencoded";
            req.Method = "POST"; 
            req.Headers.Add("Authorization", sessionKey);

            Stream dataStream = req.GetRequestStream();
            dataStream.Write(fileBytes, 0, fileBytes.Length);
            dataStream.Close ();

            //body
            // byte [] bytes = System.Text.Encoding.ASCII.GetBytes(parameters);
            // req.ContentLength = bytes.Length;
            // System.IO.Stream os = req.GetRequestStream ();
            // os.Write (bytes, 0, bytes.Length); //Push it out there
            // os.Close ();

            WebResponse res = req.GetResponse();
            String body = new System.IO.StreamReader(res.GetResponseStream()).ReadToEnd().ToString();
            Console.WriteLine(body);

            var jss = new JavaScriptSerializer();
            var dict = jss.Deserialize<Dictionary<string,dynamic>>(body);

            return dict["RESULT"];
        }
    }
}