<?php
require_once '../inc/db.inc.php';
?>

<?php

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $id = $_POST['id'];

    if (!empty($username) or !empty($email) or !empty($id)) {

        $stmt = $conn->prepare("DELETE FROM user WHERE username = ? or email = ? or user_id = ?");
        $stmt->bind_param("ssi", $username, $email, $id);

        $stmt->execute();
        $stmt->close();
    }
}

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
    <div class="wrapper">
        <div class="h1">
            <h1>Wettkampf erstellen</h1>
        </div>

        <div class="eventbox">
            <form action="../inc/event_signup.inc.php" method="POST" class="eventform">

                <div class="wettkampf_border">


                    <div class="starttime_text">Start:</div>
                    <p><input name="starttime" type="datetime-local" required /></p>


                    <div class="endtime_text">Ende:</div>
                    <p><input name="endtime" type="datetime-local" required /></p>


                    <?php
                    echo '<select name="club_one" id="dropDown">';
                    $query = $conn->query("SELECT name FROM club");
                    while ($row = $query->fetch_assoc()) {
                        echo "<option name='club_one' value='" . $row['name'] . "'>" . $row['name'] . "</option>";
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

                    <input type="submit" name="event_submit" value="Wettkampf erstellen">

                </div>

            </form>

            <form action="../index.php" class="event_backform">
                <input type="submit" name="submit" value="Zurück">
            </form>
        </div>

    </div>


</body>

</html>