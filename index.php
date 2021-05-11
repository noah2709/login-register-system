<?php
session_start();
include_once 'inc/db.inc.php';
include_once 'inc/functions.inc.php';
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/2deba413ff.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200&display=swap" rel="stylesheet">
    <title>Login System</title>
</head>

<body>
    <div class="header">
        <?php
        if (isset($_SESSION['role'])) {
            if (strcasecmp($_SESSION['role'], "admin") == 0) {
        ?>
                <div class='logout'><button class='logout__btn'><a href='inc/logout.inc.php'>Logout</a></button></div>
                <div class="h1">
                    <h1>Admin Panel</h1>
                </div>
                <div class="allboxes">
                    <div class="boxleft">
                        <div class="boxtitle">
                            <p>Benutzer löschen</p><i class="fas fa-user-slash"></i>
                        </div>
                        <div class="boxleft_content">
                            <p>Klicke unten, um zu dem Formular zu gelangen, wo du Benutzer löschen kannst.</p>
                        </div>
                        <div class="boxleft_attention">
                            <p>Achtung! Gelöschte Benutzer können selbst vom Admin nicht wiederhergestellt werden.</p>
                        </div>
                        <div class="littlebox">
                            <a href="./admin/delete.php">
                                <div class="littlebox_text">
                                    <p>Zum Formular ≫</p>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="boxmiddle">
                        <div class="boxtitle">
                            <p>Benutzer bearbeiten</p><i class="fas fa-user-edit"></i>
                        </div>
                        <div class="boxleft_content">
                            <p>Klicke unten, um zu dem Formular zu gelangen, wo du Benutzer bearbeiten kannst.</p>
                        </div>
                        <div class="littlebox">
                            <a href="./admin/update.php">
                                <div class="littlebox_text">
                                    <p>Zum Formular ≫</p>
                                </div>
                            </a>
                        </div>

                    </div>
                    <div class="boxright">
                        <div class="boxtitle">
                            <p>Benutzer suchen</p><i class="fas fa-search"></i>
                        </div>
                        <div class="boxleft_content">
                            <p>Klicke unten, um zu dem Formular zu gelangen, wo du Benutzer suchen kannst.</p>
                        </div>
                        <div class="littlebox">
                            <a href="./admin/search.php">
                                <div class="littlebox_text">
                                    <p>Zum Formular ≫</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
        <?php
            } else {

                $userid = $_SESSION['userid'];
                $username = $_SESSION['username'];

                $sql        = "SELECT * FROM user WHERE user_id = '$userid'";
                $dbquery    = $conn->prepare($sql);
                $dbquery->execute();
                $result     = $dbquery->get_result();
                $data       = $result->fetch_all();

                echo "<h1>User Panel<h1>";
                echo "<br>";
                echo "<h3>Welcome $username !<h3>";
                echo "<br><br>";

                echo "<table class= 'query_table' method='POST' id='query_table'>";
                echo "<thead><tr>";
                echo "<td>Username</td><td>Email</td>";
                echo "</tr></thead>";

                foreach ($data as $row) {
                    echo "<td>" . $row["1"] . "</td>";
                    echo "<td>" . $row["5"] . "</td>";
                    echo "</tr>";
                }

                echo "<div class='logout'><button class='logout__btn'><a href='inc/logout.inc.php'>Logout</a></button></div>";
            }
        } else {
            echo "<h1>Login/Register - System<h1>";
            echo "<br><br>";
            echo "<div class='signup'>
                    <button class='signup__btn'><a href='signup.php'>Sign Up</a></button>
                    </div>";
            echo "<div class='login'>
                    <button class='login__btn'><a href='login.php'>Log In</a></button>
                    </div>";
        }

        ?>
</body>

</html>