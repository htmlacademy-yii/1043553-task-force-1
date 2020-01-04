<?php
include_once "vendor/autoload.php";

$host = '127.0.0.1';
$db   = 'taskForce';
$user = 'root';
$pass = 'root';

$connection = new \mysqli($host, $user, $pass, $db);

$exporter = new \TaskForce\CsvExport\CsvExport();
$a = $exporter->getData("data/categories.csv");

foreach ($a as $value) {
    var_dump($value);

}

$exporter->csvToSql("data/categories.csv");


