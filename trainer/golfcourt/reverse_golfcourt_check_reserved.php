<?php


session_start();

include_once '../../inc/db.inc.php';
include_once '../../inc/functions.inc.php';

if (isset($_POST['club_ids'])) {

    $userid = $_SESSION['userid'];

    $club = getClub($conn, $userid);
    $club_id = $club['club_id'];

    $club_ids = $_POST['club_ids'];



    foreach ($club_ids as $id) {
        if ($club_id == $id) {
            http_response_code(500);
        }
    }
}
