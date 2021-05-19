<?php


session_start();

include_once '../inc/db.inc.php';

include_once '../inc/functions.inc.php';

$data = array();

$query = "SELECT * FROM golfcourt WHERE club_id IS NOT NULL ORDER BY court_id";
$statement = $conn->query($query);
$result = $statement->fetch_all(MYSQLI_ASSOC);

$eventQuery = "SELECT * FROM event ORDER BY event_id";
$eventStatement = $conn->query($eventQuery);

$eventResult = $eventStatement->fetch_all(MYSQLI_ASSOC);

foreach ($eventResult as $row) {
    $clubOne = getClubFromClubId($conn, $row['club_id1'])['name'];
    $clubTwo = getClubFromClubId($conn, $row['club_id2'])['name'];
    $data[] = array(
        'title'   => "Wettkampf | $clubOne vs $clubTwo",
        'start'   => $row["starttime"],
        'end'   => $row["endtime"],
    );
}
foreach ($result as $row) {
    $data[] = array(
        'title'   => $row["name"],
        'start'   => $row["start"],
        'end'   => $row["end"],
    );
}

echo json_encode($data);
