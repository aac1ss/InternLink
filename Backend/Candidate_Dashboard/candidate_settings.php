<?php
session_start();
include '../dbconfig.php'; // Ensure database config is included

// Log the start of the process
error_log("Starting settings update process for user: " . $_SESSION['email']);

if (!isset($_SESSION['email'])) {
    error_log("No session found for email. User is not logged in.");
    echo "You must be logged in to change settings.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form input values
    $new_email = $_POST['email'];
    $new_password = $_POST['password'];
    $current_email = $_SESSION['email']; // Changed to $_SESSION['email']

    // Log the input values (be cautious with sensitive data)
    error_log("Received new email: " . $new_email);
    if (!empty($new_password)) {
        error_log("Received new password.");
    }

    // Validate the email format
    if (!filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
        error_log("Invalid email format: " . $new_email);
        $_SESSION['message'] = "Invalid email format!";
        $_SESSION['message_type'] = "error";
        header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    }

    // Hash the new password if provided
    if (!empty($new_password)) {
        $new_password = password_hash($new_password, PASSWORD_DEFAULT);
        error_log("Password hashed.");
    }

    // Prepare the SQL query to update the email and password
    $query = "UPDATE candidates_signup SET c_email = ?, c_password = ? WHERE c_email = ?";
    error_log("Prepared query: $query");

    // Prepare and execute the query
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("sss", $new_email, $new_password, $current_email);
        $stmt->execute();
        error_log("Query executed.");

        // Check if the update was successful
        if ($stmt->affected_rows > 0) {
            // Update session with the new email
            $_SESSION['email'] = $new_email; // Update session with the new email
            error_log("Email updated successfully in session.");

            // Set success message
            $_SESSION['message'] = "Settings updated successfully!";
            $_SESSION['message_type'] = "success"; // Type: success
        } else {
            // Set failure message
            $_SESSION['message'] = "No changes were made.";
            $_SESSION['message_type'] = "error"; // Type: error
        }

        $stmt->close();
    } else {
        error_log("Error preparing query.");
        $_SESSION['message'] = "Error preparing the query.";
        $_SESSION['message_type'] = "error"; // Type: error
    }

    // Redirect to the same page to display message
    error_log("Redirecting to display message.");
    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}
?>
