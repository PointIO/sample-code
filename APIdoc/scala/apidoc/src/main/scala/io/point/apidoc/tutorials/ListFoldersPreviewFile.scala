package io.point.apidoc.tutorials

import io.point.apidoc.APIDoc
import dispatch._, Defaults._
import play.api.libs.json.JsArray

/**
 * User: jconley
 * Date: 5/7/2014
 */
object ListFoldersPreviewFile {
  def main(args: Array[String]) {
    if(args.length != 3){
      System.err.println("Invalid args, must be email password apiKey")
      System.exit(-1)
    }

    val (email, password, apiKey) = (args(0), args(1), args(2))

    for {
      keyJson <- APIDoc.authenticate(email, password, apiKey)
      sessionKey = keyJson.getOrElse(throw new Exception("Session key not found"))
      accessRulesJson <- APIDoc.listAccessRules(sessionKey)
      accessRules = accessRulesJson.getOrElse(throw new Exception("Access rules not found"))
      foldersJson <- APIDoc.listFolders(sessionKey, accessRules(2).as[JsArray].value(1).as[String])
      folders = foldersJson.getOrElse(throw new Exception("Folders not found"))
    } yield {
      folders.value.foreach{ f =>
        val folder = f.as[JsArray]
        if(folder.value(2).as[String] == "FILE"){
          APIDoc.filePreview(sessionKey, folder.value(16).as[String], folder.value(0).as[String], folder.value(1).as[String]).map{ res =>
            println(res)
          }
        }
      }
    }
  }
}
