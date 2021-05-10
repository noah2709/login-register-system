<?php

if (isset($_POST["submit"])) {

    require_once 'db.inc.php';

    $username   = mysqli_real_escape_string($conn, $_POST['username']);
    $pwd        = mysqli_real_escape_string($conn, $_POST['pwd']);

    require_once 'functions.inc.php';

    if (emptyInputLogin($username, $pwd) !== false) {
        header("location: ../login.php?error=emptyinput");
        exit();
    }

    loginUser($conn, $username, $pwd);

}
else {
    header("location: ../login.php");
    exit();
}