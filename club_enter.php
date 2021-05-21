<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Club Enter</title>
</head>

<body>
    <div class="social_flyout">
        <ul class="some_list">
            <li><a href="index.php">Zurück</a></li>
            <li><a href="https://github.com/Taikador/login-register-system"><i class="fab fa-github">Github</i></a></li>
        </ul>
    </div>
    <div class="errors">
        <?php
        if (isset($_GET['error'])) {
            if ($_GET['error'] == "emptyinput") {
                echo "<p id='warning_input'>Fülle bitte alle Felder aus!</p>";
            } else if ($_GET['error'] == "invalidtoken") {
                echo "<p id='error_pwd'>Bitte gib einen gültigen Token ein!</p>";
            } else if ($_GET['error'] == "SELECTFAILED") {
                echo "<p id='error_pwd'>Irgendetwas ist schiefgelauen, probiere nochmal.</p>";
                echo "<br><br>";
                echo "Error Code: 1";
            } else if ($_GET['error'] == "INPUTFAILED") {
                echo "<p id='error_pwd'>Irgendetwas ist schiefgelauen, probiere nochmal.</p>";
                echo "<br><br>";
                echo "Error Code: 2";
            } else if ($_GET['error'] == "none") {
                echo "<p id='succes'>Du bist dem Club erfolgreich beigetreten!</p>";
            }
        }
        ?>
    </div>
    <div class="center">
        <section class="input__form">
            <h1>Club beitreten</h1>
            <form action="../inc/club_enter.inc.php" method="POST">
                <div class="text__field">
                    <input type="text" name="token" required>
                    <span></span>
                    <label>Club Token</label>
                </div>
                <input type="submit" class="btn" name="submit" value="Club beitreten">
            </form>
        </section>
    </div>
</body>

</html>