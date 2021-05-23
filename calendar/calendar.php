<?php
session_start();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Alle Termine</title>
    <link rel="stylesheet" href="../fullcalender.css" />
    <link rel="stylesheet" href="../style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        $(document).ready(function() {
            var calendar = $('#calendar').fullCalendar({
                eventStartEditable: false,
                editable: true,
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                events: 'calendar_appointments_load.php',
                selectable: true,
                selectHelper: true,
                eventClick: function(event) {
                    console.log(event);
                    var start = (event.start == null ? "Unbekannt" : $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss"));
                    var end = (event.end == null ? "Unbekannt" : $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss"));
                    var title = event.title;

                    const formData = new FormData();
                    fetch('', {
                        method: "POST",
                        body: formData
                    }).then(function(response) {
                        return response.text();
                    }).then(function(text) {
                        console.log(text);
                    }).catch(function(error) {
                        concole.error(error);
                    }).then(function(onclick) {
                        if (title.startsWith("Reserve")) {
                            Swal.fire({
                                position: 'center',
                                titleText: 'Informationen:',
                                html: "Titel: " + title,
                                showConfirmButton: true,
                            })
                        } else {
                            Swal.fire({
                                position: 'center',
                                titleText: 'Informationen:',
                                html: "Start: " + start + "<br> Ende: " + end + "<br> Titel: " + title,
                                showConfirmButton: true,
                            })
                        }
                    })
                },
            });
        });
    </script>
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
    <br />
    <br />
    <div class="container">
        <div id="calendar"></div>
    </div>
    <div class='centered_pictures'>
        <div class='slidershow middle'>
            <div class='slides'>
                <input type='radio' name='r' id='r1' checked hidden>
                <input type='radio' name='r' id='r2' hidden>
                <input type='radio' name='r' id='r3' hidden>
                <div class='slide s1'>
                    <img style='opacity: 0.76;' src='../img/golf_4.jpg'> alt="picture 1 not found">
                </div>
            </div>
        </div>
    </div>


    <div class="datenschutz__impressum">
        <ul>
            <li>
                <a href="../impressum.php">Impressum</a>
            </li>
            <li>
                <a href="../privacy.php">Datenschutz</a>
            </li>
        </ul>
    </div>


    <footer><i class="far fa-copyright"> Copyright 2021</i></footer>
</body>

</html>