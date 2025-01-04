<?php
session_start(); // Start the session

// Destroy all session data
session_unset(); // Unset all session variables
session_destroy(); // Destroy the session

// Redirect to the login page
header("Location: /InternLink/Frontend/Login/Sub_Logins/candidate_login.html"); 
exit;
?>
