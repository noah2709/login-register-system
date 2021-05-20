<?php
require_once 'db.inc.php';
?>
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

function emptyClubInputSignup($clubName, $postalCode)
{
    if (empty($clubName) || empty($postalCode)) {
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
function ClubNameExists($conn, $clubName)
{
    $sql    = "SELECT * FROM club WHERE name = ?;";
    $stmt   = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signup.php?error=SELECTFAILED");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $clubName);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    } else {
        $result = false;
        return $result;
    }
}

function tokenExists($conn, $token)
{

    $sql = "SELECT * FROM club WHERE token = '$token'";
    $stmt = $conn->query($sql);

    return $stmt->num_rows >= 1;
}

function enterClub($conn, $club_id, $user_id)
{

    $token = generateToken(9);

    $updateTokenStmt = $conn->prepare("UPDATE club SET token = '$token' WHERE club_id = '$club_id'");
    $updateTokenStmt->execute();
    $updateTokenStmt->close();

    $updateStmt = $conn->prepare("UPDATE user SET club_id = '$club_id' WHERE user_id = '$user_id'");
    $updateStmt->execute();
    $updateStmt->close();
}

function generateToken($length)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function createUser($conn, $firstname, $lastname, $username, $password, $email)
// 
// Role_id 1 = User
// Role_id 2 = Trainer
// Role_id 3 = Admin
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

    $role_id = 1;
    $club_id = NULL;

    mysqli_stmt_bind_param($stmt, "sssssii", $firstname, $lastname, $username, $hashedPassword, $email, $role_id, $club_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../signup.php?error=none");
    exit();
}
function createClub($conn, $clubName, $postalCode, $userId)

{
    $sql    = "INSERT INTO club (name, wins, losses, postalcode) VALUES (?, ?, ?, ?);";
    $stmt   = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../trainer/club_register.php?error=INSERTFAILED");
        exit();
    }

    $wins = 0;
    $losses = 0;

    mysqli_stmt_bind_param($stmt, "siii", $clubName, $wins, $losses, $postalCode);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);



    $highestClubId = -1;
    $query = $conn->query("SELECT club_id FROM club");
    while ($row = $query->fetch_assoc()) {
        if ($row['club_id'] > $highestClubId) {
            $highestClubId = $row['club_id'];
        }
    }

    $updateStmt = $conn->prepare("UPDATE user SET club_id = '$highestClubId' WHERE user_id = '$userId'");
    $updateStmt->execute();
    $updateStmt->close();

    header("location: ../index.php?error=none");
    exit();
}


function createEvent($conn, $starttime, $endtime, $winner, $club_id1, $club_id2, $court_id)
{

    $sql = "INSERT INTO event (starttime, endtime, winner, club_id1, club_id2, court_id) VALUES (?,?,?,?,?,?)";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../admin/event.php?error=INSERTFAILED");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ssiiii", $starttime, $endtime, $winner, $club_id1, $club_id2, $court_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../admin/event.php?error=none");
    exit();
}


function hasClub($conn, $userId)
{
    $query = $conn->query("SELECT club_id FROM user WHERE user_id = '$userId'");

    while ($row = $query->fetch_assoc()) {
        if ($row['club_id'] == null) {
            return false;
        } else {
            return true;
        }
    }

    return false;
}

function getRoleName($conn, $userId)
{
    $query = $conn->query("SELECT role_id FROM user WHERE user_id = '$userId'");

    $role_id = -1;

    while ($row = $query->fetch_assoc()) {
        $role_id = $row['role_id'];
    }

    $roleQuery = $conn->query("SELECT role_name FROM role WHERE role_id = '$role_id'");

    $role_name = "User";

    while ($row = $roleQuery->fetch_assoc()) {
        $role_name = $row['role_name'];
    }
    return $role_name;
}

function isAdmin($conn, $userId)
{
    $role_name = getRoleName($conn, $userId);
    return strcasecmp($role_name, "admin") == 0;
}

function isTrainer($conn, $userId)
{
    $role_name = getRoleName($conn, $userId);
    return strcasecmp($role_name, "trainer") == 0;
}

function getClub($conn, $userId)
{
    $query = $conn->query("SELECT club_id FROM user WHERE user_id = '$userId'");

    $club_id = null;

    while ($row = $query->fetch_assoc()) {
        if ($row['club_id'] != NULL) {
            $club_id = $row['club_id'];
        }
    }

    if ($club_id == NULL) {
        return NULL;
    }

    $clubQuery = $conn->query("SELECT * FROM club WHERE club_id = '$club_id'");

    if ($clubQuery->num_rows <= 0) {
        return null;
    }

    return $clubQuery->fetch_assoc();
}

function getClubFromClubId($conn, $clubId)
{

    $clubQuery = $conn->query("SELECT * FROM club WHERE club_id = '$clubId'");
    if ($clubQuery->num_rows <= 0) {
        return null;
    }
    return $clubQuery->fetch_assoc();
}

function getTownIdFromName($conn, $townName)
{
    $query = $conn->query("SELECT postalcode FROM town WHERE name ='$townName'");
    if ($query->num_rows <= 0) {
        return null;
    }
    $id = -1;
    while ($row = $query->fetch_assoc()) {
        $id = $row['postalcode'];
    }
    return $id;
}

function getClubIdFromName($conn, $clubName)
{

    $query = $conn->query("SELECT club_id FROM club WHERE name = '$clubName'");

    $id = -1;

    while ($row = $query->fetch_assoc()) {
        $id = $row['club_id'];
    }

    return $id;
}

function getCourtFromName($conn, $courtName)
{

    $query = $conn->query("SELECT court_id FROM golfcourt WHERE name = '$courtName'");

    $id = -1;

    while ($row = $query->fetch_assoc()) {
        $id = $row['court_id'];
    }

    return $id;
}

function canDeleteReserve($conn, $court_id, $club_id)
{
    $query = $conn->query("SELECT club_id FROM reserve WHERE court_id = '$court_id'");

    $clubIdFromDatabase = -1;

    while ($row = $query->fetch_assoc()) {
        $clubIdFromDatabase = $row['club_id'];
    }

    return $clubIdFromDatabase == $club_id;
}

function getCourtFromId($conn, $courtId)
{

    $query = $conn->query("SELECT name FROM golfcourt WHERE court_id = '$courtId'");

    $courtName = -1;

    while ($row = $query->fetch_assoc()) {
        $courtName = $row['name'];
    }

    return $courtName;
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

function sameClubId($clubId1, $clubId2)
{
    return $clubId1 == $clubId2;
}

function loginUser($conn, $username, $pwd)
{
    $usernameExists = UsernameExists($conn, $username, $username);

    if ($usernameExists === false) {
        header("location: ../login.php?error=wronglogin1");
        exit();
    }

    $pwdHashed  = $usernameExists['password'];
    $checkPwd   = password_verify($pwd, $pwdHashed);

    if ($checkPwd === false) {
        header("location: ../login.php?error=wronglogin2");
        exit();
    } else if ($checkPwd === true) {
        session_start();
        $_SESSION['userid']     = $usernameExists['user_id'];
        $_SESSION['username']   = $usernameExists['username'];
        $_SESSION['role']       = getRoleFromId($usernameExists['role_id']);
        header("location: ../index.php");
        exit();
    }
}


function getRoleFromId($id)
{

    switch ($id) {

        case 1:
            return "User";
            break;
        case 2:
            return "Trainer";
            break;
        case 3:
            return "Admin";
            break;

        default:
            return "User";
            break;
    }
}
