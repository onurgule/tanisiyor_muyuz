<?php
include "db.php";
$q = $db->query("SELECT p.PID,p.Name, f.FaceImagePath FROM People p INNER JOIN Faces f ON p.PID = f.PID GROUP BY f.PID ORDER BY f.FID DESC");
$l = $q->fetchAll(PDO::FETCH_ASSOC);
//echo json_encode($l);
//yeni eklendiğinde...
//http://127.0.0.1:800/getPhoto?path=/home/YapayZeka/faces/3_329538_10150300070679522_955585786_o.jpg