<?php
include '../dbconfig.php';
session_start();

// Ensure recruiter email is set in the session
if (!isset($_SESSION['email'])) {
    echo json_encode(["error" => "Recruiter email is not set in the session."]);
    exit;
}

$recruiter_email = $_SESSION['email'];

// Retrieve internship ID from the request
$data = json_decode(file_get_contents("php://input"), true);
$internship_id = $data['internship_id'];

// Toggle the internship status (from 'On' to 'Off' or vice versa)
$sql = "UPDATE post_internship_form_detail 
        SET status = CASE WHEN status = 'On' THEN 'Off' ELSE 'On' END
        WHERE internship_id = $internship_id AND recruiter_email = '$recruiter_email'";

if (mysqli_query($conn, $sql)) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["error" => "Failed to update internship status: " . mysqli_error($conn)]);
}

mysqli_close($conn);
?>
