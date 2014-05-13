package io.point.apiflow

import dispatch._, Defaults._
import play.api.libs.json._
import com.ning.http.multipart.{StringPart, FilePart}

object APIFlow {

  lazy val BASE = "http://pointflow.point.io/"

  def authenticate(email: String, password: String, apiKey: String): Future[JsResult[String]] = {
    val authUrl = url(BASE + "auth").POST
      .addQueryParameter("email", email)
      .addQueryParameter("password", password)
      .addQueryParameter("apikey", apiKey)

    Http(authUrl OK as.String).map( jsStr => (Json.parse(jsStr) \ "RESULT" \ "SESSIONKEY").validate[String])
  }

  def listProcessTypes(sessionKey: String): Future[JsResult[JsArray]] = {
    val listUrl = url(BASE + "processtypes").addQueryParameter("Authorization", sessionKey)
    Http(listUrl OK as.String).map ( jsStr => (Json.parse(jsStr) \ "REQUEST" \ "PROCESSTYPES").validate[JsArray])
  }

  def startProcess(sessionKey: String, processName: String): Future[JsResult[JsObject]] = {
    val startUrl = url(BASE + "processes/" + processName).POST
                   .addQueryParameter("Authorization", sessionKey)
                   .setBody("{}")
                   .setHeader("Content-Type", "application/json")

    Http(startUrl OK as.String).map { jsStr =>
//      println(jsStr)
      (Json.parse(jsStr) \ "REQUEST" \ "PROCESS").validate[JsObject]
    }
  }

  def getProcess(sessionKey: String, processId: Int): Future[JsResult[JsObject]] = {
    val procUrl = url(BASE + "processes/" + processId).addQueryParameter("Authorization", sessionKey)

    Http(procUrl OK as.String).map { jsStr =>
//      println(jsStr)
      (Json.parse(jsStr) \ "RESPONSE" \ "PROCESS").validate[JsObject]
    }
  }

  def completeTask(sessionKey: String, taskId: Int, bodyJson: JsObject = Json.obj()) = {
    val taskUrl = url(BASE + "tasks/" + taskId).PUT
      .addQueryParameter("Authorization", sessionKey)
      .setBody(bodyJson.toString())
      .setHeader("Content-Type", "application/json")

    Http(taskUrl OK as.String).map { jsStr =>
//      println(jsStr)
      Json.parse(jsStr)
    }
  }

//  //RFC1867-encoded file upload
//  def fileUpload(sessionKey: String, folderId: String, fileId: String, fileName: String, sourceFilePath: String): Future[String] = {
//    val uploadUrl = url(BASE + "folders/files/upload.json").POST
//                  .addHeader("Authorization", sessionKey)
//                  .addBodyPart(new StringPart("folderid", folderId))
//                  .addBodyPart(new StringPart("fileid", fileId))
//                  .addBodyPart(new StringPart("filename", fileName))
//                  .addBodyPart(new FilePart("filecontents", new java.io.File(sourceFilePath)))
//
//    Http(uploadUrl OK as.String).map( jsStr => jsStr)
//  }
//
//  def fileCheckout(sessionKey: String, folderId: String, fileId: String, fileName: String): Future[String] = {
//    val previewUrl = url(BASE + "folders/files/checkout.json")
//      .addHeader("Authorization", sessionKey)
//      .addQueryParameter("folderid", folderId)
//      .addQueryParameter("fileid", fileId)
//      .addQueryParameter("filename", fileName)
//    Http(previewUrl OK as.String).map ( jsStr => jsStr)
//  }
//
//  def fileCheckin(sessionKey: String, folderId: String, fileId: String, fileName: String): Future[String] = {
//    val previewUrl = url(BASE + "folders/files/checkin.json")
//      .addHeader("Authorization", sessionKey)
//      .addQueryParameter("folderid", folderId)
//      .addQueryParameter("fileid", fileId)
//      .addQueryParameter("filename", fileName)
//    Http(previewUrl OK as.String).map ( jsStr => jsStr)
//  }
//
//  def listStorageTypes(sessionKey: String): Future[JsResult[JsArray]] = {
//    val listUrl = url(BASE + "storagetypes/list.json").addHeader("Authorization", sessionKey)
//    Http(listUrl OK as.String).map ( jsStr => (Json.parse(jsStr) \ "RESULT" \ "DATA").validate[JsArray])
//  }
//
//  def listStorageTypeParams(sessionKey: String, siteTypeId: Int): Future[JsResult[JsArray]] = {
//    val listUrl = url(BASE + "storagetypes/" + siteTypeId + "/params.json").addHeader("Authorization", sessionKey)
//    Http(listUrl OK as.String).map ( jsStr => (Json.parse(jsStr) \ "RESULT" \ "DATA").validate[JsArray])
//  }
//
//  def defaultFlags = Json.obj(
//    "enabled" -> "1",
//    "loggingEnabled" -> "0",
//    "indexingEnabled" -> "0",
//    "revisionControl" -> "0",
//    "maxRevisions" -> "0",
//    "checkinCheckout" -> "0"
//  )
//
//  def createStorageSite(sessionKey: String, siteTypeId: Int, name: String, flags: JsObject = defaultFlags, siteArguments: JsObject): Future[String] = {
//    var createSiteReq = url(BASE + "auth.json").POST
//      .addHeader("Authorization", sessionKey)
//      .addParameter("siteTypeId", siteTypeId.toString)
//      .addParameter("name", name)
//
//    flags.fields.foreach { v =>
//      createSiteReq = createSiteReq.addParameter(v._1, v._2.as[String])
//    }
//
//    siteArguments.fields.foreach { v =>
//      createSiteReq = createSiteReq.addParameter(v._1, v._2.as[String])
//    }
//
//    Http(createSiteReq OK as.String).map( jsStr => jsStr)
//  }
}
