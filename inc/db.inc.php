<?php

$dbconfig   = parse_ini_file(".env");

$serverName = $dbconfig["SERVERNAME"];
$dbUsername = $dbconfig["USERNAME"];
$dbPassword = $dbconfig["PASSWORD"];
$dbName     = $dbconfig["DBNAME"];

$conn = mysqli_connect($serverName, $dbUsername, $dbPassword, $dbName);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
