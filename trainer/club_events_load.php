<?php

session_start();

include_once '../inc/db.inc.php';
include_once '../inc/functions.inc.php';

$data = array();

$query = "SELECT * FROM event ORDER BY event_id";
$statement = $conn->query($query);

$userid = $_SESSION['userid'];
$club = getClub($conn, $userid);

$club_id_user = $club['club_id'];

$result = $statement->fetch_all(MYSQLI_ASSOC);

foreach ($result as $row) {
    $club_one = getClubFromClubId($conn, $row['club_id1']);
    $club_two = getClubFromClubId($conn, $row['club_id2']);
    if ($club_one['club_id'] != $club_id_user and $club_two['club_id'] != $club_id_user) continue;
    $court = getCourtFromId($conn, $row['court_id']);
    $data[] = array(
        'event_id'   => $row["event_id"],
        'title'   => $club_one['name'] . " vs " . $club_two['name'] . " | " . $court,
        'start'   => $row["starttime"],
        'end'   => $row["endtime"],
        'court' => $court,
        'club_id1' => $row['club_id1'],
        'club_id2' => $row['club_id2'],
    );
}
echo json_encode($data);
