using System;
using System.Net;
using System.IO;
using System.Collections;
using System.Collections.Generic;
using System.Web.Script.Serialization;

namespace Pio{
    public class ListTasks{
        public static void Main(String[] args) {

            if(args.Length != 3){
                Console.WriteLine("Invalid args, should be email password apiKey");
                Environment.Exit(-1);
            }

            String sessionKey = APIFlow.authenticate(args[0], args[1], args[2]);
            ArrayList processTypes = APIFlow.listProcessTypes(sessionKey);
        }
    }
}