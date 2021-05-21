<?php
session_start();
include_once '../inc/db.inc.php';
include_once '../inc/functions.inc.php';
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <script src="https://kit.fontawesome.com/2deba413ff.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?famsily=Montserrat:wght@200&display=swap" rel="stylesheet">
    <title>Ihre nächsten Spiele</title>
</head>

<body>
    <?php
    $userid = $_SESSION['userid'];
    $club = getClub($conn, $userid);
    $clubName = $club['name'];
    echo "<div class='club_events_h1'>";
    echo "<h1>Ihre nächsten Spiele im Club: $clubName</h1>";
    echo "</div>";
    ?>

    <div class="social_flyout">
        <ul class="some_list">
            <li><a href="../index.php"><i class="fas fa-backward"></i></a></li>
            <li><a href="https://github.com/Taikador/login-register-system"><i class="fab fa-github"></i></a></li>
            <li><a href="#"><i class="fab fa-youtube"></i></a></li>
            <li><a href="#"><i class="fab fa-twitter"></i></a></li>
        </ul>
    </div>
    <div class="wrapper">
        <table class="club_events_content">
            <thead>
                <tr>
                    <th>Start</th>
                    <th>Ende</th>
                    <th>Winner</th>
                    <th>Club 1</th>
                    <th>Club 2</th>
                    <th>Golfplatz</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $userid = $_SESSION['userid'];
                $club = getClub($conn, $userid);
                $clubId = $club['club_id'];

                $query = $conn->query("SELECT * FROM event WHERE club_id1 = $clubId OR club_id2 = $clubId");
                if ($query->num_rows <= 0) return;



                while ($row = $query->fetch_assoc()) {
                    $currentFullDate = date("Y-m-d H:i:s");
                    $dataBaseFullDate = $row['starttime'];

                    $dataBaseDate = explode(" ", $dataBaseFullDate)[0];
                    $currentDate = date("Y-m-d");

                    if ($dataBaseFullDate < $currentFullDate) {
                        continue;
                    }
                    if ($dataBaseDate == $currentDate) {
                ?>

                        <tr>
                            <td style="background: lime;"><?php echo $row['starttime'] ?>--</td>
                            <td style="background: lime;"><?php echo $row['endtime'] ?></td>
                            <td style="background: lime;"><?php echo ($row['winner'] == -1) ? "Unbekannt" : $row['winner']; ?></td>
                            <td style="background: lime;"><?php echo getClubFromClubId($conn, $row['club_id1'])['name'] ?></td>
                            <td style="background: lime;"><?php echo getClubFromClubId($conn, $row['club_id2'])['name'] ?></td>
                            <td style="background: lime;"><?php echo getCourtFromId($conn, $row['court_id']) ?></td>
                        </tr>
                    <?php
                        continue;
                    }
                    ?>

                    <tr>
                        <td><?php echo $row['starttime'] ?>--</td>
                        <td><?php echo $row['endtime'] ?></td>
                        <td><?php echo ($row['winner'] == -1) ? "Unbekannt" : $row['winner']; ?></td>
                        <td><?php echo getClubFromClubId($conn, $row['club_id1'])['name'] ?></td>
                        <td><?php echo getClubFromClubId($conn, $row['club_id2'])['name'] ?></td>
                        <td><?php echo getCourtFromId($conn, $row['court_id']) ?></td>

                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</body>