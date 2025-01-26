<?php
include('../../../Backend/dbconfig.php');

if (isset($_GET['c_id'])) {
    $c_id = $_GET['c_id'];

    // Ensure that the ID is numeric to prevent SQL injection
    if (is_numeric($c_id)) {
        // Delete from candidate_profiles table
        $sql1 = "DELETE FROM candidate_profiles WHERE c_id = $c_id";
        // Delete from candidates_signup table
        $sql2 = "DELETE FROM candidates_signup WHERE c_id = $c_id";
        // Delete from internship_applications table
        $sql3 = "DELETE FROM internship_applications WHERE c_id = $c_id";

        // Execute all queries
        if ($conn->query($sql1) === TRUE && $conn->query($sql2) === TRUE && $conn->query($sql3) === TRUE) {
            echo "Candidate successfully deleted .";
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Invalid candidate ID.";
    }

    $conn->close();
}
?>