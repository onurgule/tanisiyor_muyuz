<?php
header('Content-Type: text/html; charset=utf-8');
try {
     $db = new PDO("mysql:host=localhost;dbname=yapayzeka", "##", "##");
	 $db->exec("SET NAMES 'utf8'; SET CHARSET 'utf8'");
} catch ( PDOException $e ){
     print $e->getMessage();
}
?>