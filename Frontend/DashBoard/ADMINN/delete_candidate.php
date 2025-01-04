<?php
include('../../../Backend/dbconfig.php');

if (isset($_GET['c_id'])) {
    $c_id = $_GET['c_id'];

    // Ensure that the ID is numeric to prevent SQL injection
    if (is_numeric($c_id)) {
        $sql = "DELETE FROM candidate_profiles WHERE c_id = $c_id";

        if ($conn->query($sql) === TRUE) {
            echo "Candidate successfully deleted.";
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Invalid candidate ID.";
    }

    $conn->close();
}
?>
