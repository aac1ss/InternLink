<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../dbconfig.php';

if (!isset($_SESSION['email'])) {
    echo json_encode(["error" => "User not logged in."]);
    exit;
}

$email = $_SESSION['email'];
$query = "SELECT c_id FROM candidate_profiles WHERE email = ?";
$stmt = mysqli_prepare($conn, $query);
if (!$stmt) {
    echo json_encode(["error" => "Database error: " . mysqli_error($conn)]);
    exit;
}

mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$candidate = mysqli_fetch_assoc($result);

if (!$candidate) {
    echo json_encode(["error" => "Candidate profile not found."]);
    exit;
}

$c_id = $candidate['c_id'];

$sql = "SELECT ia.application_id,ia.internship_id, ia.company_name, ia.internship_title, ia.application_date, ia.status, 
               pfd.deadline, pfd.created_at 
        FROM internship_applications ia
        JOIN post_internship_form_detail pfd ON ia.internship_id = pfd.internship_id
        WHERE ia.c_id = ?";

$stmt = mysqli_prepare($conn, $sql);
if (!$stmt) {
    echo json_encode(["error" => "Database error: " . mysqli_error($conn)]);
    exit;
}

mysqli_stmt_bind_param($stmt, "i", $c_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$applications = [];
while ($row = mysqli_fetch_assoc($result)) {
    // Calculate the remaining days using the correct created_date
    $created_at = strtotime($row['created_at']); // From post_internship_form_detail
    $deadline = strtotime($row['deadline']);
    $remaining_days = ceil(($deadline - time()) / (60 * 60 * 24)); // Days from now to the deadline

    // Add the application data and remaining days to the response
    $row['remaining_days'] = $remaining_days;
    $applications[] = $row;
}

echo json_encode($applications);

if ($conn) mysqli_close($conn);
?>
