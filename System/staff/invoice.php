<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/animations.css">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/admin.css">
    <title>Invoice</title>
</head>

<body> <?php

    //learn from w3schools.com

    session_start();

    if(($_SESSION["user"])=="" or $_SESSION['usertype']!='s'){
            header("location: ../login.php");
        }
    
    

    //import database
    include("../connection.php");

    
    ?> <div class="container">
        <?php require_once "menu.php"; ?>
    <div class="dash-body">
        <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;margin-top:25px; ">
            <tr>
                <td width="13%">
                    <a href="patient.php"><button class="login-btn btn-primary-soft btn btn-icon-back" style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px">
                            <font class="tn-in-text">Back</font>
                        </button></a>
                </td>
                <td>
                    <form action="" method="post" class="header-search">
                        <input type="search" name="search" class="input-text header-searchbar" placeholder="Search Patient name or Email" list="patient">&nbsp;&nbsp; <?php
                                echo '<datalist id="patient">';
                                $list11 = $database->query("select  pname,pemail from patient;");

                                for ($y=0;$y<$list11->num_rows;$y++){
                                    $row00=$list11->fetch_assoc();
                                    $d=$row00["pname"];
                                    $c=$row00["pemail"];
                                    echo "<option value='$d'><br/>";
                                    echo "<option value='$c'><br/>";
                                };

                            echo ' </datalist>';
?> <input type="Submit" value="Search" class="login-btn btn-primary btn" style="padding-left: 25px;padding-right: 25px;padding-top: 10px;padding-bottom: 10px;">
                    </form>
                </td>
                <td width="15%">
                    <p style="font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;text-align: right;"> Today's Date </p>
                    <p class="heading-sub12" style="padding: 0;margin: 0;"> <?php 
                        date_default_timezone_set('Asia/Kolkata');

                        $date = date('Y-m-d');
                        echo $date;
                        ?> </p>
                </td>
                <td width="10%">
                    <button class="btn-label" style="display: flex;justify-content: center;align-items: center;"><img src="../img/calendar.svg" width="100%"></button>
                </td>
            </tr>
            <tr>
                <td colspan="4" style="padding-top:10px;">
                    <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49)">Invoice</p>
                </td>
            </tr> <?php
                    if($_POST){
                        $keyword=$_POST["search"];
                        
                        $sqlmain= "select * from patient where pemail='$keyword' or pname='$keyword' or pname like '$keyword%' or pname like '%$keyword' or pname like '%$keyword%' ";
                    }else{
                        $sqlmain= "select * from patient order by pid desc";

                    }



                ?> <tr>
                <td colspan="4">
                    <center>
                        <div class="abc scroll">
                            <table width="93%" class="sub-table scrolldown" style="border-spacing:0;">
                                <tbody>
                                    <tr>
                                        <td style='width: 25%;'>
                                            <div class='dashboard-items search-items'>
                                                <div style='width:100%;'>
                                                        <?php
                                                        $pid = $_GET['pid'];

                                                        $sql = $database->prepare("SELECT * FROM patient WHERE pid = ?");
                                                        $sql->bind_param("i", $pid);
                                                        $sql->execute();
                                                        $result = $sql->get_result();

                                                        while ($row = $result->fetch_assoc()) {
                                                            $pemail = $row['pemail'];
                                                            $pname = $row['pname'];
                                                            $paddress = $row['paddress'];
                                                            $pnic = $row['pnic'];
                                                            $pdob = $row['pdob'];
                                                            $ptel = $row['ptel'];

                                                            echo 
                                                            "
                                                            <div class='h3-search'>
                                                                Date: ".date("Y-m-d")."
                                                            </div>

                                                            <div class='h3-search'>
                                                                Patient name: ".$pname."
                                                            </div>

                                                            <div class='h3-search'>
                                                                Email: ".$pemail."
                                                            </div>

                                                            <div class='h3-search'>
                                                                Telephone #".$ptel."
                                                            </div>

                                                            <div class='h3-search'>
                                                                Address: ".$paddress."
                                                            </div>

                                                            <div class='h3-search'>
                                                                NIC: ".$pnic."
                                                            </div>

                                                            <div class='h3-search'>
                                                                DOB: ".$pdob."
                                                            </div>
                                                            <br>
                                                            <div class='h3-search'>
                                                                Appointments:
                                                            </div>
                                                            
                                                            ";


                                                            $sql2 = $database->prepare("SELECT s.title AS schedule_title, s.schedule_fee, d.docname AS doctor_name
                                                                FROM appointment a
                                                                JOIN schedule s ON a.scheduleid = s.scheduleid
                                                                JOIN doctor d ON s.docid = d.docid
                                                                JOIN patient p ON a.pid = p.pid
                                                                WHERE p.pid = ?;
                                                                ");
                                                            $sql2->bind_param("i", $pid);
                                                            $sql2->execute();
                                                            $result2 = $sql2->get_result();
                                                            $totalfee = 0;

                                                            echo
                                                            "
                                                            <table border='1' style='border-collapse: collapse; width: 100%; text-align: left;'>
                                                                <thead style='background-color: #f2f2f2;'>
                                                                    <tr>
                                                                        <th style='padding: 10px; color: black;'>Title</th>
                                                                        <th style='padding: 10px; color: black;'>Doctor Name</th>
                                                                        <th style='padding: 10px; color: black;'>Fee</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>";
                                                                while ($row2 = $result2->fetch_assoc()) {
                                                                    $schedule_title = $row2['schedule_title'];
                                                                    $schedule_fee = $row2['schedule_fee'];
                                                                    $doctor_name = $row2['doctor_name'];
                                                                    $totalfee += $schedule_fee;
                                                                    echo "
                                                                    <tr>
                                                                        <td style='padding: 10px; color: black;'>{$schedule_title}</td>
                                                                        <td style='padding: 10px; color: black;'>{$doctor_name}</td>
                                                                        <td style='padding: 10px; color: black;'>P{$schedule_fee}</td>
                                                                    </tr>";
                                                                }
                                                                echo "
                                                                <tr>
                                                                    <td colspan='2' style='padding: 10px; color: black; text-align: right;'><b>Total</b></td>
                                                                    <td style='padding: 10px; color: black;'><b>P{$totalfee}</b></td>

                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                            ";                                           
                                                        }

                                                        ?>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </center>
                </td>
            </tr>
        </table>
    </div>
    </div> 
</div>
    
</body>

</html>