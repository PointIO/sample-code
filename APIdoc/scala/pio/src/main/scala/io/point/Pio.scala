package io.point

import dispatch._, Defaults._
import play.api.libs.json._
import com.ning.http.multipart.{StringPart, FilePart}

object Pio {

  lazy val BASE = "http://api.point.io/api/v2/"

  def authenticate(email: String, password: String, apiKey: String): Future[JsResult[String]] = {
    val authUrl = url(BASE + "auth.json")
      .POST
      .addParameter("email", email)
      .addParameter("password", password)
      .addParameter("apiKey", apiKey)

    Http(authUrl OK as.String).map( jsStr => (Json.parse(jsStr) \ "RESULT" \ "SESSIONKEY").validate[String])
  }

  def listAccessRules(sessionKey: String): Future[JsResult[JsArray]] = {
    val listUrl = url(BASE + "accessrules/list.json").addHeader("Authorization", sessionKey)
    Http(listUrl OK as.String).map ( jsStr => (Json.parse(jsStr) \ "RESULT" \ "DATA").validate[JsArray])
  }

  def listFolders(sessionKey: String, folderId: String): Future[JsResult[JsArray]] = {
    val listUrl = url(BASE + "folders/list.json").addHeader("Authorization", sessionKey).addQueryParameter("folderId", folderId)
    Http(listUrl OK as.String).map ( jsStr => (Json.parse(jsStr) \ "RESULT" \ "DATA").validate[JsArray])
  }

  def filePreview(sessionKey: String, folderId: String, fileId: String, fileName: String): Future[String] = {
    val previewUrl = url(BASE + "folders/files/preview.json")
                    .addHeader("Authorization", sessionKey)
                    .addQueryParameter("folderid", folderId)
                    .addQueryParameter("fileid", fileId)
                    .addQueryParameter("filename", fileName)
    Http(previewUrl OK as.String).map ( jsStr => jsStr)
  }

  def fileDownload(sessionKey: String, folderId: String, fileId: String, fileName: String): Future[String] = {
    val previewUrl = url(BASE + "folders/files/download.json")
      .addHeader("Authorization", sessionKey)
      .addQueryParameter("folderid", folderId)
      .addQueryParameter("fileid", fileId)
      .addQueryParameter("filename", fileName)
    Http(previewUrl OK as.String).map ( jsStr => jsStr)
  }

  def createLink(sessionKey: String, folderId: String, fileId: String, fileName: String, remotePath: String, containerId: String): Future[String] = {
    val authUrl = url(BASE + "auth.json").POST
                  .addHeader("Authorization", sessionKey)
                  .addParameter("shareid", folderId)
                  .addParameter("fileid", fileId)
                  .addParameter("filename", fileName)
                  .addParameter("remotepath", remotePath)
                  .addParameter("containerId", containerId)

    Http(authUrl OK as.String).map( jsStr => jsStr)
  }

  //RFC1867-encoded file upload
  def fileUpload(sessionKey: String, folderId: String, fileId: String, fileName: String, sourceFilePath: String): Future[String] = {
    val uploadUrl = url(BASE + "folders/files/upload.json").POST
                  .addHeader("Authorization", sessionKey)
                  .addBodyPart(new StringPart("folderid", folderId))
                  .addBodyPart(new StringPart("fileid", fileId))
                  .addBodyPart(new StringPart("filename", fileName))
                  .addBodyPart(new FilePart("filecontents", new java.io.File(sourceFilePath)))

    Http(uploadUrl OK as.String).map( jsStr => jsStr)
  }

  def fileCheckout(sessionKey: String, folderId: String, fileId: String, fileName: String): Future[String] = {
    val previewUrl = url(BASE + "folders/files/checkout.json")
      .addHeader("Authorization", sessionKey)
      .addQueryParameter("folderid", folderId)
      .addQueryParameter("fileid", fileId)
      .addQueryParameter("filename", fileName)
    Http(previewUrl OK as.String).map ( jsStr => jsStr)
  }

  def fileCheckin(sessionKey: String, folderId: String, fileId: String, fileName: String): Future[String] = {
    val previewUrl = url(BASE + "folders/files/checkin.json")
      .addHeader("Authorization", sessionKey)
      .addQueryParameter("folderid", folderId)
      .addQueryParameter("fileid", fileId)
      .addQueryParameter("filename", fileName)
    Http(previewUrl OK as.String).map ( jsStr => jsStr)
  }

  def listStorageTypes(sessionKey: String): Future[JsResult[JsArray]] = {
    val listUrl = url(BASE + "storagetypes/list.json").addHeader("Authorization", sessionKey)
    Http(listUrl OK as.String).map ( jsStr => (Json.parse(jsStr) \ "RESULT" \ "DATA").validate[JsArray])
  }

  def listStorageTypeParams(sessionKey: String, siteTypeId: Int): Future[JsResult[JsArray]] = {
    val listUrl = url(BASE + "storagetypes/" + siteTypeId + "/params.json").addHeader("Authorization", sessionKey)
    Http(listUrl OK as.String).map ( jsStr => (Json.parse(jsStr) \ "RESULT" \ "DATA").validate[JsArray])
  }

  def defaultFlags = Json.obj(
    "enabled" -> "1",
    "loggingEnabled" -> "0",
    "indexingEnabled" -> "0",
    "revisionControl" -> "0",
    "maxRevisions" -> "0",
    "checkinCheckout" -> "0"
  )

  def createStorageSite(sessionKey: String, siteTypeId: Int, name: String, flags: JsObject = defaultFlags, siteArguments: JsObject): Future[String] = {
    var createSiteReq = url(BASE + "auth.json").POST
      .addHeader("Authorization", sessionKey)
      .addParameter("siteTypeId", siteTypeId.toString)
      .addParameter("name", name)

    flags.fields.foreach { v =>
      createSiteReq = createSiteReq.addParameter(v._1, v._2.as[String])
    }

    siteArguments.fields.foreach { v =>
      createSiteReq = createSiteReq.addParameter(v._1, v._2.as[String])
    }

    Http(createSiteReq OK as.String).map( jsStr => jsStr)
  }

  def main(args: Array[String]) {

    val (email, password, apiKey) = ("", "", "")

    for {
      keyJson <- authenticate(email, password, apiKey)
      sessionKeyStr = keyJson.getOrElse(throw new Exception("Session key not found"))
      accessRulesJson <- listAccessRules(sessionKeyStr)
    } yield {
      val accessRules = accessRulesJson.getOrElse(throw new Exception("Access rules not found"))
      accessRules.value.foreach{ rule =>

//        for{
//          foldersJson <- listFolders(sessionKeyStr, rule(1).as[String])
//          folders = foldersJson.getOrElse(throw new Exception("Folders not found"))
//        } yield{
//          folders.value.foreach(println)
//        }
      }

      //upload file to last directory of last access rule
      for{
        foldersJson <- listFolders(sessionKeyStr, accessRules.value.last(1).as[String])
        dir = foldersJson.getOrElse(throw new Exception("Folders not found")).value.filter(_.as[JsArray].apply(2).as[String] == "DIR").last.as[JsArray]
//        uploadAsStr = DatatypeConverter.parseBase64Binary(Source.fromFile("upload.txt").getLines().mkString("\n")).mkString
        uploadResponse <- fileUpload(sessionKeyStr, dir(16).as[String], "upload2.txt", "upload2.txt", "upload.txt")
      } yield {
        println(uploadResponse)
      }
    }
  }
}
