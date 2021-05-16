<?php
include "db.php";
$q = $db->prepare("SELECT AVG(((r.height-r.disTop)/r.height + (r.width-r.disLeft)/r.width)/2) AS olasilik FROM Relations r WHERE r.fPID = :fpid AND r.sPID = :spid");
$q->execute(array("fpid" => $p1, "spid" => $p2));
$l = $q->fetch();
$olasilik = $l["olasilik"];

?>

