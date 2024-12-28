<?php
include '../dbconfig.php';
session_start();

// Ensure recruiter email is set in the session
if (!isset($_SESSION['email'])) {
    echo json_encode(["error" => "Recruiter email is not set in the session."]);
    exit;
}

$recruiter_email = $_SESSION['email'];

// SQL query to get internship details and applications count
$sql = "SELECT p.internship_id, p.internship_title, p.company_name, p.location, p.created_at, p.deadline, 
               COUNT(a.application_id) AS application_count
        FROM post_internship_form_detail p
        LEFT JOIN applications a ON p.internship_id = a.internship_id
        WHERE p.recruiter_email = '$recruiter_email'
        GROUP BY p.internship_id";


$result = mysqli_query($conn, $sql);

// Check for errors
if (!$result) {
    echo json_encode(["error" => "Error fetching internships: " . mysqli_error($conn)]);
    exit;
}

// Fetch the result as an associative array
$internships = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Return the data as JSON
echo json_encode($internships);

// Close the connection
mysqli_close($conn);
?>
