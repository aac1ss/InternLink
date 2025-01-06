<?php
session_start();
include '../dbconfig.php';

// Redirect if not logged in
if (!isset($_SESSION['email'])) {
    header("Location: ../../Frontend/Login/Sub_Logins/candidate_login.html");
    exit;
}

// Check if all required parameters are passed via URL
if (
    !isset($_GET['internship_id']) ||
    !isset($_GET['internship_title']) ||
    !isset($_GET['created_at']) ||
    !isset($_GET['company_name'])
) {
    die("Missing required parameters. Please try again.");
}

// Sanitize and assign URL parameters
$internship_id = mysqli_real_escape_string($conn, $_GET['internship_id']);
$internship_title = mysqli_real_escape_string($conn, $_GET['internship_title']);
$created_at = mysqli_real_escape_string($conn, $_GET['created_at']);
$company_name = mysqli_real_escape_string($conn, $_GET['company_name']);

// Retrieve the candidate's ID from the session
$email = $_SESSION['email'];
$query = "SELECT c_id FROM candidate_profiles WHERE email = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$candidate = mysqli_fetch_assoc($result);

if (!$candidate) {
    die("Candidate details not found. Please update your profile and try again.");
}

$c_id = $candidate['c_id'];

// Check if the candidate has already applied to this internship
$check_query = "SELECT * FROM internship_applications WHERE internship_id = ? AND c_id = ?";
$stmt_check = mysqli_prepare($conn, $check_query);
mysqli_stmt_bind_param($stmt_check, "ii", $internship_id, $c_id);
mysqli_stmt_execute($stmt_check);
$result_check = mysqli_stmt_get_result($stmt_check);

if (mysqli_num_rows($result_check) > 0) {
    echo "<script>
        alert('You have already applied to this internship.');
        window.location.href='../../Frontend/Internships/internships_dashboard.php';
    </script>";
    exit;
}

// Insert application into the database
$apply_query = "INSERT INTO internship_applications (internship_id, c_id, internship_title, created_at, company_name, application_date) 
                VALUES (?, ?, ?, ?, ?, NOW())";
$stmt_apply = mysqli_prepare($conn, $apply_query);
mysqli_stmt_bind_param($stmt_apply, "iisss", $internship_id, $c_id, $internship_title, $created_at, $company_name);

if (mysqli_stmt_execute($stmt_apply)) {
    echo "<script>
        alert('Application submitted successfully!');
        window.location.href='../../Frontend/DashBoard/Candidate/candidate_dashboard.php';
    </script>";
} else {
    echo "<script>
        alert('Failed to submit application. Please try again later.');
        window.location.href='../../Frontend/Internships_Dashboard/internships_dashboard.php';
    </script>";
}

// Close database connection
if ($conn) mysqli_close($conn);
?>


