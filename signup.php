<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/2deba413ff.js" crossorigin="anonymous"></script>
    <title>Registrieren</title>
</head>

<body>
    <div class="errors">
        <?php
        if (isset($_GET['error'])) {
            if ($_GET['error'] == "emptyinput") {
                echo "<p id='warning_input'>Fülle bitte alle Felder aus!</p>";
            } else if ($_GET['error'] == "invalidusername") {
                echo "<p id='error_pwd'>Wähle bitte einen validen Namen aus!</p>";
            } else if ($_GET['error'] == "humanexist") {
                echo "<p id='error_pwd'>Der Vor/Nach -name ist bereits vergeben!</p>";
            } else if ($_GET['error'] == "invalidemail") {
                echo "<p id='error_pwd'>Wähle bitte eine valide E-Mail!</p>";
            } else if ($_GET['error'] == "usernametaken") {
                echo "<p id='error_pwd'>Dieser Benutzer existiert bereits!</p>";
            } else if ($_GET['error'] == "passworddontmatch") {
                echo "<p id='error_pwd'>Die Passwörter stimmen nicht überein.</p>";
            } else if ($_GET['error'] == "SELECTFAILED") {
                echo "<p id='error_pwd'>Irgendetwas ist schiefgelauen, probiere nochmal.</p>";
                echo "<br><br>";
                echo "Error Code: 1";
            } else if ($_GET['error'] == "INPUTFAILED") {
                echo "<p id='error_pwd'>Irgendetwas ist schiefgelauen, probiere nochmal.</p>";
                echo "<br><br>";
                echo "Error Code: 2";
            } else if ($_GET['error'] == "none") {
                echo "<p id='succes'>Erfolgreich registriert!</p>";
            }
        }
        ?>
    </div>
    <div class="social_flyout">
        <ul class="some_list">
            <li><a href="index.php"><i class="fas fa-backward"></i></a></li>
            <li><a href="https://github.com/Taikador/login-register-system"><i class="fab fa-github"></i></a></li>
            <li><a href="#"><i class="fab fa-youtube"></i></a></li>
            <li><a href="#"><i class="fab fa-twitter"></i></a></li>
        </ul>
    </div>
    <div class="center">
        <section class="input__form">
            <h1>Registrieren</h1>
            <form action="../login-register-system/inc/signup.inc.php" method="POST">
                <div class="text__field">
                    <input type="text" name="firstname" required>
                    <span></span>
                    <label>Vorname</label>
                    <label hidden><i class="fas fa-times"></i></label>
                </div>
                <div class="text__field">
                    <input type="text" name="lastname" required>
                    <span></span>
                    <label>Nachname</label>
                </div>
                <div class="text__field">
                    <input type="text" name="username" required>
                    <span></span>
                    <label>Benutzername</label>
                </div>
                <div class="text__field">
                    <input type="email" name="email" required>
                    <span></span>
                    <label>E-Mail</label>
                </div>
                <div class="text__field">
                    <input type="password" class="pwd" id="pwd" name="pwd" required>
                    <span></span>
                    <label>Passwort <i style="color: red;" id="pwd_validity">✖</i></label>
                    <i class="far fa-eye" id="pwd_eye"></i>
                </div>
                <div class="text__field">
                    <input type="password" class="pwd" id="pwdRepeat" name="pwdRepeat" required>
                    <span></span>
                    <label>Wiederhole Passwort <i style="color: red;" id="pwd_validity_repeat">✖</i></label>
                    <i class="far fa-eye" id="pwd_eye_repeat"></i>
                </div>
                <input type="submit" class="btn" id="signup_submit" name="submit" value="Registrieren">
                <div class="signup__link">
                    Bereits einen Account? <a href="./login.php">Einloggen</a>
                </div>
            </form>
        </section>
    </div>
</body>

<script src="./javascript/registration.js"></script>

</html>