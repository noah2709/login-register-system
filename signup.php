<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Sign-Up</title>
</head>

<body>
    <div class="errors">
        <?php
        if (isset($_GET['error'])) {
            if ($_GET['error'] == "emptyinput") {
                echo "<p id='warning_input'>Fill in all fields!</p>";
            } else if ($_GET['error'] == "invalidusername") {
                echo "<p id='error_pwd'>Choose a proper username!</p>";
            } else if ($_GET['error'] == "humanexist") {
                echo "<p id='error_pwd'>Firstname / Lastname already taken!</p>";
            } else if ($_GET['error'] == "invalidemail") {
                echo "<p id='error_pwd'>Choose a proper Email!</p>";
            } else if ($_GET['error'] == "usernametaken") {
                echo "<p id='error_pwd'>That username already exists!</p>";
            } else if ($_GET['error'] == "passworddontmatch") {
                echo "<p id='error_pwd'>Passwords doesn't match</p>";
            } else if ($_GET['error'] == "SELECTFAILED") {
                echo "<p id='error_pwd'>Something went wrong, try again</p>";
                echo "<br><br>";
                echo "Error Code: 1";
            } else if ($_GET['error'] == "INPUTFAILED") {
                echo "<p id='error_pwd'>Something went wrong, try again</p>";
                echo "<br><br>";
                echo "Error Code: 2";
            } else if ($_GET['error'] == "none") {
                echo "<p id='succes'>Succesfully signed up!</p>";
            }
        }
        ?>
    </div>
    <div class="center">
        <section class="input__form">
            <h1>Sign Up</h1>
            <form action="../login-register-system/inc/signup.inc.php" method="POST">
                <div class="text__field">
                    <input type="text" name="firstname" required>
                    <span></span>
                    <label>Firstname</label>
                </div>
                <div class="text__field">
                    <input type="text" name="lastname" required>
                    <span></span>
                    <label>Lastname</label>
                </div>
                <div class="text__field">
                    <input type="text" name="username" required>
                    <span></span>
                    <label>Username</label>
                </div>
                <div class="text__field">
                    <input type="email" name="email" required>
                    <span></span>
                    <label>Email</label>
                </div>
                <div class="text__field">
                    <input type="password" class="pwd" name="pwd" required>
                    <span></span>
                    <label>Password</label>
                </div>
                <div class="text__field">
                    <input type="password" class="pwd" name="pwdRepeat" required>
                    <span></span>
                    <label>Repeat Password</label>
                </div>
                <input type="submit" class="btn" name="submit" value="Sign Up">
                <div class="signup__link">
                    Alreay member? <a href="./login.php">Log In</a>
                </div>
            </form>
        </section>
    </div>
</body>

</html>