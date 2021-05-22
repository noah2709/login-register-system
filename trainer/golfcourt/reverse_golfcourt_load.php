<?php


session_start();

include_once '../../inc/db.inc.php';
include_once '../../inc/functions.inc.php';

$data = array();

$query = "SELECT * FROM reserve WHERE club_id IS NOT NULL ORDER BY reserve_id";
$statement = $conn->query($query);

$result = $statement->fetch_all(MYSQLI_ASSOC);

foreach ($result as $row) {
    $data[] = array(
        'club_id'   => $row["club_id"],
        'title'   => "Reserve | " . $row["name"],
        'start'   => $row["start"],
        'end'   => $row["end"],
        'court' => getCourtFromId($conn, $row['court_id']),
        'reserve_id' => $row['reserve_id'],
    );
}
echo json_encode($data);
