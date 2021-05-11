<?php

if (isset($_POST["submit"])) {

    require_once 'db.inc.php';

    $username   = mysqli_real_escape_string($conn, $_POST["username"]);
    $email      = mysqli_real_escape_string($conn, $_POST["email"]);
    $pwd        = mysqli_real_escape_string($conn, $_POST["pwd"]);
    $pwdRepeat  = mysqli_real_escape_string($conn, $_POST["pwdRepeat"]);
    $firstname  = mysqli_real_escape_string($conn, $_POST["firstname"]);
    $lastname  = mysqli_real_escape_string($conn, $_POST["lastname"]);

    require_once 'functions.inc.php';

    if (emptyInputSignup($username, $email, $pwd, $pwdRepeat, $firstname, $lastname) !== false) {
        header("location: ../signup.php?error=emptyinput");
        exit();
    }
    if (invalidUsername($username) !== false) {
        header("location: ../signup.php?error=invalidusername");
        exit();
    }
    if (invalidEmail($email) !== false) {
        header("location: ../signup.php?error=invalidemail");
        exit();
    }
    if (pwdMatch($pwd, $pwdRepeat) !== false) {
        header("location: ../signup.php?error=passworddontmatch");
        exit();
    }
    if (UsernameExists($conn, $username, $email) !== false) {
        header("location: ../signup.php?error=usernametaken");
        exit();
    }
    if (HumanNameExists($conn, $firstname, $lastname) !== false) {
        header("location: ../signup.php?error=humanexist");
        exit();
    }

    createUser($conn, $firstname, $lastname, $username, $pwd, $email);
} else {
    header("location: ../signup.php");
    exit();
}
