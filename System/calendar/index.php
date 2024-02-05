<!DOCTYPE html>

<html>



<head>

<link rel="stylesheet" href="fullcalendar/fullcalendar.min.css" />

<script src="fullcalendar/lib/jquery.min.js"></script>

<script src="fullcalendar/lib/moment.min.js"></script>

<script src="fullcalendar/fullcalendar.min.js"></script>



<!-- Bootstrap -->

    <link href="../../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->

    <link href="../../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">

    <!-- NProgress -->

    <link href="../../vendors/nprogress/nprogress.css" rel="stylesheet">

    <!-- iCheck -->

    <link href="../../vendors/iCheck/skins/flat/green.css" rel="stylesheet">

    <!-- bootstrap-wysiwyg -->

    <link href="../../vendors/google-code-prettify/bin/prettify.min.css" rel="stylesheet">

    <!-- Select2 -->

    <link href="../../vendors/select2/dist/css/select2.min.css" rel="stylesheet">

    <!-- Switchery -->

    <link href="../../vendors/switchery/dist/switchery.min.css" rel="stylesheet">

    <!-- starrr -->

    <link href="../../vendors/starrr/dist/starrr.css" rel="stylesheet">

    <!-- bootstrap-daterangepicker -->

    <link href="../../vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">







<script>



$(document).ready(function () {

    var calendar = $('#calendar').fullCalendar({

        editable: true,

        events: "fetch-event.php",

        displayEventTime: false,

        eventRender: function (event, element, view) {

            if (event.allDay === 'true') {

                event.allDay = true;

            } else {

                event.allDay = false;

            }

        },

        selectable: false,

        selectHelper: true,

        select: function (start, end, allDay) {

            var title = prompt('Event Title:');



            if (title) {

                var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");

                var end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");



                $.ajax({

                    url: 'add-event.php',

                    data: 'title=' + title + '&start=' + start + '&end=' + end,

                    type: "POST",

                    success: function (data) {

                        displayMessage("Added Successfully");

                    }

                });

                calendar.fullCalendar('renderEvent',

                        {

                            title: title,

                            start: start,

                            end: end,

                            allDay: allDay

                        },

                true

                        );

            }

            calendar.fullCalendar('unselect');

        },

        

        editable: true,

        eventDrop: function (event, delta) {

                    var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");

                    var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");

                    $.ajax({

                        url: 'edit-event.php',

                        data: 'title=' + event.title + '&start=' + start + '&end=' + end + '&id=' + event.id,

                        type: "POST",

                        success: function (response) {

                            displayMessage("Updated Successfully");

                        }

                    });

                },

        /*eventClick: function (event) {

            var deleteMsg = confirm("Do you really want to delete?");

            if (deleteMsg) {

                $.ajax({

                    type: "POST",

                    url: "delete-event.php",

                    data: "&id=" + event.id,

                    success: function (response) {

                        if(parseInt(response) > 0) {

                            $('#calendar').fullCalendar('removeEvents', event.id);

                            displayMessage("Deleted Successfully");

                        }

                    }

                });

            }

        }*/



    });

});



function displayMessage(message) {

	    $(".response").html("<div class='success'>"+message+"</div>");

    setInterval(function() { $(".success").fadeOut(); }, 1000);

}

</script>



<style>

body {

    margin-top: 50px;

    text-align: center;

    font-size: 12px;

    font-family: "Lucida Grande", Helvetica, Arial, Verdana, sans-serif;

}



#calendar {

    width: 50%;

    height: auto;

    position: center;

}



.response {

    height: 60px;

}



.success {

    background: #cdf3cd;

    padding: 10px 60px;

    border: #c3e6c3 1px solid;

    display: inline-block;

}

</style>

</head>

<body>

    <a type="button" style="display: inline-block; padding: 10px 20px; text-decoration: none; background-color: blue; color: white; border-radius: 10px;" href="../admin/appointment.php">HOME</a>




    <center>

        <div class="response"></div>

    <div id='calendar'></div>

    </center>



</body>





</html>