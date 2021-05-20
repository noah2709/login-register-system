<?php
session_start();
include_once '../inc/db.inc.php';
include_once '../inc/functions.inc.php';
if (isset($_SESSION)) {
    if (!isAdmin($conn, $_SESSION['userid'])) {
        header("location: ../error/error_403_page.html");
    }
} else {
    header("location: ../error/error_403_page.html");
}
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Benutzer suchen</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css" integrity="sha384-vSIIfh2YWi9wW0r9iZe7RJPrKwp6bG+s9QZMoITbCckVJqGCCRhc+ccxNcdpHuYu" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200&display=swap" rel="stylesheet">
</head>

<body>
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

                if ($query->num_rows > 0) {
                    if (isset($_POST['username']) and isset($_POST['email']) and isset($_POST['id'])) {
                        $username = $_POST['username'];
                        $email = $_POST['email'];
                        $id = $_POST['id'];
                    }

                    while ($row = $query->fetch_assoc()) {

                        if (isset($_POST['submit'])) {

                            if (!empty($username) or !empty($email) or !empty($id)) {
                                if (strcasecmp($row['username'], $username) == 0 or strcasecmp($row['email'], $email) == 0 or $row['user_id'] == $id) {
                ?>

                                    <tr>
                                        <td id="serachid"><?php echo $row['user_id'] ?></td>
                                        <td id="searchuserid"><?php echo $row['firstname'] ?></td>
                                        <td id="emailid"><?php echo $row['lastname'] ?></td>
                                        <td id="emailid"><?php echo $row['username'] ?></td>
                                        <td id="emailid"><?php echo $row['email'] ?></td>
                                    </tr>
                        <?php
                                    continue;
                                }
                            }
                        }
                        ?>

                        <tr>
                            <td><?php echo $row['user_id'] ?></td>
                            <td><?php echo $row['firstname'] ?></td>
                            <td><?php echo $row['lastname'] ?></td>
                            <td><?php echo $row['username'] ?></td>
                            <td><?php echo $row['email'] ?></td>
                        </tr>
                <?php
                    }
                    $query->close();
                }
                ?>
            </tbody>
        </table>
        <div class="h1">
            <h1>Benutzer suchen</h1>
        </div>
        <div class="deletebox">
            <form action="" method="POST" class="deleteform">
                <input type="text" name="username" placeholder="Username">
                <i class="fas fa-angle-double-down" id="doublearrowdown"></i>
                <input type="email" name="email" placeholder="E-Mail">
                <i class="fas fa-angle-double-down" id="doublearrowdown"></i>
                <input type="number" name="id" placeholder="ID">
                <i class="fas fa-angle-double-down" id="doublearrowdown"></i>
                <input type="submit" name="submit" class="deletesubmit" id="deletesubmit" value="Benutzer suchen">
            </form>
            <form action="../index.php" class="backform">
                <input type="submit" name="submit" value="Zurück">
            </form>
        </div>


    </div>


</body>

</html>