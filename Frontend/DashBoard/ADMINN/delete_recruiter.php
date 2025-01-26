<?php
include('../../../Backend/dbconfig.php');

if (isset($_GET['r_id'])) {
    $r_id = $_GET['r_id'];

    // Ensure that the ID is numeric to prevent SQL injection
    if (is_numeric($r_id)) {
        // Delete from company_profile table
        $sql1 = "DELETE FROM company_profile WHERE r_id = $r_id";
        // Delete from recruiters_signup table
        $sql2 = "DELETE FROM recruiters_signup WHERE r_id = $r_id";

        // Execute both queries
        if ($conn->query($sql1) === TRUE && $conn->query($sql2) === TRUE) {
            echo "Recruiter successfully deleted.";
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Invalid recruiter ID.";
    }

    $conn->close();
}
?>