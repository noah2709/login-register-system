<?php
session_start();

include_once '../../inc/db.inc.php';
include_once '../../inc/functions.inc.php';




if (isset($_POST["reserve_id"])) {

    $reserve_id = $_POST['reserve_id'];

    $userId = $_SESSION['userid'];
    $club = getClub($conn, $userId);
    $club_id = $club['club_id'];


    $query = "DELETE FROM reserve WHERE reserve_id = ?";
    $statement = $conn->prepare($query);
    $statement->bind_param("i", $reserve_id);
    $statement->execute();
}
