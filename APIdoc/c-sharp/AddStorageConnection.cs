using System;
using System.Net;
using System.IO;
using System.Collections;
using System.Collections.Generic;
using System.Web.Script.Serialization;

namespace Pio{
    public class AddStorageSite{
        public static void Main(String[] args) {

            if(args.Length != 4){
                Console.WriteLine("Invalid args, should be email password apiKey storageParams");
                Environment.Exit(-1);
            }

            String sessionKey = APIDoc.authenticate(args[0], args[1], args[2]);
            
            ArrayList storageTypesArray = APIDoc.listStorageTypes(sessionKey);
            int? siteTypeId = (storageTypesArray[0] as ArrayList)[1] as int?;
            ArrayList paramsArray = APIDoc.getStorageSiteParams(sessionKey, siteTypeId.Value);

            APIDoc.addStorageSite(sessionKey, siteTypeId.Value, "Joe Test", APIDoc.defaultFlags, args[3]);
        }
    }
}