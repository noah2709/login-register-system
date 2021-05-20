<?php
session_start();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Alle Termine</title>
    <link rel="stylesheet" href="../fullcalender.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
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
                    var start = (event.start == null ? "Unbekannt" : $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss"));
                    var end = (event.end == null ? "Unbekannt" : $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss"));
                    var title = event.title;
                    prompt("Start: " + start + " | Ende: " + end + " | Titel: " + title);
                },
            });
        });
    </script>
</head>

<body>
    <form action="../index.php" class="backform">
        <input type="submit" name="submit" value="Zurück">
    </form>
    <br />
    <h2 align="center">Alle Termine</h2>
    <br />
    <div class="container">
        <div id="calendar"></div>
    </div>
</body>

</html>