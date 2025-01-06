<?php
// Include your database connection file
include('../dbconfig.php');

// Get the application ID from the URL parameter
if (isset($_GET['application_id']) && !empty($_GET['application_id'])) {
    $applicationId = $_GET['application_id'];

    // Query to retract (delete) the application from the database
    $query = "DELETE FROM internship_applications WHERE application_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $applicationId); // "i" stands for integer
    $result = $stmt->execute();

    if ($result) {
        // Redirect back to the same page with a success message
        header("Location: ../../Frontend/DashBoard/Candidate/candidate_dashboard.php?message=Application retracted successfully.");
        exit();
    } else {
        // Redirect back with an error message
        header("Location: ../../Frontend/DashBoard/Candidate/candidate_dashboard.php?error=Failed to retract the application.");
        exit();
    }
} else {
    // If no application ID is provided, redirect back with an error message
    header("Location: ../../Frontend/DashBoard/Candidate/candidate_dashboard.php?error=Application ID is missing.");
    exit();
}
?>
