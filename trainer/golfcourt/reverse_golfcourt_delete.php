<?php
session_start();

include_once '../../inc/db.inc.php';
include_once '../../inc/functions.inc.php';

$court_id = $_POST['court_id'];



if (isset($_POST["court_id"])) {
    $query = "DELETE FROM golfcourt WHERE court_id = ?";
    $statement = $conn->prepare($query);
    $statement->bind_param("i", $court_id);
    $statement->execute();
}
