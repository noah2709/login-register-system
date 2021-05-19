<?php


session_start();

include_once '../../inc/db.inc.php';
include_once '../../inc/functions.inc.php';


if (isset($_POST["court_id"])) {

    $court_id = $_POST['court_id'];

    $userId = $_SESSION['userid'];
    $club = getClub($conn, $userId);
    $club_id = $club['club_id'];

    $query = $conn->query("SELECT role_id FROM user WHERE user_id = '$userId'");

    $role_id = -1;

    while ($row = $query->fetch_assoc()) {
        $role_id = $row['role_id'];
    }

    $roleName = getRoleFromId($role_id);

    if (!canDeleteReserve($conn, $court_id, $club_id) and strcasecmp($roleName, "admin") != 0) {
        http_response_code(500);
    }
}
