package io.point.apiflow.tutorials

import io.point.apiflow.APIFlow
import dispatch._, Defaults._
import play.api.libs.json.{JsArray, JsValue}

/**
 * User: jconley
 * Date: 5/7/2014
 */
object SimpleMsg {
  def main(args: Array[String]) {
    if(args.length != 3){
      System.err.println("Invalid args, must be email password apiKey")
      System.exit(-1)
    }

    val (email, password, apiKey) = (args(0), args(1), args(2))

    for {
      sessionKeyRes <- APIFlow.authenticate(email, password, apiKey)
      sessionKey = sessionKeyRes.getOrElse(throw new Exception("Session key not found"))
      processStartRes <- APIFlow.startProcessWithMsg(sessionKey, "simpleMsg")
      processId = processStartRes.getOrElse(throw new Exception("Process not found"))
      newProcessRes <- APIFlow.getProcess(sessionKey, processId)
      newProcess = newProcessRes.getOrElse(throw new Exception("New Process not found"))
    } yield {
      (newProcess \ "TASKS").as[JsArray].value.foreach { task =>
        APIFlow.completeTask(sessionKey, (task \ "ID").as[String].toInt).foreach(println)
      }
    }
  }
}
