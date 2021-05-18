<?php

if (isset($_POST["event_submit"])) {

    require_once 'db.inc.php';
    require_once 'functions.inc.php';

    $start = date("Y-m-d H:i:s", strtotime(mysqli_real_escape_string($conn, $_POST["starttime"])));
    $end = date("Y-m-d H:i:s", strtotime(mysqli_real_escape_string($conn, $_POST["endtime"])));
    $club_one      = mysqli_real_escape_string($conn, $_POST["club_one"]);
    $club_two      = mysqli_real_escape_string($conn, $_POST["club_two"]);
    $golfcourt      = mysqli_real_escape_string($conn, $_POST["town"]);
    $winner = -1;


    $clubId_one = getClubIdFromName($conn, $club_one);
    $clubId_two = getClubIdFromName($conn, $club_two);
    $golfCourtId = getCourtFromName($conn, $golfcourt);

    if (sameClubId($clubId_one, $clubId_two)) {
        header("location: ../admin/event.php?error=SAMEID");
        exit();
    }

    createEvent($conn, $start, $end, $winner, $clubId_one, $clubId_two,  $golfCourtId);
} else {
    header("location: ../admin/event.php");
    exit();
}
