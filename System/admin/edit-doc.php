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
    header("location: doctors.php?action=edit&error=2&id=$id");
    exit();
}

// Check if the email is already associated with another doctor
$stmt_check_email = $database->prepare("SELECT docid FROM doctor WHERE docemail = ?");
$stmt_check_email->bind_param("s", $email);
$stmt_check_email->execute();
$result = $stmt_check_email->get_result();
$id2 = ($result->num_rows == 1) ? $result->fetch_assoc()["docid"] : $id;
$stmt_check_email->close();

if ($id2 != $id) {
    // Email is already associated with another doctor
    header("location: doctors.php?action=edit&error=1&id=$id");
    exit();
}

// Update doctor and webuser information using prepared statements
$stmt_update_doctor = $database->prepare("UPDATE doctor SET docemail=?, docpassword=? WHERE docid=?");
$stmt_update_doctor->bind_param("ssi", $email, $password, $id);
$stmt_update_doctor->execute();
$stmt_update_doctor->close();

$stmt_update_webuser = $database->prepare("UPDATE webuser SET email=? WHERE email=?");
$stmt_update_webuser->bind_param("ss", $email, $oldemail);
$stmt_update_webuser->execute();
$stmt_update_webuser->close();

// Redirect with success message
header("location: doctors.php?action=edit&error=4&id=$id");
exit();

?>
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
    header("location: doctors.php?action=edit&error=2&id=$id");
    exit();
}

// Check if the email is already associated with another doctor
$stmt_check_email = $database->prepare("SELECT docid FROM doctor WHERE docemail = ?");
$stmt_check_email->bind_param("s", $email);
$stmt_check_email->execute();
$result = $stmt_check_email->get_result();
$id2 = ($result->num_rows == 1) ? $result->fetch_assoc()["docid"] : $id;
$stmt_check_email->close();

if ($id2 != $id) {
    // Email is already associated with another doctor
    header("location: doctors.php?action=edit&error=1&id=$id");
    exit();
}

// Update doctor and webuser information using prepared statements
$stmt_update_doctor = $database->prepare("UPDATE doctor SET docemail=?, docpassword=? WHERE docid=?");
$stmt_update_doctor->bind_param("ssi", $email, $password, $id);
$stmt_update_doctor->execute();
$stmt_update_doctor->close();

$stmt_update_webuser = $database->prepare("UPDATE webuser SET email=? WHERE email=?");
$stmt_update_webuser->bind_param("ss", $email, $oldemail);
$stmt_update_webuser->execute();
$stmt_update_webuser->close();

// Redirect with success message
header("location: doctors.php?action=edit&error=4&id=$id");
exit();

?>
