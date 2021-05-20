<?php
session_start();

include_once '../inc/db.inc.php';
include_once '../inc/functions.inc.php';




if (isset($_POST["user_id"])) {

    $user_id = $_POST['user_id'];

    $query = "DELETE FROM user WHERE user_id ='$user_id'";
    $statement = $conn->prepare($query);
    $statement->execute();
}
