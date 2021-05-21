$(document).ready(function () {

    $('.fas').click(function () {
        console.log("a");
        var $row = jQuery(this).closest('tr');
        var $columns = $row.find('td');

        var values = "";

        jQuery.each($columns, function (i, item) {
            values = values + item.innerHTML
        });
        var idAsString = values[0] + values[1];
        var id = parseInt(idAsString);

        $.ajax({
            type: "POST",
            url: "../inc/delete.inc.php",
            data: {
                user_id: id,
            },
            success: function () {
                setTimeout(function () { location.reload(); }, 2000);
                const formData = new FormData();
                fetch('../admin/delete.php', {
                    method: "POST",
                    body: formData
                }).then(function (response) {
                    return response.text();
                }).then(function (text) {
                    console.log(text);
                }).catch(function (error) {
                    concole.error(error);
                }).then(function (onclick) {
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Benutzer wurde erfolgreich gelöscht!',
                        showConfirmButton: false,
                        timer: 1500,
                    })
                })
            }

        });

    });

});