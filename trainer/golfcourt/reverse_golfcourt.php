<?php
session_start();
require_once '../../inc/functions.inc.php';
require_once '../../inc/db.inc.php';

if (isset($_SESSION)) {
    if (!isTrainer($conn, $_SESSION['userid']) and !isAdmin($conn, $_SESSION['userid'])) {
        header("location: ../../error/error_403_page.html");
    }
} else {
    header("location: ../../error/error_403_page.html");
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Golfplatz reservieren</title>
    <link rel="stylesheet" href="../../fullcalender.css" />
    <link rel="stylesheet" href="../../style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        var events = [];

        function getEvents(date) {
            var allEvents = [];
            allEvents = $('#calendar').fullCalendar('clientEvents');
            var event = $.grep(allEvents, function(v) {
                return +v.start === +date;
            });
            return event;
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
                    events = getEvents(date);
                },
                select: function(start, end, allDay) {
                    clubIds = [];
                    counter = 0;


                    events.forEach((element) => {
                        clubIds[counter] = element['club_id'];
                        counter++;
                    });

                    $.ajax({
                        url: "reverse_golfcourt_check_reserved.php",
                        type: "POST",
                        data: {
                            club_ids: clubIds,
                        },
                        error: function(jqXHR, exception) {
                            const formData = new FormData();
                            fetch('', {
                                method: "POST",
                                body: formData
                            }).then(function(response) {}).then(function(text) {
                                console.log(text);
                            }).catch(function(error) {
                                concole.error(error);
                            }).then(function(onclick) {
                                Swal.fire({
                                    position: 'center',
                                    icon: 'error',
                                    title: 'Du hast an diesem Tag bereits eine Reservierung erstellt!',
                                    showConfirmButton: true,
                                })
                            })
                        },
                        success: function() {

                            $start = start;
                            $end = start;
                            var inputOptionsPromise = new Promise(function(resolve) {
                                $.ajax({
                                    url: "reverse_golfcourt_load_golfcourt.php",
                                    success: function(dataArray) {
                                        const parsed = JSON.parse(dataArray);

                                        names = []

                                        if (events.length >= 1) {
                                            for (i = 0; i < parsed.length; i++) {
                                                events.forEach((element) => {
                                                    if (element['court'] === parsed[i]["name"]) {
                                                        return "continue";
                                                    }
                                                    names[i] = parsed[i]["name"];
                                                });
                                            }
                                        } else {
                                            for (i = 0; i < parsed.length; i++) {
                                                names[i] = parsed[i]["name"];
                                            }
                                        }

                                        setTimeout(function() {
                                            resolve({
                                                names: names
                                            })
                                        })


                                        Swal.fire({
                                            title: "Wähle einen Golfplatz aus.",
                                            showDenyButton: true,
                                            denyButtonText: "Abbrechen",
                                            input: "select",
                                            inputOptions: inputOptionsPromise,
                                        }).then((result) => {
                                            if (result.isConfirmed) {

                                                const finalName = names[result.value];
                                                var start = $.fullCalendar.formatDate($start, "Y-MM-DD");
                                                var end = $.fullCalendar.formatDate($end, "Y-MM-DD");
                                                $.ajax({
                                                    url: "reverse_golfcourt_insert.php",
                                                    type: "POST",
                                                    data: {
                                                        title: finalName,
                                                        start: start,
                                                        end: end,
                                                    },
                                                    success: function() {
                                                        calendar.fullCalendar('refetchEvents');
                                                        const formData = new FormData();
                                                        fetch('reverse_golfcourt_insert.php', {
                                                            method: "POST",
                                                            body: formData
                                                        }).then(function(response) {
                                                            return response.text();
                                                        }).then(function(text) {
                                                            console.log(text);
                                                        }).catch(function(error) {
                                                            concole.error(error);
                                                        }).then(function(onclick) {
                                                            Swal.fire({
                                                                position: 'center',
                                                                icon: 'success',
                                                                title: 'Golfplatz erfolgreich reserviert!',
                                                                showConfirmButton: false,
                                                                timer: 1500,
                                                            })
                                                        })
                                                    }
                                                })
                                            }
                                        })
                                    }
                                })
                            });




                        }
                    })


                },
                editable: true,
                eventClick: function(event) {
                    Swal.fire({
                        title: "Möchtest du die Reservierung wirklich löschen?",
                        showConfirmButton: true,
                        showDenyButton: true,
                        denyButtonText: "Nein",
                        confirmButtonText: "Ja",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            var reserve_id = event.reserve_id;

                            $.ajax({
                                url: "reverse_golfcourt_check.php",
                                type: "POST",
                                data: {
                                    reserve_id: reserve_id
                                },
                                error: function(jqXHR, exception) {
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
                                        Swal.fire({
                                            position: 'center',
                                            icon: 'error',
                                            title: 'Du kannst diese Reservierung nicht löschen!',
                                            showConfirmButton: false,
                                            timer: 1500,
                                        })
                                    })
                                },
                                success: function() {
                                    $.ajax({
                                        url: "reverse_golfcourt_delete.php",
                                        type: "POST",
                                        data: {
                                            reserve_id: reserve_id
                                        },
                                        success: function() {
                                            calendar.fullCalendar('refetchEvents');
                                            const formData = new FormData();
                                            fetch('reverse_golfcourt_delete.php', {
                                                method: "POST",
                                                body: formData
                                            }).then(function(response) {
                                                return response.text();
                                            }).then(function(text) {
                                                console.log(text);
                                            }).catch(function(error) {
                                                concole.error(error);
                                            }).then(function(onclick) {
                                                Swal.fire({
                                                    position: 'center',
                                                    icon: 'success',
                                                    title: 'Reservierung erfolgreich gelöscht!',
                                                    showConfirmButton: false,
                                                    timer: 1500,
                                                })
                                            })
                                        }
                                    })
                                }
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
            <li><a href="../../index.php"><i class="fas fa-backward"></i></a></li>
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
                    <img style='opacity: 0.76;' src='../../img/golf_4.jpg'> alt="picture 1 not found">
                </div>
            </div>
        </div>
    </div>
</body>

</html>