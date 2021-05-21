<?php
session_start();
include_once '../inc/db.inc.php';
include_once '../inc/functions.inc.php';
?>

<?php


if (isset($_SESSION)) {
    if (!isAdmin($conn, $_SESSION['userid'])) {
        header("location: ../error/error_403_page.html");
    }
} else {
    header("location: ../error/error_403_page.html");
}

if (isset($_POST['submit'])) {

    $username = $_POST['username'];
    $email = $_POST['email'];
    $id = $_POST['id'];

    if (!empty($username) or !empty($email) or !empty($id)) {

        $stmt = $conn->prepare("DELETE FROM user WHERE username = ? or email = ? or user_id = ?");
        $stmt->bind_param("ssi", $username, $email, $id);

        $stmt->execute();
        $stmt->close();
    }
}

?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Benutzer löschen</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css" integrity="sha384-vSIIfh2YWi9wW0r9iZe7RJPrKwp6bG+s9QZMoITbCckVJqGCCRhc+ccxNcdpHuYu" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200&display=swap" rel="stylesheet">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>

<body>
    <div class="social_flyout">
        <ul class="some_list">
            <li><a href="../index.php"><i class="fas fa-backward"></i></a></li>
            <li><a href="https://github.com/Taikador/login-register-system"><i class="fab fa-github"></i></a></li>
            <li><a href="#"><i class="fab fa-youtube"></i></a></li>
            <li><a href="#"><i class="fab fa-twitter"></i></a></li>
        </ul>
    </div>
    <div class="wrapper">
        <table class="content">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Vorname</th>
                    <th>Nachname</th>
                    <th>Benutzername</th>
                    <th>E-Mail</th>
                </tr>
            </thead>
            <tbody>
                <?php

                $query = $conn->query("SELECT * FROM user");
                if ($query->num_rows <= 0) return;


                while ($row = $query->fetch_assoc()) {
                ?>

                    <tr>
                        <td><?php echo $row['user_id'] ?></td>
                        <td><?php echo $row['firstname'] ?></td>
                        <td><?php echo $row['lastname'] ?></td>
                        <td><?php echo $row['username'] ?></td>
                        <td><?php echo $row['email'] ?></td>
                        <td><i class="fas fa-trash" id="delete_trash"></i></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>

    </div>


</body>

<script src="../javascript/jquery.js"></script>

</html>