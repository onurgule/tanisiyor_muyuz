<?php
$fpid = $_GET["fpid"];
$spid = $_GET["spid"];
include "db.php";
$q = $db->prepare("CALL personMerge(:fpid,:spid)");
$q->execute(array("fpid" => $fpid, "spid" => $spid));
file_get_contents("http://127.0.0.1/personMerge?fpid=".$fpid."&spid=".$spid);