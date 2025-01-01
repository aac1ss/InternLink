<?php
session_start();

// Include database connection
include '../dbconfig.php';
echo "Debug: Received internship_id: " . $internship_id;
// Check if the user is logged in and internship_id is provided
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['internship_id']) && !empty($_POST['internship_id'])) {
        $internship_id = intval($_POST['internship_id']); // Sanitize input
    } else {
        die("Internship ID is missing or invalid.");
    }
} else {
    die("Invalid request method.");
}

// Get candidate's email and internship ID
$email = $_SESSION['email'];
$internship_id = intval($_POST['internship_id']);

// Fetch candidate ID (c_id) from the database
$query = "SELECT c_id FROM candidate_profiles WHERE email = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$candidate = mysqli_fetch_assoc($result);

if (!$candidate) {
    echo "Candidate profile not found.";
    exit;
}

$c_id = $candidate['c_id'];

// Verify if the internship_id exists
$verify_internship_query = "SELECT internship_id FROM post_internship_form_detail WHERE internship_id = ?";
$stmt = mysqli_prepare($conn, $verify_internship_query);
mysqli_stmt_bind_param($stmt, "i", $internship_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) === 0) {
    echo "Invalid internship ID. Please try again.";
    exit;
}

// Check if the candidate has already applied
$check_query = "SELECT * FROM applications WHERE c_id = ? AND internship_id = ?";
$stmt = mysqli_prepare($conn, $check_query);
mysqli_stmt_bind_param($stmt, "ii", $c_id, $internship_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    echo "You have already applied for this internship.";
    exit;
}

// Insert the application
$insert_query = "INSERT INTO applications (c_id, internship_id) VALUES (?, ?)";
$stmt = mysqli_prepare($conn, $insert_query);
mysqli_stmt_bind_param($stmt, "ii", $c_id, $internship_id);

if (mysqli_stmt_execute($stmt)) {
    echo "Applied successfully!";
} else {
    echo "Failed to apply. Please try again.";
}

// Close connection
mysqli_close($conn);
?>
