<?php
// admin_login_form.php

// Include the database connection
include('../dbconfig.php');

// Start session to store error message
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the email and password from POST request
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query to check if the email exists
    $sql = "SELECT * FROM admin_signup WHERE admin_email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch the result
        $row = $result->fetch_assoc();

        // Direct password comparison since password is plain text
        if ($password === $row['admin_password']) {
            // Credentials are correct, redirect to the admin dashboard
            $_SESSION['admin_email'] = $email;
            header('Location: ../../Frontend/DashBoard/ADMINN/admin_dashboard.htm');
            exit();
        } else {
            // Invalid password, set an error message
            $_SESSION['error_message'] = "Invalid email or password.";
            header('Location: ../../Frontend/Login/Sub_Logins/admin_login_form.php');
            exit();
        }
    } else {
        // Invalid email, set an error message
        $_SESSION['error_message'] = "Invalid email or password.";
        header('Location: admin_login_form.php');
        exit();
    }
}
?>
