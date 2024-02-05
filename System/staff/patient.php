<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/animations.css">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/admin.css">
    <title>Patients</title>
    <style>

        /* Modal Styling */
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0,0,0,0.4);
    }

    .modal-content {
        background-color: #fefefe;
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        max-width: 600px;
        text-align: left; /* Align content to the left */
    }

    /* Close button */
    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }
    </style>
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
                    <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49)">All Patients (<?php echo $list11->num_rows; ?>) &nbsp <button id="export-btn" class="btn-primary-soft btn" onclick="exportToExcel()" style="padding: 15px; margin :0;width:10%">Export</button></p>

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
                                <thead>
                                    <tr>
                                        <th class="table-headin"> Name </th>
                                        <th class="table-headin"> Philhealth </th>
                                        <th class="table-headin"> Telephone </th>
                                        <th class="table-headin"> Email </th>
                                        <th class="table-headin"> Date of Birth </th>
                                        <th class="table-headin"> Events
                                    </tr>
                                </thead>
                                <tbody> <?php

                                
                                $result= $database->query($sqlmain);

                                if($result->num_rows==0){
                                    echo '<tr>
                                    <td colspan="4">
                                    <br><br><br><br>
                                    <center>
                                    <img src="../img/notfound.svg" width="25%">
                                    
                                    <br>
                                    <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">We  couldnt find anything related to your keywords !</p>
                                    <a class="non-style-link" href="patient.php"><button  class="login-btn btn-primary-soft btn"  style="display: flex;justify-content: center;align-items: center;margin-left:20px;">&nbsp; Show all Patients &nbsp;</font></button>
                                    </a>
                                    </center>
                                    <br><br><br><br>
                                    </td>
                                    </tr>';
                                    
                                }
                                else{
                                for ( $x=0; $x<$result->num_rows;$x++){
                                    $row=$result->fetch_assoc();
                                    $pid=$row["pid"];
                                    $name=$row["pname"];
                                    $email=$row["pemail"];
                                    $nic=$row["pnic"];
                                    $dob=$row["pdob"];
                                    $tel=$row["ptel"];
                                    
                                    echo '<tr>
                                        <td> &nbsp;'.
                                        substr($name,0,35)
                                        .'</td>
                                        <td>
                                        '.substr($nic,0,12).'
                                        </td>
                                        <td>
                                            '.substr($tel,0,10).'
                                        </td>
                                        <td>
                                        '.substr($email,0,20).'
                                         </td>
                                        <td>
                                        '.substr($dob,0,10).'
                                        </td>
                                        <td >
                                        <div style="display:flex;justify-content: center;">
                                        
                                        <button class="btn-primary-soft btn button-icon btn-view" style="padding-left: 40px; padding-top: 12px; padding-bottom: 12px; margin-top: 10px;" onclick="openModal(\'modal' . $pid . '\')">View</button>
                                        &nbsp
                                        <button class="btn-primary-soft btn" style=" padding-top: 12px; padding-bottom: 12px; margin-top: 10px;" onclick="createInvoiceAndRedirect(\''. $pid . '\')">Create invoice</button>

                                        </div>
                                        </td>
                                    </tr>

                                    <div id="modal' . $pid . '" class="modal" style="display: none;">
                                        <div class="modal-content">
                                            <span class="close" onclick="closeModal(\'modal' . $pid . '\')">&times;</span>
                                            <p>Details for Patient ' . $pid . '</p>
                                            <p>Name:'. $name.'</p>
                                            <p>Email:'. $email.'</p>
                                            <p>Philhealth:'. $nic.'</p>
                                            <p>Telephone:'. $tel.'</p>
                                            <p>dob:'. $dob.'</p>
                                        </div>
                                    </div>
                                    ';
                                    
                                }
                            }
                                 
                            ?> </tbody>
                            </table>
                        </div>
                    </center>
                </td>
            </tr>
        </table>
    </div>
    </div> 

   <script>
    // Function to open modal based on modal ID
    function openModal(modalID) {
        var modal = document.getElementById(modalID);
        if (modal) {
            modal.style.display = "block";
        }
    }

    // Function to close modal based on modal ID
    function closeModal(modalID) {
        var modal = document.getElementById(modalID);
        if (modal) {
            modal.style.display = "none";
        }
    }
    function createInvoiceAndRedirect(pid) {
        window.location.href = 'invoice.php?pid=' + pid;
    }
    </script>
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
    const fileName = 'patient_data.xls';

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


</div>
    
</body>

</html>