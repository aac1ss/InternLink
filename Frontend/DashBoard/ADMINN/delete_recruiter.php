<?php
include('../../../Backend/dbconfig.php');

if (isset($_GET['r_id'])) {
    $r_id = $_GET['r_id'];

    // Ensure that the ID is numeric to prevent SQL injection
    if (is_numeric($r_id)) {
        $sql = "DELETE FROM company_profile WHERE r_id = $r_id";

        if ($conn->query($sql) === TRUE) {
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
