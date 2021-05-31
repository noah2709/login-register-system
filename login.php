<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/2deba413ff.js" crossorigin="anonymous"></script>
    <title>Login</title>
</head>

<body>
    <div class="social_flyout">
        <ul class="some_list">
            <li><a href="index.php"><i class="fas fa-backward"></i></a></li>
            <li><a href="https://github.com/Taikador/login-register-system"><i class="fab fa-github"></i></a></li>
            <li><a href="#"><i class="fab fa-youtube"></i></a></li>
            <li><a href="#"><i class="fab fa-twitter"></i></a></li>
        </ul>
    </div>
    <div class="errors">
        <?php
        if (isset($_GET['error'])) {
            if ($_GET['error'] == "emptyinput") {
                echo "<div id='warning_input'>Fülle bitte alle Felder aus!</div>";
            } else if ($_GET['error'] == "wronglogin1") {
                echo "<div id='error_pwd'>Dein Passwort oder Benutzername/E-Mail ist falsch!</div>";
            } else if ($_GET['error'] == "wronglogin2") {
                echo "<div id='error_wpwd'>Dein Passwort oder Benutzername/E-Mail ist falsch!</div>";
            }
        }
        ?>
    </div>
    <div class="center">
        <section class="input__form">
            <h1>Einloggen</h1>
            <form action="./inc/login.inc.php" method="POST">
                <div class="text__field">
                    <input type="text" name="username" required>
                    <span></span>
                    <label>Benutzername/E-Mail</label>
                </div>
                <div class="text__field">
                    <input type="password" name="pwd" class="pwd" id="pwd" required>
                    <span></span>
                    <label>Passwort </label>
                    <i class="far fa-eye" id="pwd_eye"></i>
                </div>
                <input type="submit" class="btn" name="submit" value="Login">
                <div class="signup__link">
                    Kein Account? <a href="./signup.php">Registrieren</a>
                </div>
            </form>
        </section>
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

</body>
<script src="./javascript/registration.js"></script>

</html>