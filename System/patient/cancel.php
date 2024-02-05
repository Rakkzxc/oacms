<?php
require_once("../connection.php");

$appoid = $_GET['appoid'];

$sqlmain= "DELETE FROM appointment WHERE appoid = ?";
$stmt = $database->prepare($sqlmain);
$stmt->bind_param("i",$appoid);
$stmt->execute();
$stmt->close();

header("location:appointment.php");


?>