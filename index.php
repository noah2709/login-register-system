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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>Hauptseite</title>
</head>

<body>
    <header class="index_header">
        <div class="inner-width">
            <div class="menu-icon">
                <i class="fas fa-align-right"></i>
            </div>
        </div>
    </header>
    <?php
    if (isset($_SESSION['role'])) {
        if (strcasecmp($_SESSION['role'], "admin") == 0) {
            echo "<div class='navigation-menu'>";
            echo "<nav>";
            echo "<li><a href='admin/delete.php'>Benutzer löschen</a></li>";
            echo "<li><a href='admin/update.php'>Benutzer bearbeiten</a></li>";
            echo "<li><a href='admin/search.php'>Benutzer suchen</a></li>";
            echo "<li><a href='calendar/calendar.php'>Terminkalender</a></li>";
            echo "<li><a href='trainer/golfcourt/reverse_golfcourt.php'>Golfplatz Termine</a></li>";
            echo "<li><a href='inc/logout.inc.php'>Ausloggen</a></li>";
            echo "</nav>";
            echo "</div>";
        } else if (strcasecmp($_SESSION['role'], "trainer") == 0) {
            $username = $_SESSION['username'];
            $userid = $_SESSION['userid'];

            echo "<div class='navigation-menu'>";
            echo "<nav>";

            if (hasClub($conn, $userid)) {
                $club = getClub($conn, $userid);
                $token = $club['token'];
                echo "<li><a href='#'>Ihr Token: $token</a></li>";
                echo "<li><a href='trainer/club_events.php'>Wettkämpfe</a></li>";
                echo "<li><a href='trainer/golfcourt/reverse_golfcourt.php'>Golfplatz reservieren</a></li>";
                echo "<li><a href='admin/event.php'>Wettkampf eintragen</a></li>";
            } else {
                echo "<li><a href='trainer/club_register.php'>Club registrieren</a></li>";
            }
            echo "<li><a href='inc/logout.inc.php'>Ausloggen</a></li>";
            echo "<li><a href='calendar/calendar.php'>Terminkalender</a></li>";
            echo "</nav>";
            echo "</div>";
        } else if (strcasecmp($_SESSION['role'], "user") == 0) {
            $userid = $_SESSION['userid'];

            echo "<div class='navigation-menu'>";
            echo "<nav>";
            echo "<li><a href='inc/logout.inc.php'>Ausloggen</a></li>";
            if (!hasClub($conn, $userid)) {
                echo "<li><a href='club_enter.php'>Club beitreten</a></li>";
            } else {
                echo "<li><a href='trainer/club_events.php'>Wettkämpfe</a></li>";
            }
            echo "<li><a href='calendar/calendar.php'>Terminkalender</a></li>";
            echo "</nav>";
            echo "</div>";
        }
    } else {

        echo "<div class='navigation-menu'>";
        echo "<nav>";
        echo "<li><a href='login.php'>Einloggen</a></li>";
        echo "<li><a href='signup.php'>Registrieren</a></li>";
        echo "<li><a href='calendar/calendar.php'>Terminkalender</a></li>";
        echo "</nav>";
        echo "</div>";
    }

    ?>

    <section id='home' class='home'>
        <div class='inner-width-home'>
            <div class='index_content'>
                <h1></h1>
            </div>
        </div>
    </section>


    <div class='centered_pictures'>
        <div class='slidershow middle'>
            <div class='slides'>
                <input type='radio' name='r' id='r1' checked hidden>
                <input type='radio' name='r' id='r2' hidden>
                <input type='radio' name='r' id='r3' hidden>
                <div class='slide s1'>
                    <img id='image' src='img/golf_1.jpg' alt='picture 1 not found'>
                </div>
                <div class='slide s2'>
                    <img id='image' src='img/golf_2.jpg' alt='picture 2 not found'>
                </div>
                <div class='slide s3'>
                    <img id='image' src='img/golf_3.jpg' alt='picture 3 not found'>
                </div>
            </div>
        </div>
    </div>
    <div class='navigation'>
        <label for='r1' class='bar'></label>
        <label for='r2' class='bar'></label>
        <label for='r3' class='bar'></label>
    </div>


    <div class="social_flyout">
        <ul class="some_list">
            <li><a href="https://github.com/Taikador/login-register-system"><i class="fab fa-github"></i></a></li>
            <li><a href="https://youtu.be/Mfk1QRHjVXU?t=26"><i class="fab fa-youtube"></i></a></li>
            <li><a href="#"><i class="fab fa-twitter"></i></a></li>
        </ul>
    </div>

    <div class="datenschutz__impressum">
        <ul>
            <li>
                <a href="impressum.php">Impressum</a>
            </li>
            <li>
                <a href="privacy.php">Datenschutz</a>
            </li>
        </ul>
    </div>


    <footer><i class="far fa-copyright"> Copyright 2021</i></footer>


    <script src="./javascript/app.js"></script>
</body>

</html>