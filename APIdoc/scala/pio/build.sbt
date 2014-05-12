name := "pio"

version := "1.0-SNAPSHOT"

scalaVersion := "2.10.0"
 
resolvers ++= Seq(
  "Typesafe Repository" at "http://repo.typesafe.com/typesafe/releases/"
)

libraryDependencies ++= Seq(
  "net.databinder.dispatch" %% "dispatch-core" % "0.11.0",
  "com.typesafe.play" %% "play-json" % "2.2.2"
)