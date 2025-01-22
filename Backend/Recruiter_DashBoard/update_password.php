<?php
// Start the session
session_start();

// Include database connection
include('../../../Backend/dbconfig.php');

// Check if the recruiter is logged in
if (!isset($_SESSION['r_id'])) {
    echo "Unauthorized access!";
    exit;
}

// Get the recruiter ID from the session
$recruiter_id = $_SESSION['r_id'];

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
$query = "UPDATE recruiters_signup SET r_password = ? WHERE r_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('si', $hashed_password, $recruiter_id);

if ($stmt->execute()) {
    echo "Password updated successfully!";
} else {
    echo "Error updating password: " . $conn->error;
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>