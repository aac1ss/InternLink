<?php
// candidate_login.php

include '../dbconfig.php'; 

session_start();

$message = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare SQL statement to prevent SQL injection
    $sql = "SELECT c_id, c_password FROM candidates_signup WHERE c_email = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 's', $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $c_id, $hashed_password);
        mysqli_stmt_fetch($stmt);

        if (password_verify($password, $hashed_password)) {
            // Store both c_id and email in the session
            $_SESSION['c_id'] = $c_id;
            $_SESSION['email'] = $email;

            // Redirect to the candidate dashboard
            header("Location: ../../Frontend/DashBoard/Candidate/candidate_dashboard.php");
            exit;
        } else {
            $message = "Error: Invalid email or password.";
        }

        mysqli_stmt_close($stmt);
    } else {
        $message = "Error preparing statement: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InternLink - Candidate Login Result</title>
</head>
<body>
    <h2>Login Result</h2>
    
    <?php if (!empty($message)): ?>
        <p><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <a href="candidate_login.html">Back to Login</a>
</body>
</html>
