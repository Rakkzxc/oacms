<?php

    require_once "../connection.php";



    $json = array();

    $sqlQuery = "SELECT 
                    CONCAT(s.title, ' | ', p.pname) AS title,
                    a.appodate AS start,
                    d.docname AS doctor_assigned
                FROM 
                    appointment a
                INNER JOIN 
                    patient p ON a.pid = p.pid
                INNER JOIN 
                    schedule s ON a.scheduleid = s.scheduleid
                INNER JOIN 
                    doctor d ON s.docid = d.docid";



    $result = mysqli_query($database, $sqlQuery);

    $eventArray = array();

    while ($row = mysqli_fetch_assoc($result)) {

        array_push($eventArray, $row);

    }

    mysqli_free_result($result);



    mysqli_close($database);

    echo json_encode($eventArray);

?>