<?php
include "db.php";
$q = $db->prepare("INSERT INTO Faces(PID,FaceImagePath,SourceImagePath) VALUES(:pid,:face,:source)");
$q->execute(array("pid" => $_GET["pid"], "face" => $_GET["face"], "source" => $_GET["source"]));