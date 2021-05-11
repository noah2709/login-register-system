<?php

function emptyInputSignup($username, $email, $pwd, $pwdRepeat)
{
    if (empty($username) || empty($email) || empty($pwd) || empty($pwdRepeat)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function invalidUsername($username)
{
    if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function invalidEmail($email)
{
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function pwdMatch($pwd, $pwdRepeat)
{
    if ($pwd !== $pwdRepeat) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function UsernameExists($conn, $username, $email)
{
    $sql    = "SELECT * FROM user WHERE username = ? OR email = ?;";
    $stmt   = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signup.php?error=SELECTFAILED");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    } else {
        $result = false;
        return $result;
    }
}
function HumanNameExists($conn, $firstname, $lastname)
{
    $sql    = "SELECT * FROM user WHERE firstname = ? OR lastname = ?;";
    $stmt   = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signup.php?error=SELECTFAILED");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $firstname, $lastname);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    } else {
        $result = false;
        return $result;
    }
}

function createUser($conn, $firstname, $lastname, $username, $password, $email)
// 
// Role_id 0 = User
// Role_id 1 = Trainer
// Role_id 2 = Admin
// 
// 
{
    $sql    = "INSERT INTO user (firstname, lastname, username, password, email, role_id, club_id) VALUES (?, ?, ?, ?, ?, ?, ?);";
    $stmt   = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signup.php?error=INSERTFAILED");
        exit();
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $role_id = 0;
    $club_id = NULL;

    mysqli_stmt_bind_param($stmt, "sssssii", $firstname, $lastname, $username, $hashedPassword, $email, $role_id, $club_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../signup.php?error=none");
    exit();
}

function emptyInputLogin($username, $pwd)
{
    if (empty($username) || empty($pwd)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function loginUser($conn, $username, $pwd)
{
    $usernameExists = UsernameExists($conn, $username, $username);

    if ($usernameExists === false) {
        header("location: ../login.php?error=wronglogin1");
        exit();
    }

    $pwdHashed  = $usernameExists['userPwd'];
    $checkPwd   = password_verify($pwd, $pwdHashed);

    if ($checkPwd === false) {
        header("location: ../login.php?error=wronglogin2");
        exit();
    } else if ($checkPwd === true) {
        session_start();
        $_SESSION['userid']     = $usernameExists['userId'];
        $_SESSION['username']   = $usernameExists['userName'];
        $_SESSION['role']       = $usernameExists['userRole'];
        header("location: ../index.php");
        exit();
    }
}
