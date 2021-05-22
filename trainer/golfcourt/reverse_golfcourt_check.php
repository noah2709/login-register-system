<?php


session_start();

include_once '../../inc/db.inc.php';
include_once '../../inc/functions.inc.php';


if (isset($_POST["reserve_id"])) {

    $reserve_id = $_POST['reserve_id'];

    $userId = $_SESSION['userid'];
    $club = getClub($conn, $userId);
    $club_id = $club['club_id'];

    $query = $conn->query("SELECT role_id FROM user WHERE user_id = '$userId'");

    $roleName = getRoleName($conn, $userId);


    if (!canDeleteReserve($conn, $reserve_id, $club_id) and strcasecmp($roleName, "admin") != 0) {
        http_response_code(500);
    }
}
