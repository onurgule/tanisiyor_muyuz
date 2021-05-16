<?php
include "db.php";
$q = $db->prepare("INSERT INTO People(Name) VALUES(:name)");
$q->execute(array("name" => $_GET["name"]));
echo $db->lastInsertId();
//yeni eklendiğinde...