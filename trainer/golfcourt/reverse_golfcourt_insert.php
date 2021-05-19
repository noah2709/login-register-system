<?php
session_start();

include_once '../../inc/db.inc.php';
include_once '../../inc/functions.inc.php';



if (isset($_POST["title"])) {

    $userid = $_SESSION['userid'];
    $club = getClub($conn, $userid);

    $club_id = $club['club_id'];

    $query = "INSERT INTO reserve (name, club_id, start, end) VALUES (?, ?, ? ,?)";
    $statement = $conn->prepare($query);
    $statement->bind_param("siss", $_POST['title'], $club_id, $_POST['start'], $_POST['end']);
    $statement->execute();
}
