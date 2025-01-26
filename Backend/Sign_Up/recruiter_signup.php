<?php
session_start();
include '../dbconfig.php';

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize inputs
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];

    // Validate email
    if (empty($email)) {
        $errors[] = "Company email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    // Validate password
    if (empty($password)) {
        $errors[] = "Password is required.";
    } elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $password)) {
        $errors[] = "Password must contain at least 8 characters with: 1 uppercase, 1 lowercase, 1 number, and 1 special character.";
    }

    // Validate password match
    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match.";
    }

    // Check for existing email
    if (empty($errors)) {
        $checkEmailSql = "SELECT r_email FROM recruiters_signup WHERE r_email = ?";
        $checkStmt = mysqli_prepare($conn, $checkEmailSql);
        mysqli_stmt_bind_param($checkStmt, 's', $email);
        mysqli_stmt_execute($checkStmt);
        mysqli_stmt_store_result($checkStmt);
        
        if (mysqli_stmt_num_rows($checkStmt) > 0) {
            $errors[] = "Email already registered.";
        }
        mysqli_stmt_close($checkStmt);
    }

    // Insert if no errors
    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO recruiters_signup (r_email, r_password) VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 'ss', $email, $hashed_password);
            if (mysqli_stmt_execute($stmt)) {
                header("Location: ../../Frontend/Register/Sub_Register/recruiter_signup.html?signup=success");
                exit();
            } else {
                $errors[] = "Error: " . mysqli_error($conn);
            }
            mysqli_stmt_close($stmt);
        } else {
            $errors[] = "Database error: " . mysqli_error($conn);
        }
    }

    // Store errors in session and redirect back
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        $_SESSION['form_data'] = $_POST;
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }
}

mysqli_close($conn);