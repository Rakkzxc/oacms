<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/animations.css">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/admin.css">
    <title>Payment</title>
</head>

<body> <?php
//learn from w3schools.com

session_start();

// Check if the user session is set and has the correct user type, otherwise redirect to the login page
if (!isset($_SESSION["user"]) || $_SESSION["user"] == "" || $_SESSION["usertype"] !== "a") {
    header("location: ../login.php");
    exit(); // Terminate script execution after redirection
}


//import database
include "../connection.php";
?> 
    
    <div class="container">
        <div class="menu">
            <table class="menu-container" border="0">
                <tr>
                    <td style="padding:10px" colspan="2">
                        <table border="0" class="profile-container">
                            <tr>
                                <td width="30%" style="padding-left:20px">
                                    <img src="../img/user.png" alt="" width="100%" style="border-radius:50%">
                                </td>
                                <td style="padding:0px;margin:0px;">
                                    <p class="profile-title">Administrator</p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <a href="../logout.php"><input type="button" value="Log out" class="logout-btn btn-primary-soft btn"></a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-dashbord">
                        <a href="index.php" class="non-style-link-menu">
                            <div>
                                <p class="menu-text">Dashboard</p>
                            </div>
                        </a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-doctor ">
                        <a href="doctors.php" class="non-style-link-menu ">
                            <div>
                                <p class="menu-text">Doctors</p>
                            </div>
                        </a>
                    </td>
                </tr>
    <tr class="menu-row">
        <td class="menu-btn menu-icon-schedule">
            <a href="schedule.php" class="non-style-link-menu">
                <div>
                    <p class="menu-text">Schedule</p>
                </div>
            </a>
        </td>
    </tr>
    <tr class="menu-row">
        <td class="menu-btn menu-icon-appoinment">
            <a href="appointment.php" class="non-style-link-menu">
                <div>
                    <p class="menu-text">Appointment</p>
            </a></div>
        </td>
    </tr>
    <tr class="menu-row">
        <td class="menu-btn menu-icon-patient">
            <a href="patient.php" class="non-style-link-menu">
                <div>
                    <p class="menu-text">Patients</p>
            </a></div>
        </td>
    </tr>
    <tr class="menu-row">
        <td class="menu-btn menu-icon-schedule  menu-active menu-icon-schedule-active-active">
            <a href="payment.php" class="non-style-link-menu  non-style-link-menu-active">
                <div>
                    <p class="menu-text">Payments</p>
            </a></div>
        </td>
    </tr>
    </table>
    </div>
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
                        $list11 = $database->query(
                            "select  pname,pemail from patient;"
                        );

                        for ($y = 0; $y < $list11->num_rows; $y++) {
                            $row00 = $list11->fetch_assoc();
                            $d = $row00["pname"];
                            $c = $row00["pemail"];
                            echo "<option value='$d'><br/>";
                            echo "<option value='$c'><br/>";
                        }

                        echo " </datalist>";
                        ?> <input type="Submit" value="Search" class="login-btn btn-primary btn" style="padding-left: 25px;padding-right: 25px;padding-top: 10px;padding-bottom: 10px;">
                    </form>
                </td>
                <td width="15%">
                    <p style="font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;text-align: right;"> Today's Date </p>
                    <p class="heading-sub12" style="padding: 0;margin: 0;"> <?php
                    date_default_timezone_set("Asia/Kolkata");

                    $date = date("Y-m-d");
                    echo $date;
                    ?> </p>
                </td>
                <td width="10%">
                    <button class="btn-label" style="display: flex;justify-content: center;align-items: center;"><img src="../img/calendar.svg" width="100%"></button>
                </td>
            </tr>
            <tr>
                <td colspan="4" style="padding-top:10px;">
                    <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49)">All Patients (<?php echo $list11->num_rows; ?>) &nbsp <button id="export-btn" class="btn-primary-soft btn" onclick="exportToExcel()" style="padding: 15px; margin :0;width:10%">Export</button></p>
                </td>
            </tr> <?php if ($_POST) {
                $keyword = $_POST["search"];

                $sqlmain =
                    "select * from patient where pemail='$keyword' or pname='$keyword' or pname like '$keyword%' or pname like '%$keyword' or pname like '%$keyword%' ";
            } else {
                $sqlmain = "SELECT
                                p.pname AS patient_name,
                                s.scheduledate AS schedule_date,
                                s.schedule_fee AS schedule_fee,
                                s.title AS schedule_title
                            FROM
                                patient p
                            JOIN appointment a ON
                                p.pid = a.pid
                            JOIN SCHEDULE s ON
                                a.scheduleid = s.scheduleid";
            } ?> 
            <tr>
                <td colspan="4">
                    <center>
                        <div class="abc scroll">
                            <table width="93%" class="sub-table scrolldown" style="border-spacing:0;">
                                <thead>
                                    <tr>
                                        <th class="table-headin"> Name </th>
                                        <th class="table-headin"> Session </th>
                                        <th class="table-headin"> Date </th>
                                        <th class="table-headin"> Payment </th>
                                    </tr>
                                </thead>
                                <tbody> 

                                <?php
                                $result = $database->query($sqlmain);

                                for ($x = 0; $x < $result->num_rows; $x++) {
                                        $row = $result->fetch_assoc();
                                        $patient_name = $row["patient_name"];
                                        $scheduledate = $row["schedule_date"];
                                        $schedule_fee = $row["schedule_fee"];
                                        $schedule_title = $row["schedule_title"];

                                        echo '
                                        <tr>
                                            <td style="padding: 10px 0;">&nbsp;'.$patient_name.'</td>
                                            <td style="padding: 10px 0;">'.$schedule_title.'</td>
                                            <td style="padding: 10px 0;">'.$scheduledate.'</td>
                                            <td style="padding: 10px 0;">'.$schedule_fee.'</td>
                                        </tr>
                                    </div>
                                    ';
                                    }
                                ?> 
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
<script>
    function exportToExcel() {
    const table = document.querySelector('.sub-table');
    const rows = table.querySelectorAll('tr');
    let excelData = '';

    for (let i = 0; i < rows.length; i++) {
        const cells = rows[i].querySelectorAll('td, th');
        for (let j = 0; j < cells.length; j++) {
            let cellData = cells[j].innerText.trim();
            cellData = cellData.replace(/"/g, '""'); // Escape double quotes
            excelData += '"' + cellData + '"\t';
        }
        excelData += '\n';
    }

    const blob = new Blob([excelData], { type: 'application/vnd.ms-excel' });
    const fileName = 'payment_data.xls';

    if (navigator.msSaveBlob) {
        navigator.msSaveBlob(blob, fileName);
    } else {
        const link = document.createElement('a');
        if (link.download !== undefined) {
            const url = URL.createObjectURL(blob);
            link.setAttribute('href', url);
            link.setAttribute('download', fileName);
            link.style.visibility = 'hidden';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    }
}


</script>

</html>