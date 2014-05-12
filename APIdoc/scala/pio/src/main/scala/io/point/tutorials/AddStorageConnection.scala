package io.point.tutorials

import io.point.Pio
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

    val (email, password, apiKey) = ("", "", "")

    for {
      keyJson <- Pio.authenticate(email, password, apiKey)
      sessionKey = keyJson.getOrElse(throw new Exception("Session key not found"))
      storageTypesJson <- Pio.listStorageTypes(sessionKey)
      storageTypes = storageTypesJson.getOrElse(throw new Exception("Access rules not found"))
      paramsJson <- Pio.listStorageTypeParams(sessionKey, storageTypes(0).as[JsArray].value(0).as[Int])
      params = paramsJson.getOrElse(throw new Exception("Folders not found"))
    } yield {
      val paramsJs = JsObject(params.value.zip(siteArgValues).map{ pair =>
        pair._1.as[JsArray].value(4).as[String] -> JsString(pair._2)
      })
      Pio.createStorageSite(sessionKey, storageTypes(0).as[JsArray].value(0).as[Int], "New Storage Connection", siteArguments = paramsJs)
    }
  }
}
