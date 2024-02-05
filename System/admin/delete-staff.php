<?php

   if ($_GET) {
    // Import database
    include("../connection.php");
    
    // Sanitize input to prevent SQL injection
    $id = mysqli_real_escape_string($database, $_GET["staff_id"]);
    
    // Fetch staff email using prepared statement
    $stmt = $database->prepare("SELECT staff_email FROM staff WHERE staff_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $email = $result->fetch_assoc()["staff_email"];
        
        // Use prepared statements to prevent SQL injection
        $stmt_delete_webuser = $database->prepare("DELETE FROM webuser WHERE email = ?");
        $stmt_delete_webuser->bind_param("s", $email);
        $stmt_delete_webuser->execute();
        
        $stmt_delete_staff = $database->prepare("DELETE FROM staff WHERE staff_email = ?");
        $stmt_delete_staff->bind_param("s", $email);
        $stmt_delete_staff->execute();
        
        // Redirect after successful deletion
        header("location: staffs.php");
    } else {
        // Handle the case where no staff with the specified ID is found
        echo "Staff not found.";
    }

    // Close the prepared statements
    $stmt_delete_webuser->close();
    $stmt_delete_staff->close();
    
    // Close the database connection
    $database->close();
}


?>