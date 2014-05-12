package io.point.tutorials

import io.point.Pio
import dispatch._, Defaults._
import play.api.libs.json.JsArray

/**
  * User: jconley
  * Date: 5/7/2014
  */
object ListFoldersDownloadFile {
   def main(args: Array[String]) {
     val (email, password, apiKey) = ("", "", "")

     for {
       keyJson <- Pio.authenticate(email, password, apiKey)
       sessionKey = keyJson.getOrElse(throw new Exception("Session key not found"))
       accessRulesJson <- Pio.listAccessRules(sessionKey)
       accessRules = accessRulesJson.getOrElse(throw new Exception("Access rules not found"))
       foldersJson <- Pio.listFolders(sessionKey, accessRules(2).as[JsArray].value(1).as[String])
       folders = foldersJson.getOrElse(throw new Exception("Folders not found"))
     } yield {
       folders.value.foreach{ f =>
         val folder = f.as[JsArray]
         if(folder.value(2).as[String] == "FILE"){
           Pio.fileDownload(sessionKey, folder.value(16).as[String], folder.value(0).as[String], folder.value(1).as[String]).map{ res =>
             println(res)
           }
         }
       }
     }
   }
 }
