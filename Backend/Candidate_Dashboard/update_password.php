<?php
// Start the session
session_start();

// Include database connection
include('../../../Backend/dbconfig.php');

// Check if the candidate is logged in
if (!isset($_SESSION['c_id'])) {
    echo "Unauthorized access!";
    exit;
}

// Get the candidate ID from the session
$candidate_id = $_SESSION['c_id'];

// Get the new password and confirm password from the form
$new_password = $_POST['new_password'];
$confirm_password = $_POST['confirm_password'];

// Validate the passwords
if ($new_password !== $confirm_password) {
    echo "Passwords do not match!";
    exit;
}

// Hash the new password
$hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

// Update the password in the database
$query = "UPDATE candidates_signup SET c_password = ? WHERE c_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('si', $hashed_password, $candidate_id);

if ($stmt->execute()) {
    echo "Password updated successfully!";
} else {
    echo "Error updating password: " . $conn->error;
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>