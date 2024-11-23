<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include '../dbconfig.php';

session_start();

// Retrieve form data
$internship_title = $_POST['internship_title'];
$company_name = $_POST['company_name'];
$location = $_POST['location'];
$duration = $_POST['duration'];
$type = $_POST['type'];
$stipend_amount = isset($_POST['stipend_amount']) ? $_POST['stipend_amount'] : null; // Handle optional stipend amount
$job_description = $_POST['job_description'];
$responsibility = $_POST['responsibility'];
$requirements = $_POST['requirements'];
$skills = $_POST['skills'];
$perks = $_POST['perks'];
$additional_info = $_POST['additional_info'];

// Insert data into the database
$sql = "INSERT INTO post_internship_form_detail (internship_title, company_name, location, duration, type, stipend_amount, job_description, responsibility, requirements, skills, perks, additional_info) 
VALUES ('$internship_title', '$company_name', '$location', '$duration', '$type', '$stipend_amount', '$job_description', '$responsibility', '$requirements', '$skills', '$perks', '$additional_info')";

if (mysqli_query($conn, $sql)) {
    echo "New internship posted successfully!";
} else {
    echo "Error: " . mysqli_error($conn);
}

// Close connection
mysqli_close($conn);
?>