<?php
session_start();

include_once '../../inc/db.inc.php';
include_once '../../inc/functions.inc.php';



if (isset($_POST["title"])) {

    $userid = $_SESSION['userid'];
    $club = getClub($conn, $userid);

    $club_id = $club['club_id'];

    $courtName = $_POST['title'];

    $court_id = getCourtFromName($conn, $courtName);

    $title = $club['name'] . " - " . $courtName;

    $query = "INSERT INTO reserve (name, club_id, start, end, court_id) VALUES (?, ?, ?, ?, ?)";
    $statement = $conn->prepare($query);
    $statement->bind_param("sissi", $title, $club_id, $_POST['start'], $_POST['end'], $court_id);
    $statement->execute();
}
