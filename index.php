<?php
session_start();
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/2deba413ff.js" crossorigin="anonymous"></script>
    <title>Login System</title>
</head>

<body>
    <div class="header">
        <?php
        if (isset($_SESSION['role'])) {
            if ($_SESSION['role'] == "admin") {
                include_once 'inc/db.inc.php';

                $username = $_SESSION['username'];

                $sql        = 'SELECT user_id, firstname, lastname, username, password, email,role_id, club_id FROM user';
                $dbquery    = $conn->prepare($sql);
                $dbquery->execute();
                $result     = $dbquery->get_result();
                $data       = $result->fetch_all();

                echo "<h1>Admin Panel<h1>";
                echo "<br><br>";
                echo "<h3>Welcome $username !<h3>";

                echo "<table class= 'query_table' method='POST' id='query_table'>";
                echo "<thead><tr>";
                echo "<td>ID</td><td>Username</td><td>Email</td><td>Role</td>";
                echo "</tr></thead>";

                foreach ($data as $row) {
                    $cssClasses = (isset($_POST['submit_search']) && in_array($row[0], $ids)) ? 'highlight' : '';

                    echo '<tr class="' . $cssClasses . '">';
                    echo "<td>" . $row["0"] . "</td>";
                    echo "<td>" . $row["1"] . "</td>";
                    echo "<td>" . $row["2"] . "</td>";
                    echo "<td>" . $row["3"] . "</td>";
                    echo "<td>" . "<a href = 'inc/delete.php?rn=$row[0]'>" . " <i class='fas fa-trash'></i>" . "</td>";
                    echo "</tr>";
                }
                echo "<div class='logout'><button class='logout__btn'><a href='inc/logout.inc.php'>Logout</a></button></div>";
            } else {

                include_once 'inc/db.inc.php';

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
                    echo "<td>" . $row["2"] . "</td>";
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