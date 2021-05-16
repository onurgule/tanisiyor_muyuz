<?php
include "db.php";
$p1 = $_GET["p1"];
$p2 = $_GET["p2"];
$q = $db->prepare("SELECT r.relationImagePath as path FROM Relations r WHERE r.fPID = :fpid AND r.sPID = :spid");
$q->execute(array("fpid" => $p1, "spid" => $p2));
$photos = $q->fetchAll(PDO::FETCH_ASSOC);
//print_r($photos);
//echo json_encode($l);
//yeni eklendiğinde...
//http://127.0.0.1:800/getPhoto?path=/home/YapayZeka/faces/3_329538_10150300070679522_955585786_o.jpg