// A Hello World! program in C#. 
using System;
using System.Text;
using System.Net;
using System.IO;
using System.Collections;
using System.Collections.Generic;
using System.Web.Script.Serialization;

namespace Pio{
    public class APIFlow{
        public static String BASE = "http://pf-staging.point.io/";

        public static string authenticate(String email, String password, String apiKey){
            string parameters = "?email=" + email + "&password=" + password + "&apikey=" + apiKey;

            //POST
            WebRequest req = WebRequest.Create(BASE + "auth" + parameters);
            req.ContentType = "application/x-www-form-urlencoded";
            req.Method = "POST"; 

            WebResponse res = req.GetResponse();
            String body = new System.IO.StreamReader(res.GetResponseStream()).ReadToEnd().ToString();

            var jss = new JavaScriptSerializer();
            var dict = jss.Deserialize<Dictionary<string,dynamic>>(body);

            return dict["RESULT"]["SESSIONKEY"];
        }

        public static ArrayList listProcessTypes(String sessionKey) {
            WebRequest req = WebRequest.Create(BASE + "processtypes?Authorization=" + sessionKey);
            WebResponse res = req.GetResponse();
            String body = new System.IO.StreamReader(res.GetResponseStream()).ReadToEnd().ToString();

            var jss = new JavaScriptSerializer();
            var dict = jss.Deserialize<Dictionary<string,dynamic>>(body);
            
            return dict["REQUEST"]["PROCESSTYPES"];
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

        public static ArrayList listTasks(String sessionKey) {
            WebRequest req = WebRequest.Create(BASE + "tasks?Authorization=" + sessionKey);
            WebResponse res = req.GetResponse();
            String body = new System.IO.StreamReader(res.GetResponseStream()).ReadToEnd().ToString();

            var jss = new JavaScriptSerializer();
            var dict = jss.Deserialize<Dictionary<string,dynamic>>(body);
            
            return dict["RESPONSE"]["GROUPS"][0]["TASKS"];
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