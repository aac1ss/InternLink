<?php
// Start session to store success or failure message
session_start();

// Include PHPMailer classes
require 'D:/xampp/htdocs/InternLink/Backend/Candidate_Dashboard/PHPMailer-master/src/Exception.php';
require 'D:/xampp/htdocs/InternLink/Backend/Candidate_Dashboard/PHPMailer-master/src/PHPMailer.php';
require 'D:/xampp/htdocs/InternLink/Backend/Candidate_Dashboard/PHPMailer-master/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Check if the form is submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    $name = $_POST['admin_contact_name'];
    $email = $_POST['admin_contact_email'];

    $admin_email = "tryaac1ss@gmail.com";  // Admin email to receive the message

    $mail = new PHPMailer(true);

    try {
        // Set up PHPMailer settings
        $mail->isSMTP();  // Send using SMTP
        $mail->Host = 'smtp.gmail.com';  // Set the SMTP server to Gmail
        $mail->SMTPAuth = true;  // Enable SMTP authentication
        $mail->Username = 'tryaac1ss@gmail.com';  // Your Gmail email address
        $mail->Password = 'mnqipatskvfcyfxb';  // Your Gmail App Password (if 2FA enabled)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  // Enable TLS encryption
        $mail->Port = 587;  // SMTP port for Gmail

        // Set email sender and recipient
        $mail->setFrom($email, $name);  // Sender's email and name
        $mail->addAddress($admin_email);  // Recipient's email (admin email)

        // Set email subject and body
        $mail->isHTML(false);  // Send as plain text
        $mail->Subject = "Contact Form Submission: $subject";  // Email subject
        $mail->Body = "Message from: $name\nEmail: $email\n\nSubject: $subject\n\nMessage:\n$message";  // Email body

        // Send the email
        if ($mail->send()) {
            // Set success message in session
            $_SESSION['alertMessage'] = "Message has been sent successfully!";
        }
    } catch (Exception $e) {
        // Set error message in session
        $_SESSION['alertMessage'] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

    // Redirect back to contact form
    header("Location: ../../Frontend/DashBoard/Recruiter/recruiter_dashboard.php");
    exit();
}