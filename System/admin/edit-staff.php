<?php

// Import database
include("../connection.php");

if (!$_POST) {
    // Redirect if no POST data is received
    header('location: signup.php');
    exit();
}

$oldemail = $_POST["oldemail"];
$email = $_POST['email'];
$password = $_POST['password'];
$cpassword = $_POST['cpassword'];
$id = $_POST['id00'];

if ($password !== $cpassword) {
    // Passwords do not match
    header("location: staffs.php?action=edit&error=2&id=$id");
    exit();
}

// hash the password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Check if the email is already associated with another staff
$stmt_check_email = $database->prepare("SELECT staff_id FROM staff WHERE staff_email = ?");
$stmt_check_email->bind_param("s", $email);
$stmt_check_email->execute();
$result = $stmt_check_email->get_result();
$id2 = ($result->num_rows == 1) ? $result->fetch_assoc()["staff_id"] : $id;
$stmt_check_email->close();

if ($id2 != $id) {
    // Email is already associated with another staff
    header("location: staffs.php?action=edit&error=1&id=$id");
    exit();
}

// Update staff and webuser information using prepared statements
$stmt_update_staff = $database->prepare("UPDATE staff SET staff_email=?, staff_password=? WHERE staff_id=?");
$stmt_update_staff->bind_param("ssi", $email, $hashed_password, $id);
$stmt_update_staff->execute();
$stmt_update_staff->close();

$stmt_update_webuser = $database->prepare("UPDATE webuser SET email=? WHERE email=?");
$stmt_update_webuser->bind_param("ss", $email, $oldemail);
$stmt_update_webuser->execute();
$stmt_update_webuser->close();

// Redirect with success message
header("location: staffs.php?action=edit&error=4&id=$id");
exit();