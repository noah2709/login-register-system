<?php
session_start();

if (isset($_POST["submit"])) {

    require_once 'db.inc.php';

    $clubName   = mysqli_real_escape_string($conn, $_POST["name"]);
    $townName      = mysqli_real_escape_string($conn, $_POST["postalcode"]);

    require_once 'functions.inc.php';
    $postalCode = getTownIdFromName($conn, $townName);


    if (emptyClubInputSignup($clubName, $postalCode) !== false) {
        header("location: ../trainer/club_register.php?error=emptyinput");
        exit();
    }
    if (ClubNameExists($conn, $clubName) !== false) {
        header("location: ../trainer/club_register.php?error=clubexist");
        exit();
    }

    createClub($conn, $clubName, $postalCode, $_SESSION['userid']);
} else {
    header("location: ../trainer/club_register.php");
    exit();
}
