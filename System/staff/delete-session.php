<?php

    session_start();

    if(($_SESSION["user"])=="" or $_SESSION['usertype']!='s'){
            header("location: ../login.php");
        }
    
    
    if($_GET){
        //import database
        include("../connection.php");
        $id=$_GET["id"];
        //$result001= $database->query("select * from schedule where scheduleid=$id;");
        //$email=($result001->fetch_assoc())["docemail"];
        $sql= $database->query("delete from schedule where scheduleid='$id';");
        //$sql= $database->query("delete from doctor where docemail='$email';");
        //print_r($email);
        header("location: schedule.php");
    }


?>