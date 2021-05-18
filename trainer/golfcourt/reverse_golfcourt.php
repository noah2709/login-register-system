<?php
session_start();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Calendar</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
    <script>
        var t = false;

        function IsDateHasEvent(date) {
            var allEvents = [];
            allEvents = $('#calendar').fullCalendar('clientEvents');
            var event = $.grep(allEvents, function(v) {
                return +v.start === +date;
            });
            return event.length > 0;
        }
        $(document).ready(function() {
            var calendar = $('#calendar').fullCalendar({
                eventStartEditable: false,
                editable: true,
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                events: 'reverse_golfcourt_load.php',
                selectable: true,
                selectHelper: true,
                dayClick: function(date, allDay, jsEvent, view) {
                    // if (IsDateHasEvent(date)) {
                    // t = true;
                    // } else {
                    // t = false;
                    // }
                },
                select: function(start, end, allDay) {
                    if (t) {
                        return;
                    }
                    var title = prompt("Geben Sie ihren Club-Namen ein & den Golfplatz-Namen.");
                    var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");
                    var end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");
                    if (title) {
                        $.ajax({
                            url: "reverse_golfcourt_insert.php",
                            type: "POST",
                            data: {
                                title: title,
                                start: start,
                                end: end,
                            },
                            success: function() {
                                alert("Erfolgreich reserviert.");
                                calendar.fullCalendar('refetchEvents');
                            }
                        })
                    }
                },
                editable: true,
                // eventResize: function(event) {
                //     var title = event.title;
                //     var id = event.id;
                //     console.log("title: " + title);
                //     console.log("id: " + id);
                //     $.ajax({
                //         url: "update.php",
                //         type: "POST",
                //         data: {
                //             title: title,
                //             start: start,
                //             end: end,
                //             id: id
                //         },
                //         success: function() {
                //             calendar.fullCalendar('refetchEvents');
                //             alert('Event Update');
                //         }
                //     })
                // },
                eventClick: function(event) {
                    if (confirm("Möchtest du die Reservierung wirklich löschen?")) {
                        var court_id = event.court_id;
                        $.ajax({
                            url: "reverse_golfcourt_delete.php",
                            type: "POST",
                            data: {
                                court_id: court_id
                            },
                            success: function() {
                                calendar.fullCalendar('refetchEvents');
                                alert("Reservierung entfernt");
                            }
                        })
                    }
                },
            });
        });
    </script>
</head>

<body>
    <br />
    <h2 align="center">Golfplatz reservieren</h2>
    <br />
    <div class="container">
        <div id="calendar"></div>
    </div>
</body>

</html>