<?php
include_once "vendor/autoload.php";

$host = '127.0.0.1';
$db   = 'taskForce';
$user = 'root';
$pass = 'root';

$connection = new \mysqli($host, $user, $pass, $db);

$exporter = new \TaskForce\CsvExport\CsvExport();
$exporter->csvToSql("data/replies.csv");







//$open = $open->buildRequest("categories", ["name", "image"], ["Category 1", "Image 1"]);

//var_dump($connection->query($open));
//echo $open;
