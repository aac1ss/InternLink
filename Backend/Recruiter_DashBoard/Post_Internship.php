<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include your database configuration file
include '../dbconfig.php';

// Start session only if it hasn't been started yet
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if r_id is set in the session
if (!isset($_SESSION['r_id'])) {
    die("Error: Recruiter not logged in.");
}

$r_id = $_SESSION['r_id'];  // Get recruiter ID from session

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Initialize variables with default values to avoid undefined index warnings
    $internship_title = mysqli_real_escape_string($conn, $_POST['internship_title'] ?? '');
    $company_name = mysqli_real_escape_string($conn, $_POST['company_name'] ?? '');
    $location = mysqli_real_escape_string($conn, $_POST['location'] ?? '');
    $duration = mysqli_real_escape_string($conn, $_POST['duration'] ?? '');
    $type = mysqli_real_escape_string($conn, $_POST['type'] ?? 'remote');  // Default to 'remote'
    $stipend_amount = mysqli_real_escape_string($conn, $_POST['stipend_amount'] ?? ''); // Optional stipend amount
    $job_description = mysqli_real_escape_string($conn, $_POST['job_description'] ?? '');
    $responsibility = mysqli_real_escape_string($conn, $_POST['responsibility'] ?? '');
    $requirements = mysqli_real_escape_string($conn, $_POST['requirements'] ?? '');
    $skills = mysqli_real_escape_string($conn, $_POST['skills'] ?? '');
    $perks = mysqli_real_escape_string($conn, $_POST['perks'] ?? '');
    $additional_info = mysqli_real_escape_string($conn, $_POST['additional_info'] ?? '');
    
    // Get current date for created_at
    $created_at = date('Y-m-d H:i:s');

    // Calculate the deadline (1 month after created_at)
    $deadline = date('Y-m-d', strtotime("+1 month", strtotime($created_at)));

    // Set default status (e.g., 'active')
    $status = 'active';

    // Prepare the SQL query to insert data into the database
    $sql = "INSERT INTO post_internship_form_detail 
        (r_id, internship_title, company_name, location, duration, type, stipend_amount, job_description, responsibility, requirements, skills, perks, created_at, deadline, additional_info) 
        VALUES 
        ('$r_id', '$internship_title', '$company_name', '$location', '$duration', '$type', '$stipend_amount', '$job_description', '$responsibility', '$requirements', '$skills', '$perks', '$created_at', '$deadline', '$additional_info')";

    // Output SQL query for debugging
    // echo "<pre>$sql</pre>"; // Show the SQL query

    // Execute the query and check for errors
    if (mysqli_query($conn, $sql)) {
        echo "New internship posted successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Close connection
mysqli_close($conn);
?>
