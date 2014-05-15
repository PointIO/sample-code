package io.point.apiflow.tutorials

import io.point.apiflow.APIFlow
import dispatch._, Defaults._
import play.api.libs.json.{JsArray, JsValue}

/**
 * User: jconley
 * Date: 5/7/2014
 */
object Simple {
  def main(args: Array[String]) {
    if(args.length != 3){
      System.err.println("Invalid args, must be email password apiKey")
      System.exit(-1)
    }

    val (email, password, apiKey) = (args(0), args(1), args(2))

    for {
      sessionKeyRes <- APIFlow.authenticate(email, password, apiKey)
      sessionKey = sessionKeyRes.getOrElse(throw new Exception("Session key not found"))
      processTypesRes <- APIFlow.listProcessTypes(sessionKey)
      processTypes = processTypesRes.getOrElse(throw new Exception("Process types not found"))
      simple = processTypes.value.find(js => (js \ "name").as[String] == "simple").getOrElse(throw new Exception("Demo process type does not exist!"))
      processStartRes <- APIFlow.startProcess(sessionKey, (simple \ "name").as[String])
      processStart = processStartRes.getOrElse(throw new Exception("Process not found"))
      newProcessRes <- APIFlow.getProcess(sessionKey, (processStart \ "id").as[String].toInt)
      newProcess = newProcessRes.getOrElse(throw new Exception("New Process not found"))
    } yield {
      (newProcess \ "TASKS").as[JsArray].value.foreach { task =>
        APIFlow.completeTask(sessionKey, (task \ "ID").as[String].toInt).foreach(println)
      }

//      folders.value.foreach{ f =>
//        val folder = f.as[JsArray]
//        if(folder.value(2).as[String] == "FILE"){
//          APIFlow.filePreview(sessionKey, folder.value(16).as[String], folder.value(0).as[String], folder.value(1).as[String]).map{ res =>
//            println(res)
//          }
//        }
//      }
    }
  }
}
