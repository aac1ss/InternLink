<?php
session_start();
include '../../Backend/dbconfig.php';

// Check if required internship details are passed
if (isset($_POST['internship_id']) && isset($_POST['internship_title']) && isset($_POST['created_at']) && isset($_POST['company_name'])) {
    $internship_id = $_POST['internship_id'];
    $internship_title = $_POST['internship_title'];
    $created_at = $_POST['created_at'];
    $company_name = $_POST['company_name'];

    // Ensure session is active and c_id is set
    if (isset($_SESSION['c_id'])) {
        $c_id = $_SESSION['c_id'];
    } else {
        echo "Session error: Candidate ID (c_id) is not set.<br>";
        exit;
    }

    // Query to validate internship existence
    $query = "SELECT internship_id FROM post_internship_form_detail WHERE internship_id = ? AND company_name = ?";
    if ($stmt = mysqli_prepare($conn, $query)) {
        mysqli_stmt_bind_param($stmt, 'is', $internship_id, $company_name); // 'i' for integer, 's' for string
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        // Check if the internship exists
        if (mysqli_stmt_num_rows($stmt) > 0) {
            echo "Internship ID: " . $internship_id . "<br>";
            echo "Company Name: " . $company_name . "<br>";

            // Insert the application
            $application_query = "INSERT INTO internship_applications (c_id, internship_id, status, applied_at) VALUES (?, ?, 'Pending', NOW())";
            if ($stmt_application = mysqli_prepare($conn, $application_query)) {
                mysqli_stmt_bind_param($stmt_application, 'ii', $c_id, $internship_id);
                if (mysqli_stmt_execute($stmt_application)) {
                    echo "Application submitted successfully!";
                } else {
                    echo "Error: Failed to submit the application.";
                }
                mysqli_stmt_close($stmt_application);
            } else {
                echo "Error: Unable to prepare the application query.";
            }
        } else {
            echo "Error: The internship you're trying to apply for does not exist.";
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Error: Unable to prepare the internship validation query.";
    }
} else {
    echo "Error: Internship details are not fully provided.";
}
?>
