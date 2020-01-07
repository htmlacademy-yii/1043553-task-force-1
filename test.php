<?php
include_once "vendor/autoload.php";

$host = '127.0.0.1';
$db   = 'taskForce';
$user = 'root';
$pass = 'root';

$connection = new \mysqli($host, $user, $pass, $db);

$exporter = new \TaskForce\CsvExport\CsvExport();



$exporter->csvToSql("data/users.csv");
$exporter->csvToSql("data/tasks.csv");
$exporter->csvToSql("data/replies.csv");
$exporter->csvToSql("data/profiles.csv");
$exporter->csvToSql("data/opinions.csv");
$exporter->csvToSql("data/cities.csv");
$exporter->csvToSql("data/categories.csv");
