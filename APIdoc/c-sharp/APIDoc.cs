// A Hello World! program in C#. 
using System;
using System.Text;
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

            WebResponse res = req.GetResponse();
            String body = new System.IO.StreamReader(res.GetResponseStream()).ReadToEnd().ToString();
            Console.WriteLine(body);

            var jss = new JavaScriptSerializer();
            var dict = jss.Deserialize<Dictionary<string,dynamic>>(body);

            return dict["LINKURL"];
        }

        public static Dictionary<string,dynamic> fileUpload(String sessionKey, String folderId, String fileId, String fileName, byte[] fileBytes){
            // string parameters = "?shareid=" + folderId + "&fileid=" + fileId + "&filename=" + fileName;
            
            string fileStr = System.Convert.ToBase64String(fileBytes);
            Dictionary<string, object> multipartForm = new Dictionary<string, object>(){
                {"folderid", folderId},
                {"fileid", fileId},
                {"filename", fileName},
                {"filecontents", new FileParameter(fileBytes)}
            };

            string formDataBoundary = String.Format("----------{0:N}", Guid.NewGuid());
            byte[] formData = GetMultipartFormData(multipartForm, formDataBoundary);

            //POST
            WebRequest req = WebRequest.Create(BASE + "folders/files/upload.json");
            req.ContentType = "multipart/form-data; boundary=" + formDataBoundary;
            req.ContentLength = formData.Length;
            req.Method = "POST"; 
            req.Headers.Add("Authorization", sessionKey);

            // Send the form data to the request.
            using (Stream requestStream = req.GetRequestStream()){
                requestStream.Write(formData, 0, formData.Length);
                requestStream.Close();
            }

            WebResponse res = req.GetResponse();
            String body = new System.IO.StreamReader(res.GetResponseStream()).ReadToEnd().ToString();

            var jss = new JavaScriptSerializer();
            var dict = jss.Deserialize<Dictionary<string,dynamic>>(body);

            return dict;
        }

        public static Dictionary<string,dynamic> checkout(String sessionKey, String folderId, String fileName, String fileId){
            string parameters = "folderid=" + folderId + "&fileid=" + fileId + "&filename=" + fileName;
            WebRequest req = WebRequest.Create(BASE + "folders/files/checkout.json?" + parameters);
            req.Headers.Add("Authorization", sessionKey);

            WebResponse res = req.GetResponse();
            String body = new System.IO.StreamReader(res.GetResponseStream()).ReadToEnd().ToString();

            var jss = new JavaScriptSerializer();
            var dict = jss.Deserialize<Dictionary<string,dynamic>>(body);
            
            return dict;
        }

        public static Dictionary<string,dynamic> checkin(String sessionKey, String folderId, String fileName, String fileId){
            string parameters = "folderid=" + folderId + "&fileid=" + fileId + "&filename=" + fileName;
            WebRequest req = WebRequest.Create(BASE + "folders/files/checkin.json?" + parameters);
            req.Headers.Add("Authorization", sessionKey);

            WebResponse res = req.GetResponse();
            String body = new System.IO.StreamReader(res.GetResponseStream()).ReadToEnd().ToString();

            var jss = new JavaScriptSerializer();
            var dict = jss.Deserialize<Dictionary<string,dynamic>>(body);
            
            return dict;
        }

        public static ArrayList listStorageTypes(String sessionKey) {
            WebRequest req = WebRequest.Create(BASE + "storagetypes/list.json");
            req.Headers.Add("Authorization", sessionKey);

            WebResponse res = req.GetResponse();
            String body = new System.IO.StreamReader(res.GetResponseStream()).ReadToEnd().ToString();

            var jss = new JavaScriptSerializer();
            var dict = jss.Deserialize<Dictionary<string,dynamic>>(body);
            
            return dict["RESULT"]["DATA"];
        }

        public static ArrayList getStorageSiteParams(String sessionKey, int siteTypeId) {
            WebRequest req = WebRequest.Create(BASE + "storagetypes/" + siteTypeId + "/params.json");
            req.Headers.Add("Authorization", sessionKey);

            WebResponse res = req.GetResponse();
            String body = new System.IO.StreamReader(res.GetResponseStream()).ReadToEnd().ToString();

            var jss = new JavaScriptSerializer();
            var dict = jss.Deserialize<Dictionary<string,dynamic>>(body);
            
            return dict["RESULT"]["DATA"];
        }

        public static Dictionary<string, bool> defaultFlags = new Dictionary<string, bool>(){
            {"enabled", true},
            {"loggingEnabled", false},
            {"indexingEnabled", false},
            {"revisionControl", false},
            {"maxRevisions", false},
            {"checkinCheckout", false}
        };

        public static Dictionary<string,dynamic> addStorageSite(String sessionKey, int siteTypeId, String name, Dictionary<string, bool> flags, String paramsJson){
            Dictionary<string, object> multipartForm = new Dictionary<string, object>(){
                {"siteTypeId", siteTypeId},
                {"name", name},
                {"siteArguments", paramsJson.ToString()}
            };

            foreach(KeyValuePair<string, bool> entry in flags){
                multipartForm.Add(entry.Key, entry.Value ? "1" : "0");                
            }

            string formDataBoundary = String.Format("----------{0:N}", Guid.NewGuid());
            byte[] formData = GetMultipartFormData(multipartForm, formDataBoundary);

            //POST
            WebRequest req = WebRequest.Create(BASE + "storagesites/create.json");
            req.ContentType = "multipart/form-data; boundary=" + formDataBoundary;
            req.ContentLength = formData.Length;
            req.Method = "POST"; 
            req.Headers.Add("Authorization", sessionKey);

            // Send the form data to the request.
            using (Stream requestStream = req.GetRequestStream()){
                requestStream.Write(formData, 0, formData.Length);
                requestStream.Close();
            }

            WebResponse res = req.GetResponse();
            String body = new System.IO.StreamReader(res.GetResponseStream()).ReadToEnd().ToString();

            var jss = new JavaScriptSerializer();
            var dict = jss.Deserialize<Dictionary<string,dynamic>>(body);

            return dict;
        }        

        private static readonly Encoding encoding = Encoding.UTF8;

         public class FileParameter{
            public byte[] File { get; set; }
            public string FileName { get; set; }
            public string ContentType { get; set; }
            public FileParameter(byte[] file) : this(file, null) { }
            public FileParameter(byte[] file, string filename) : this(file, filename, null) { }
            public FileParameter(byte[] file, string filename, string contenttype)
            {
                File = file;
                FileName = filename;
                ContentType = contenttype;
            }
        }

        private static byte[] GetMultipartFormData(Dictionary<string, object> postParameters, string boundary){
            Stream formDataStream = new System.IO.MemoryStream();
            bool needsCLRF = false;
     
            foreach (var param in postParameters)
            {
                // Thanks to feedback from commenters, add a CRLF to allow multiple parameters to be added.
                // Skip it on the first parameter, add it to subsequent parameters.
                if (needsCLRF)
                    formDataStream.Write(encoding.GetBytes("\r\n"), 0, encoding.GetByteCount("\r\n"));
     
                needsCLRF = true;
     
                if (param.Value is FileParameter)
                {
                    FileParameter fileToUpload = (FileParameter)param.Value;
     
                    // Add just the first part of this param, since we will write the file data directly to the Stream
                    string header = string.Format("--{0}\r\nContent-Disposition: form-data; name=\"{1}\"; filename=\"{2}\"\r\nContent-Type: {3}\r\n\r\n",
                        boundary,
                        param.Key,
                        fileToUpload.FileName ?? param.Key,
                        fileToUpload.ContentType ?? "application/octet-stream");
     
                    formDataStream.Write(encoding.GetBytes(header), 0, encoding.GetByteCount(header));
     
                    // Write the file data directly to the Stream, rather than serializing it to a string.
                    formDataStream.Write(fileToUpload.File, 0, fileToUpload.File.Length);
                }
                else
                {
                    string postData = string.Format("--{0}\r\nContent-Disposition: form-data; name=\"{1}\"\r\n\r\n{2}",
                        boundary,
                        param.Key,
                        param.Value);
                    formDataStream.Write(encoding.GetBytes(postData), 0, encoding.GetByteCount(postData));
                }
            }
     
            // Add the end of the request.  Start with a newline
            string footer = "\r\n--" + boundary + "--\r\n";
            formDataStream.Write(encoding.GetBytes(footer), 0, encoding.GetByteCount(footer));
     
            // Dump the Stream into a byte[]
            formDataStream.Position = 0;
            byte[] formData = new byte[formDataStream.Length];
            formDataStream.Read(formData, 0, formData.Length);
            formDataStream.Close();
     
            return formData;
        }
    }
}