<?php
session_start();
include_once 'inc/db.inc.php';
include_once 'inc/functions.inc.php';
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/2deba413ff.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200&display=swap" rel="stylesheet">
    <title>Hauptseite</title>
</head>

<body>
    <div class="header">
        <?php

        if (isset($_SESSION['role'])) {
            echo "<div class='logout'><button class='logout__btn'><a href='inc/logout.inc.php'>Logout</a></button></div>";
            if (strcasecmp($_SESSION['role'], "admin") == 0) {

                /* Title */
                echo "<div class='h1'>";
                echo "<h1>Admin Panel</h1>";
                echo "</div>";

                echo "<div class='allboxes'>";

                /* Left box in admin panel */
                echo "<div class='boxleft'>";
                echo "<div class='boxtitle'>";
                echo "<p>Benutzer löschen</p><i class='fas fa-user-slash'></i>";
                echo "</div>";

                /* Left box content in admin panel */
                echo "<div class='boxleft_content'>";
                echo "<p>Klicke unten, um zu dem Formular zu gelangen, wo du Benutzer löschen kannst.</p>";
                echo "</div>";

                /* Little box inside left box */
                echo "<div class='littlebox'>";
                echo "<a href='./admin/delete.php'>";
                echo "<div class='littlebox_text'>";
                echo "<p>Zum Formular ≫</p>";
                echo "</div>";
                echo "</a>";
                echo "</div>";
                echo "</div>";

                /* Middle box - User edit symbol */
                echo "<div class='boxmiddle'>";
                echo "<div class='boxtitle'>";
                echo "<p>Benutzer bearbeiten</p><i class='fas fa-user-edit'></i>";
                echo "</div>";

                /* Middle box content in admin panel */
                echo "<div class='boxleft_content'>";
                echo "<p>Klicke unten, um zu dem Formular zu gelangen, wo du Benutzer bearbeiten kannst.</p>";
                echo "</div>";


                /* Little box content in admin panel */
                echo "<div class='littlebox'>";
                echo "<a href='./admin/update.php'>";
                echo "<div class='littlebox_text'>";
                echo "<p>Zum Formular ≫</p>";
                echo "</div>";
                echo "</a>";
                echo "</div>";
                echo "</div>";


                /* Right box in admin panel */
                echo "<div class='boxright'>";
                echo "<div class='boxtitle'>";
                echo "<p>Benutzer suchen</p><i class='fas fa-search'></i>";
                echo "</div>";

                /* Right box content in admin panel */
                echo "<div class='boxleft_content'>";
                echo "<p>Klicke unten, um zu dem Formular zu gelangen, wo du Benutzer suchen kannst.</p>";
                echo "</div>";

                /* Little box inside right box */
                echo "<div class='littlebox'>";
                echo "<a href='./admin/search.php'>";
                echo "<div class='littlebox_text'>";
                echo "<p>Zum Formular ≫</p>";
                echo "</div>";
                echo "</a>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
            } else if (strcasecmp($_SESSION['role'], "trainer") == 0) {
                $username = $_SESSION['username'];
                $userid = $_SESSION['userid'];
                echo "<h1>Trainer Panel<h1>";
                echo "<br>";
                echo "<h3>Willkommen Trainer $username !<h3>";

                if (hasClub($conn, $userid)) {
                    $club = getClub($conn, $userid);
                    $clubName = $club['name'];
                    $wins = $club['wins'];
                    $losses = $club['losses'];
                    $postalcode = $club['postalcode'];
                    $token = $club['token'];
                    echo "Dein Club: $clubName <br>";
                    echo "Spiele gewonnen: $wins <br>";
                    echo "Spiele verloren: $losses <br>";
                    echo "Postalcode: $postalcode <br>";
                    echo "Ihr Token: $token <br>";

                    echo "<div class='next_game_btn'>
                    <button class='next_game__btn'><a href='./trainer/club_events.php'>Ihre nächsten Wettkämpfe</a></button>
                    </div>";
                    echo "<div class='reserve_golfcourt_btn'>
                    <button class='reserve_golfcourt__btn'><a href='./trainer/golfcourt/reverse_golfcourt.php'>Golfplatz reservieren</a></button>
                    </div>";
                    echo "<br>";
                    /* Bottom left in trainer panel */
                    echo "<div class='boxbottomleft'>";
                    echo "<div class='boxbottomleft_boxtitle'>";
                    echo "<p>Wettkampf eintragen</p>";
                    echo "</div>";

                    /* Bottom left box content in trainer panel */
                    echo "<div class='boxbottomleft_content'>";
                    echo "<p>Klicke unten, um zu dem Formular zu gelangen, wo du Wettkämpfe eintragen kannst.</p>";
                    echo "</div>";

                    /* Bottom left box inside bottom left box */
                    echo "<div class='boxbottomleft_littlebox'>";
                    echo "<a href='./admin/event.php'>";
                    echo "<div class='boxbottomleft_littlebox_text'>";
                    echo "<p>Zum Formular ≫</p>";
                    echo "</div>";
                    echo "</a>";
                    echo "</div>";
                    echo "</div>";
                } else {
                    echo "<div class='club_btn'>
                    <button class='club__btn'><a href='./trainer/club_register.php'>Register club</a></button>
                    </div>";
                }


                echo "<div class='calender_btn'>
                    <button class='calender__btn'><a href='./calendar/calendar.php'>Alle Termine</a></button>
                    </div>";
            } else if (strcasecmp($_SESSION['role'], "user") == 0) {


                $userid = $_SESSION['userid'];
                $username = $_SESSION['username'];

                $sql        = "SELECT * FROM user WHERE user_id = '$userid'";
                $query = $conn->query($sql);

                echo "<h1>User Panel<h1>";
                echo "<br>";
                echo "<h3>Welcome $username !<h3>";
                echo "<br><br>";

                echo "<table class= 'query_table' method='POST' id='query_table'>";
                echo "<thead><tr>";
                echo "<td>Username</td><td>Email</td>";
                echo "</tr></thead>";

                if (hasClub($conn, $userid)) {
                    echo "<div class='next_game_btn'>
                    <button class='next_game__btn'><a href='./trainer/club_events.php'>Ihre nächsten Wettkämpfe</a></button>
                    </div>";
                } else {

                    echo "<div class='invite_btn'>
                    <button class='calender__btn'><a href='./trainer/club_enter.php'>Club beitreten</a></button>
                    </div>";
                }


                while ($row = $query->fetch_assoc()) {
                    echo "<td>" . $row['username'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "</tr>";
                }
                echo "<br><br>";
                echo "<div class='calender_btn'>
                    <button class='calender__btn'><a href='./calendar/calendar.php'>Alle Termine</a></button>
                    </div>";
            }
        } else {

            echo "<h1>Login/Register - System<h1>";
            echo "<br><br>";
            echo "<div class='signup'>
                    <button class='signup__btn'><a href='signup.php'>Sign Up</a></button>
                    </div>";
            echo "<div class='login'>
                    <button class='login__btn'><a href='login.php'>Log In</a></button>
                    </div>";
        }


        ?>


</body>

</html>