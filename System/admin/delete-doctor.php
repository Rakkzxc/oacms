<?php

session_start();

if (isset($_SESSION["user"])) {
    if ($_SESSION["user"] == "" or $_SESSION['usertype'] != 'a') {
        header("location: ../login.php");
    }
} else {
    header("location: ../login.php");
}

if ($_GET) {
    // Import database
    include("../connection.php");

    // Sanitize input to prevent SQL injection
    $id = mysqli_real_escape_string($database, $_GET["id"]);

    // Fetch doctor email using prepared statement
    $stmt = $database->prepare("SELECT docemail FROM doctor WHERE docid = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $email = $result->fetch_assoc()["docemail"];

        // Use prepared statements to prevent SQL injection
        $stmt_delete_webuser = $database->prepare("DELETE FROM webuser WHERE email = ?");
        $stmt_delete_webuser->bind_param("s", $email);
        $stmt_delete_webuser->execute();

        $stmt_delete_doctor = $database->prepare("DELETE FROM doctor WHERE docemail = ?");
        $stmt_delete_doctor->bind_param("s", $email);
        $stmt_delete_doctor->execute();

        // Redirect after successful deletion
        header("location: doctors.php");
    } else {
        // Handle the case where no doctor with the specified ID is found
        echo "Doctor not found.";
    }

    // Close the prepared statements
    $stmt_delete_webuser->close();
    $stmt_delete_doctor->close();

    // Close the database connection
    $database->close();
}

?>
