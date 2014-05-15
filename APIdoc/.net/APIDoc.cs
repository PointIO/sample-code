// A Hello World! program in C#. 
using System;
using System.Net;
using System.IO;

namespace APIDoc
{
    public class APIDoc
    {
        public static void Main() 
        {
            Console.WriteLine("Hello World!");

            WebRequest req;
            req = WebRequest.Create("http://www.swingstats.com/golfers/data?id=1");

            WebResponse res = req.GetResponse();
            Console.WriteLine(res);
        }
    }
}