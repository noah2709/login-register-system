<?php

if (isset($_POST["event_submit"])) {

    require_once 'db.inc.php';
    require_once 'functions.inc.php';

    $start   = mysqli_real_escape_string($conn, $_POST["starttime"]);
    $end      = mysqli_real_escape_string($conn, $_POST["endtime"]);
    $club_one      = mysqli_real_escape_string($conn, $_POST["club_one"]);
    $club_two      = mysqli_real_escape_string($conn, $_POST["club_two"]);
    $golfcourt      = mysqli_real_escape_string($conn, $_POST["town"]);
    $winner = -1;


    $clubId_one = getClubIdFromName($conn, $club_one);
    $clubId_two = getClubIdFromName($conn, $club_two);
    $golfCourtId = getCourtFromName($conn, $golfcourt);


    createEvent($conn, $start, $end, $winner, $clubId_one, $clubId_two,  $golfCourtId);
} else {
    header("location: ../admin/event.php");
    exit();
}
