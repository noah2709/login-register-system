<?php

$dbconfig   = parse_ini_file(".env");

$serverName = $dbconfig["SERVERNAME"];
$dbUsername = $dbconfig["USERNAME"];
$dbPassword = $dbconfig["PASSWORD"];
$dbName     = $dbconfig["DBNAME"];

$conn = mysqli_connect($serverName, $dbUsername, $dbPassword, $dbName);

$conn->set_charset("UTF-8");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

/* Create Tables if not exist */
/* Attention! Do not change the queries as otherwise errors may occur due to relationships.*/

$conn->query("CREATE TABLE IF NOT EXISTS town (postalcode int NOT NULL, name VARCHAR(50), PRIMARY KEY (postalcode))");

$conn->query("CREATE TABLE IF NOT EXISTS club (club_id int NOT NULL AUTO_INCREMENT, name VARCHAR(50), wins int, losses int, postalcode int, token text, PRIMARY KEY (club_id), FOREIGN KEY (postalcode) REFERENCES town(postalcode))");

$conn->query("CREATE TABLE IF NOT EXISTS role (role_id int NOT NULL, role_name VARCHAR(50), PRIMARY KEY (role_id))");

$conn->query("CREATE TABLE IF NOT EXISTS user (user_id int NOT NULL AUTO_INCREMENT, firstname VARCHAR(50), lastname VARCHAR(50), username text, password text, email text, role_id int, club_id int, PRIMARY KEY (user_id), FOREIGN KEY (role_id) REFERENCES role(role_id), FOREIGN KEY (club_id) REFERENCES club(club_id))");

$conn->query("CREATE TABLE IF NOT EXISTS golfcourt (court_id int NOT NULL AUTO_INCREMENT, name VARCHAR(50), club_id int, PRIMARY KEY (court_id))");

$conn->query("CREATE TABLE IF NOT EXISTS reserve (court_id int NOT NULL AUTO_INCREMENT, name VARCHAR(50), start date, end date, club_id int, PRIMARY KEY (court_id), FOREIGN KEY (club_id) REFERENCES club(club_id))");

$conn->query("CREATE TABLE IF NOT EXISTS event (event_id int NOT NULL AUTO_INCREMENT, starttime datetime, endtime datetime, winner int, club_id1 int, club_id2 int, court_id int, PRIMARY KEY (event_id), FOREIGN KEY (court_id) REFERENCES golfcourt(court_id))");

/* Create standard datasets if not exists */

$towns = array("19273:Bleckede", "19273:Amt Neuhaus", "21217:Seevetal", "21227:Bendestorf", "21228:Harmstorf", "21255:Otter");


$checkTownStmt = $conn->query("SELECT * FROM town");

if ($checkTownStmt->num_rows < 6) {
    $sql = "INSERT INTO town (postalcode, name) VALUES (?,?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) return;

    foreach ($towns as $town) {
        $townPlz = explode(":", $town)[0];
        $townName = explode(":", $town)[1];
        mysqli_stmt_bind_param($stmt, "is", $townPlz, $townName);
        mysqli_stmt_execute($stmt);
    }
}

$checkRoleStmt = $conn->query("SELECT * FROM role");
if ($checkRoleStmt->num_rows < 3) {
    $sql = "INSERT INTO role (role_id, role_name) VALUES (?,?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) return;

    for ($i = 1; $i < 4; $i++) {
        $name = "User";
        if ($i == 2) {
            $name = "Trainer";
        } else if ($i == 3) {
            $name = "Admin";
        }

        mysqli_stmt_bind_param($stmt, "is", $i, $name);
        mysqli_stmt_execute($stmt);
        if ($i == 3) {
            mysqli_stmt_close($stmt);
        }
    }
}
