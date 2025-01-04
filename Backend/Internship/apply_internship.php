<?php
session_start();
include '../../Backend/dbconfig.php';

// Check if internship details are passed
if (isset($_POST['internship_title']) && isset($_POST['created_at']) && isset($_POST['company_name'])) {
    $internship_title = $_POST['internship_title'];
    $created_at = $_POST['created_at'];
    $company_name = $_POST['company_name'];

    // Ensure session is active and c_id is set
    if (isset($_SESSION['c_id'])) {
        $c_id = $_SESSION['c_id'];
    } else {
        echo "Session error: c_id is not set.<br>";
        exit;
    }

    // Query to get the internship_id based on internship title, company name, and created_at
    $query = "SELECT internship_id FROM post_internship_form_detail WHERE internship_title = ? AND company_name = ? AND created_at = ?";
    
    if ($stmt = mysqli_prepare($conn, $query)) {
        mysqli_stmt_bind_param($stmt, 'sss', $internship_title, $company_name, $created_at);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        
        // Check if internship is found
        if (mysqli_stmt_num_rows($stmt) > 0) {
            mysqli_stmt_bind_result($stmt, $internship_id);
            mysqli_stmt_fetch($stmt);

echo "Internship Title: " . $internship_title . "<br>";
echo "Company Name: " . $company_name . "<br>";
echo "Created At: " . $created_at . "<br>";


            // Proceed with the application
            $application_query = "INSERT INTO internship_applications (c_id, internship_id, status) VALUES (?, ?, 'Pending')";
            if ($stmt_application = mysqli_prepare($conn, $application_query)) {
                mysqli_stmt_bind_param($stmt_application, 'ii', $c_id, $internship_id);
                if (mysqli_stmt_execute($stmt_application)) {
                    echo "Application submitted successfully!";
                } else {
                    echo "Error applying for internship.";
                }
                mysqli_stmt_close($stmt_application);
            } else {
                echo "Error: Unable to prepare application query.";
            }
        } else {
            echo "Error: The internship you're trying to apply for no longer exists.";
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Error: Unable to prepare internship query.";
    }
} else {
    echo "Error: Internship details are not provided.";
}
?>
