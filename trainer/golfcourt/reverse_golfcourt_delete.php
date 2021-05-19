<?php
session_start();

include_once '../../inc/db.inc.php';
include_once '../../inc/functions.inc.php';




if (isset($_POST["court_id"])) {

    $court_id = $_POST['court_id'];

    $userId = $_SESSION['userid'];
    $club = getClub($conn, $userId);
    $club_id = $club['club_id'];

    if (!canDeleteReserve($conn, $court_id, $club_id)) {
    }


    $query = "DELETE FROM reserve WHERE court_id = ?";
    $statement = $conn->prepare($query);
    $statement->bind_param("i", $court_id);
    $statement->execute();
}
