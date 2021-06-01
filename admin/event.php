<?php
include_once '../inc/db.inc.php';
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wettkampf erstellen</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css" integrity="sha384-vSIIfh2YWi9wW0r9iZe7RJPrKwp6bG+s9QZMoITbCckVJqGCCRhc+ccxNcdpHuYu" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200&display=swap" rel="stylesheet">
</head>

<body>
    <div class="errors">
        <?php
        if (isset($_GET['error'])) {

            if ($_GET['error'] == "emptyinput") {
                echo "<p id='warning_input'>Fülle bitte alle Felder aus!</p>";
            } else if ($_GET['error'] == "INVALIDSTART") {
                echo "<p id='error_pwd'>Bitte wähle eine Startzeit aus!</p>";
            } else if ($_GET['error'] == "SAMEID") {
                echo "<p id='error_pwd'>Bitte wähle unterschiedliche Clubs!</p>";
            } else if ($_GET['error'] == "INVALIDEND") {
                echo "<p id='error_pwd'>Bitte wähle eine Endzeit aus!</p>";
            } else if ($_GET['error'] == "SELECTFAILED") {
                echo "<p id='error_pwd'>Irgendetwas ist schiefgelauen, probiere nochmal.</p>";
                echo "<br><br>";
                echo "Error Code: 1";
            } else if ($_GET['error'] == "INPUTFAILED") {
                echo "<p id='error_pwd'>Irgendetwas ist schiefgelauen, probiere nochmal.</p>";
                echo "<br><br>";
                echo "Error Code: 2";
            } else if ($_GET['error'] == "none") {
                echo "<p id='succes'>Wettkampf erfolgreich eingetragen!</p>";
            }
        }
        ?>
    </div>

    <div class="event__box">
        <div class="event__title__container">
            <div class="event__title">
                <h1>Wettkampf erstellen</h1>
            </div>
        </div>

        <form action="../inc/event_signup.inc.php" method="POST" class="event__form">
            <p class="event__form__start">Start:<input name="starttime" type="datetime-local" required /></p>


            <p class="event__form__end">Ende:<input name="endtime" type="datetime-local" required /></p>


            <?php
            echo '<select name="club_one" id="dropDown">';
            $query = $conn->query("SELECT name FROM club");
            while ($row = $query->fetch_assoc()) {
                echo "<option name='club_one' class='club_one' value='" . $row['name'] . "'>" . $row['name'] . "</option>";
            }
            echo "</select> <br>";

            echo '<select name="club_two" id="dropDown">';
            $query = $conn->query("SELECT name FROM club");
            while ($row = $query->fetch_assoc()) {
                echo "<option name='club_two' value='" . $row['name'] . "'>" . $row['name'] . "</option>";
            }
            echo "</select> <br>";


            echo '<select name="town" id="dropDown">';
            $query = $conn->query("SELECT name FROM golfcourt");
            while ($row = $query->fetch_assoc()) {
                echo "<option name='town' value='" . $row['name'] . "'>" . $row['name'] . "</option>";
            }
            echo "</select> <br>";


            ?>
            <input type="submit" class="event__submit" name="event__submit" value="Wettkampf erstellen">

    </div>


    <div class="social_flyout">
        <ul class="some_list">
            <li><a href="../index.php"><i class="fas fa-backward"></i></a></li>
            <li><a href="https://github.com/Taikador/login-register-system"><i class="fab fa-github"></i></a></li>
            <li><a href="#"><i class="fab fa-youtube"></i></a></li>
            <li><a href="#"><i class="fab fa-twitter"></i></a></li>
        </ul>
    </div>


    <div class="datenschutz__impressum">
        <ul>
            <li>
                <a href="../impressum.php">Impressum</a>
            </li>
            <li>
                <a href="../privacy.php">Datenschutz</a>
            </li>
        </ul>
    </div>


    <footer><i class="far fa-copyright"> Copyright 2021</i></footer>


</body>

</html>