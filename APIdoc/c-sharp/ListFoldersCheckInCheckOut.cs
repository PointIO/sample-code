using System;
using System.Net;
using System.IO;
using System.Collections;
using System.Collections.Generic;
using System.Web.Script.Serialization;

namespace Pio{
    public class ListFoldersCheckInCheckOut{
        public static void Main(String[] args) {
            if(args.Length != 3){
                Console.WriteLine("Invalid args, should be email password apiKey");
                Environment.Exit(-1);
            }

            String sessionKey = APIDoc.authenticate(args[0], args[1], args[2]);
            
            ArrayList rules = APIDoc.listAccessRules(sessionKey);
            ArrayList rule = rules[2] as ArrayList;
            String folderId = rule[1] as String;

            ArrayList folders = APIDoc.listFolders(sessionKey, folderId);
            ArrayList file = folders[5] as ArrayList;

            //checkout
            APIDoc.checkout(sessionKey, file[16] as string, file[0] as string, file[1] as string);

            //download
            String downloadUrl = APIDoc.fileDownload(sessionKey, file[16] as string, file[0] as string, file[1] as string);

            //upload
            byte[] fileBytes = System.IO.File.ReadAllBytes("test.pdf");
            APIDoc.fileUpload(sessionKey, file[16] as string, file[0] as string, file[1] as string, fileBytes);

            //checkin
            APIDoc.checkin(sessionKey, file[16] as string, file[0] as string, file[1] as string);
        }
    }
}