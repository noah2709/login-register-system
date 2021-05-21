<?php
session_start();
require_once '../inc/db.inc.php';
require_once '../inc/functions.inc.php';

if (isset($_SESSION)) {
    if (!isTrainer($conn, $_SESSION['userid']) and !isAdmin($conn, $_SESSION['userid'])) {
        header("location: ../error/error_403_page.php");
    }
} else {
    header("location: ../error/error_403_page.php");
}

?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <title>Club Registrieren</title>
</head>

<body>
    <div class="social_flyout">
        <ul class="some_list">
            <li><a href="../index.php"><i class="fas fa-backward"></i></a></li>
            <li><a href="https://github.com/Taikador/login-register-system"><i class="fab fa-github"></i></a></li>
            <li><a href="#"><i class="fab fa-youtube"></i></a></li>
            <li><a href="#"><i class="fab fa-twitter"></i></a></li>
        </ul>
    </div>
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
            <h1>Club registrieren</h1>
            <form action="../inc/club_signup.inc.php" method="POST">
                <div class="text__field">
                    <input type="text" name="name" required>
                    <span></span>
                    <label>Clubname</label>
                </div>
                <div class="text__field">
                    <?php
                    echo '<select name="postalcode" id="club_register_dropdown">';
                    $query = $conn->query("SELECT name FROM town");
                    while ($row = $query->fetch_assoc()) {
                        echo "<option name='postalcode' value='" . $row['name'] . "'>" . $row['name'] . "</option>";
                    }
                    echo "<span></span>";
                    echo "</select> <br>";
                    ?>
                </div>
                <input type="submit" class="btn" name="submit" value="Registrieren">
            </form>
        </section>
    </div>
</body>

</html>