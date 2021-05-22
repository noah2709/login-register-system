<?php


session_start();

include_once '../../inc/db.inc.php';
include_once '../../inc/functions.inc.php';

$data = array();

$statement = $conn->query("SELECT name FROM golfcourt");

$result = $statement->fetch_all(MYSQLI_ASSOC);

foreach ($result as $row) {
    $data[] = array(
        'name'   => $row["name"]
    );
}
echo json_encode($data);
