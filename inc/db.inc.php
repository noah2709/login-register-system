<?php
require '.env';

$serverName = $_ENV["SERVERNAME"];
$dbUsername = $_ENV["USERNAME"];
$dbPassword = $_ENV["PASSWORD"];
$dbName     = $_ENV["DBNAME"];

$conn = mysqli_connect($serverName, $dbUsername, $dbPassword, $dbName);

echo $serverName;
echo $dbUsername;
echo $dbPassword;
echo $dbName;

// if (!$conn) {
//     die("Connection failed: " . mysqli_connect_error());
// }
