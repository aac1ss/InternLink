<?php
session_start();
include('../dbconfig.php');

$c_id = $_SESSION['c_id']; // Get the candidate ID from the session

// Ensure the candidate ID is valid
if (!$c_id) {
    die("You must be logged in to edit your profile.");
}

// Check if the candidate profile already exists
$query = "SELECT * FROM candidate_profiles WHERE c_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $c_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$existing_profile = mysqli_fetch_assoc($result); // Fetch the profile data

// Process the form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data with checks for existence
    $full_name = isset($_POST['full_name']) ? mysqli_real_escape_string($conn, $_POST['full_name']) : '';
    $email = isset($_POST['email']) ? mysqli_real_escape_string($conn, $_POST['email']) : '';
    $phone = isset($_POST['phone_number']) ? mysqli_real_escape_string($conn, $_POST['phone_number']) : '';
    $address = isset($_POST['address']) ? mysqli_real_escape_string($conn, $_POST['address']) : '';
    $education_level = isset($_POST['highest_degree']) ? mysqli_real_escape_string($conn, $_POST['highest_degree']) : '';
    $skills = isset($_POST['technical_skills']) ? mysqli_real_escape_string($conn, $_POST['technical_skills']) : '';
    $experience = isset($_POST['experience']) ? mysqli_real_escape_string($conn, $_POST['experience']) : '';
    $linkedin_url = isset($_POST['linkedin_profile']) ? mysqli_real_escape_string($conn, $_POST['linkedin_profile']) : '';
    $github_url = isset($_POST['github_profile']) ? mysqli_real_escape_string($conn, $_POST['github_profile']) : '';
    $portfolio_url = isset($_POST['portfolio_website']) ? mysqli_real_escape_string($conn, $_POST['portfolio_website']) : '';

    // Validate required fields
    if (empty($full_name) || empty($email) || empty($phone) || empty($address) || empty($education_level) || empty($skills)) {
        die("Please fill in all the required fields.");
    }

    // Handle file uploads
    $upload_dir = '../uploads/';
    $resume_file_path = '';
    $profile_picture_path = '';

    // Resume upload with PDF validation
    if (!empty($_FILES['resume']['name'])) {
        $resume_file = $_FILES['resume'];
        $file_extension = pathinfo($resume_file['name'], PATHINFO_EXTENSION);
        
        // Check if the file is a PDF
        if ($file_extension !== 'pdf') {
            die("The resume must be in PDF format.");
        }
        
        $resume_file_path = $upload_dir . basename($resume_file['name']);
        move_uploaded_file($resume_file['tmp_name'], $resume_file_path);
    } else {
        die("Please upload a resume.");
    }

    // Profile picture upload (optional)
    if (!empty($_FILES['profile_picture']['name'])) {
        $profile_picture = $_FILES['profile_picture'];
        $profile_picture_path = $upload_dir . basename($profile_picture['name']);
        move_uploaded_file($profile_picture['tmp_name'], $profile_picture_path);
    }

    // If the profile already exists, update it
    if ($existing_profile) {
        $update_query = "UPDATE candidate_profiles SET 
            full_name = ?, 
            email = ?, 
            phone = ?, 
            address = ?, 
            education_level = ?, 
            skills = ?, 
            experience = ?, 
            linkedin_url = ?, 
            github_url = ?, 
            portfolio_url = ?, 
            resume_file = ?, 
            profile_picture = ? 
            WHERE c_id = ?";

        $stmt = mysqli_prepare($conn, $update_query);
        mysqli_stmt_bind_param($stmt, "ssssssssssssi", 
            $full_name, $email, $phone, $address, $education_level, $skills, $experience, 
            $linkedin_url, $github_url, $portfolio_url, $resume_file_path, $profile_picture_path, $c_id);
        mysqli_stmt_execute($stmt);
    } else {
        // Insert a new profile if it doesn't exist
        $insert_query = "INSERT INTO candidate_profiles (
            c_id, full_name, email, phone, address, education_level, skills, experience, 
            linkedin_url, github_url, portfolio_url, resume_file, profile_picture
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($conn, $insert_query);
        mysqli_stmt_bind_param($stmt, "issssssssssss", 
            $c_id, $full_name, $email, $phone, $address, $education_level, $skills, $experience, 
            $linkedin_url, $github_url, $portfolio_url, $resume_file_path, $profile_picture_path);
        mysqli_stmt_execute($stmt);
    }

    // Redirect to the dashboard after successful submission
    header('Location: http://localhost/INTERNLINk/Frontend/DashBoard/Candidate/candidate_dashboard.php?status=success');
    exit;
}

?>
