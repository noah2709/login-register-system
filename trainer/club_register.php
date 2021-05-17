<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>Club Anmelden</title>
</head>

<body>
    <div class="errors">
        <?php
        if (isset($_GET['error'])) {
            if ($_GET['error'] == "emptyinput") {
                echo "<p id='warning_input'>Fill in all fields!</p>";
            } else if ($_GET['error'] == "invalidusername") {
                echo "<p id='error_pwd'>Choose a proper username!</p>";
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
            <form action="../inc/club_signup.inc.php" method="POST">
                <div class="text__field">
                    <input type="text" name="name" required>
                    <span></span>
                    <label>Club-Name</label>
                </div>
                <div class="text__field">
                    <input type="text" name="postalcode" required>
                    <span></span>
                    <label>Postalcode</label>
                </div>
                <input type="submit" class="btn" name="submit" value="Sign Up">
            </form>
        </section>
    </div>
</body>

</html>