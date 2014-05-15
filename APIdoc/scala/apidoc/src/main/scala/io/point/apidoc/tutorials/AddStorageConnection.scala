package io.point.apidoc.tutorials

import io.point.apidoc.APIDoc
import dispatch._, Defaults._
import play.api.libs.json.{JsString, JsObject, JsArray}

/**
  * User: jconley
  * Date: 5/7/2014
  */
object AddStorageConnection {

  //populate with your site argument values
  val siteArgValues: Seq[String] = Seq()

  def main(args: Array[String]) {
    if(args.length != 3){
      System.err.println("Invalid args, must be email password apiKey")
      System.exit(-1)
    }

    val (email, password, apiKey) = (args(0), args(1), args(2))

    for {
      keyJson <- APIDoc.authenticate(email, password, apiKey)
      sessionKey = keyJson.getOrElse(throw new Exception("Session key not found"))
      storageTypesJson <- APIDoc.listStorageTypes(sessionKey)
      storageTypes = storageTypesJson.getOrElse(throw new Exception("Access rules not found"))
      paramsJson <- APIDoc.listStorageTypeParams(sessionKey, storageTypes(0).as[JsArray].value(0).as[Int])
      params = paramsJson.getOrElse(throw new Exception("Folders not found"))
    } yield {
      val paramsJs = JsObject(params.value.zip(siteArgValues).map{ pair =>
        pair._1.as[JsArray].value(4).as[String] -> JsString(pair._2)
      })
      APIDoc.createStorageSite(sessionKey, storageTypes(0).as[JsArray].value(0).as[Int], "New Storage Connection", siteArguments = paramsJs)
    }
  }
}
