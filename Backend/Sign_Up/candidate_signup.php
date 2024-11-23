<?php
// candidate_signup.php

include '../dbconfig.php'; 

session_start();

$message = "";

// Handles form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $username = $_POST['user_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];

    // Validate password match
    if ($password !== $confirm_password) {
        $message = "Error: Passwords do not match.";
    } else {
       
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $checkEmailSql = "SELECT * FROM candidates_signup WHERE c_email = ?";
        $checkStmt = mysqli_prepare($conn, $checkEmailSql);
        
        if ($checkStmt) {
            mysqli_stmt_bind_param($checkStmt, 's', $email);
            mysqli_stmt_execute($checkStmt);
            mysqli_stmt_store_result($checkStmt);

            if (mysqli_stmt_num_rows($checkStmt) > 0) {
                $message = "Error: This email address is already registered.";
            } else {
                // Prepare SQL statement to prevent SQL injection
                $sql = "INSERT INTO candidates_signup (c_username, c_email, c_password) VALUES (?, ?, ?)";
                $stmt = mysqli_prepare($conn, $sql);
                
                if ($stmt) {
                    mysqli_stmt_bind_param($stmt, 'sss', $username, $email, $hashed_password);
                    if (mysqli_stmt_execute($stmt)) {
                        $message = "Account created successfully!";
                    } else {
                        $message = "Error: " . mysqli_error($conn);
                    }
                    mysqli_stmt_close($stmt);
                } else {
                    $message = "Error preparing statement: " . mysqli_error($conn);
                }
            }

            // Close check statement
            mysqli_stmt_close($checkStmt);
        } else {
            $message = "Error preparing check statement: " . mysqli_error($conn);
        }
    }
}

// Close database connection after processing
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InternLink - Candidate Signup Result</title>
</head>
<body>
    <h2>Signup Result</h2>

    <?php if (!empty($message)): ?>
        <p><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <a href="candidateSignup.html">Back to Signup</a>
</body>
</html>
