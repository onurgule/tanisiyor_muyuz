<?php
include "db.php";
$q = $db->prepare("INSERT INTO Relations(fPID,sPID,relationImagePath,disTop,disLeft,height,width) VALUES(:pid,:pid2,:source,:top,:left,:height,:width)");
$q->execute(array("pid" => $_GET["fpid"], "pid2" => $_GET["spid"], "source" => $_GET["source"], "top" => $_GET["top"], "left" => $_GET["left"], "height" => $_GET["height"], "width" => $_GET["width"]));