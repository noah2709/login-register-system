<?php

require_once '../inc/db.inc.php';

?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>Club Registrieren</title>
</head>

<body>
    <div class="errors">
        <?php
        if (isset($_GET['error'])) {
            if ($_GET['error'] == "emptyinput") {
                echo "<p id='warning_input'>Fülle bitte alle Felder aus!</p>";
            } else if ($_GET['error'] == "clubexist") {
                echo "<p id='error_pwd'>Dieser Clubname ist bereits vergeben!</p>";
            } else if ($_GET['error'] == "SELECTFAILED") {
                echo "<p id='error_pwd'>Irgendetwas ist schiefgelauen, probiere nochmal.</p>";
                echo "<br><br>";
                echo "Error Code: 1";
            } else if ($_GET['error'] == "INPUTFAILED") {
                echo "<p id='error_pwd'>Irgendetwas ist schiefgelauen, probiere nochmal.</p>";
                echo "<br><br>";
                echo "Error Code: 2";
            } else if ($_GET['error'] == "none") {
                echo "<p id='succes'>Club erfolgreich registriert!</p>";
            }
        }
        ?>
    </div>
    <div class="center">
        <section class="input__form">
            <h1>Club Sign Up</h1>
            <form action="../inc/club_signup.inc.php" method="POST">
                <div class="text__field">
                    <input type="text" name="name" required>
                    <span></span>
                    <label>Clubname</label>
                </div>
                <div class="text__field">
                    <?php
                    echo '<select name="postalcode" id="dropDown">';
                    $query = $conn->query("SELECT name FROM town");
                    while ($row = $query->fetch_assoc()) {
                        echo "<option name='postalcode' value='" . $row['name'] . "'>" . $row['name'] . "</option>";
                    }
                    echo "<span></span>";
                    echo "</select> <br>";
                    ?>
                </div>
                <input type="submit" class="btn" name="submit" value="Club registrieren">
            </form>
        </section>
    </div>
</body>

</html>