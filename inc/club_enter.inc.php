<?php
session_start();

if (isset($_POST["submit"])) {

    require_once 'db.inc.php';
    require_once 'functions.inc.php';

    $token   = mysqli_real_escape_string($conn, $_POST["token"]);
    $userid = $_SESSION['userid'];

    $clubQuery = $conn->query("SELECT club_id FROM club WHERE token = '$token'");

    $club_id = -1;

    while ($row = $clubQuery->fetch_assoc()) {
        $club_id = $row['club_id'];
    }

    if (empty($token)) {
        header("location: ../club_enter.php?error=emptyinput");
        exit();
    }
    if (!tokenExists($conn, $token)) {
        header("location: ../club_enter.php?error=invalidtoken");
        exit();
    }
    enterClub($conn, $club_id, $userid);
    header("location: ../club_enter.php?error=none");
    exit();
} else {
    header("location: ../club_enter.php");
    exit();
}
