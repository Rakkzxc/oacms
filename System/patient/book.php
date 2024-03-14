<?php

include("../connection.php");
date_default_timezone_set("Asia/Kolkata");
$today = date('Y-m-d H:i:s');



$sqlmain= "select * from schedule inner join doctor on schedule.docid=doctor.docid where schedule.scheduledate>='$today' AND schedule.nop != 0 order by schedule.scheduledate asc";
$stmt = $database->prepare($sqlmain);
$stmt->execute();
$result = $stmt->get_result();

$books = array();
$nopp = array();
$i = 0;
while ($row = $result->fetch_assoc()) {
	if (isset($_POST[$i])) {
		$schuduleidchecked = $_POST[$i];

		if ($schuduleidchecked == $row['scheduleid']) {
			array_push($books, $row['scheduleid']);
			array_push($nopp, $row['nop']);
		}
	}
	$i++;
}
$userid = $_POST['userid'];

$queryGetLastApponum = "SELECT MAX(apponum) FROM appointment";
$stmtGetLastApponum = $database->prepare($queryGetLastApponum);
$stmtGetLastApponum->execute();

$result = $stmtGetLastApponum->get_result();
$rowww = $result->fetch_assoc();
$lastApponum = $rowww['MAX(apponum)'];

for ($j = 0; $j < count($books); $j++) {
	echo $userid.$lastApponum.$books[$j].$today;
	$query = "UPDATE schedule SET nop = $nopp[$j] - 1 WHERE scheduleid = $books[$j]";
	$stmt = $database->prepare($query);
	$stmt->execute();

	$query = "INSERT INTO appointment(pid,apponum,scheduleid,appodate,app_status) VALUES ($userid,$lastApponum+1,$books[$j],'$today', 'Unapproved')";
	$stmt = $database->prepare($query);
	$stmt->execute();
}
$stmt->close();

header("location:../patient");

?>