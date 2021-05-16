<?php
$fpid = $_GET["fpid"];
include "db.php";
$q = $db->prepare("CALL personDelete(:fpid)");
$q->execute(array("fpid" => $fpid));
file_get_contents("http://127.0.0.1/personDelete?fpid=".$fpid);