<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include '../dbconfig.php';

session_start();

// Check if r_id is set in the session
if (!isset($_SESSION['r_id'])) {
    die("Error: Recruiter not logged in.");
}

$r_id = $_SESSION['r_id'];  // Get recruiter ID from session

// Retrieve form data
$internship_title = $_POST['internship_title'];
$company_name = $_POST['company_name'];
$location = $_POST['location'];
$duration = $_POST['duration'];
$type = $_POST['type'];
$stipend_amount = isset($_POST['stipend_amount']) ? $_POST['stipend_amount'] : null; // Handle optional stipend amount
$job_description = $_POST['job_description'];
$responsibility = $_POST['responsibility'];
$requirements = mysqli_real_escape_string($conn, $_POST['requirements']);
$skills = $_POST['skills'];
$perks = $_POST['perks'];
$additional_info = $_POST['additional_info'];

// Get current date for created_at
$created_at = date('Y-m-d H:i:s');

// Calculate the deadline (1 month after created_at)
$deadline = date('Y-m-d', strtotime("+1 month", strtotime($created_at)));

// Insert data into the post_internship_form_detail table with the recruiter ID
$sql = "INSERT INTO post_internship_form_detail (internship_title, company_name, location, duration, type, stipend_amount, job_description, responsibility, requirements, skills, perks, additional_info, created_at, deadline, status, r_id) 
VALUES ('$internship_title', '$company_name', '$location', '$duration', '$type', '$stipend_amount', '$job_description', '$responsibility', '$requirements', '$skills', '$perks', '$additional_info', '$created_at', '$deadline', 'on', '$r_id')";

if (mysqli_query($conn, $sql)) {
    echo "New internship posted successfully ";
} else {
    echo "Error: " . mysqli_error($conn);
}

// Close connection
mysqli_close($conn);
?>
