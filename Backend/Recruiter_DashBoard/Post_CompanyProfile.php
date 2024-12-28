<?php
session_start();
include('../dbconfig.php');

$r_id = $_SESSION['r_id']; // Get the recruiter ID from the session

// Ensure the recruiter ID is valid
if (!$r_id) {
    die("You must be logged in to edit the company profile.");
}

// Check if the company profile already exists for this recruiter
$query = "SELECT * FROM company_profile WHERE r_id = '$r_id'";
$result = mysqli_query($conn, $query);

// Error check for the query
if (!$result) {
    die("Error fetching profile: " . mysqli_error($conn));
}

$company_profile = mysqli_fetch_assoc($result); // Fetch the company profile data

// Process the form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $company_name = mysqli_real_escape_string($conn, $_POST['company_name']);
    $industry = mysqli_real_escape_string($conn, $_POST['industry']);
    $company_size = mysqli_real_escape_string($conn, $_POST['company_size']);
    $website = mysqli_real_escape_string($conn, $_POST['company_website']);
    $company_description = mysqli_real_escape_string($conn, $_POST['company_description']);
    $contact_person_name = mysqli_real_escape_string($conn, $_POST['contact_person_name']);
    $contact_position = mysqli_real_escape_string($conn, $_POST['contact_position']);
    $contact_email = mysqli_real_escape_string($conn, $_POST['contact_email']);
    $contact_phone_number = mysqli_real_escape_string($conn, $_POST['contact_phone']);
    $office_address = mysqli_real_escape_string($conn, $_POST['office_address']);
    $linkedin_profile = mysqli_real_escape_string($conn, $_POST['linkedin_profile']);
    $twitter_handle = mysqli_real_escape_string($conn, $_POST['twitter_handle']);
    $facebook_page = mysqli_real_escape_string($conn, $_POST['facebook_page']);
    $other_social_link = mysqli_real_escape_string($conn, $_POST['other_social_link']);

    // Handle file uploads
    $upload_dir = '../uploads/';
    $company_logo_path = '';
    $registration_document_path = '';

    // Company logo upload
    if (!empty($_FILES['company_logo']['name'])) {
        $company_logo = $_FILES['company_logo'];
        $company_logo_path = $upload_dir . basename($company_logo['name']);
        move_uploaded_file($company_logo['tmp_name'], $company_logo_path);
    }

    // Registration document upload
    if (!empty($_FILES['registration_document']['name'])) {
        $registration_document = $_FILES['registration_document'];
        $registration_document_path = $upload_dir . basename($registration_document['name']);
        move_uploaded_file($registration_document['tmp_name'], $registration_document_path);
    }

    // Update or Insert the company profile
    if ($company_profile) {
        // Update the existing profile
        $update_query = "UPDATE company_profile SET 
            company_name = '$company_name',
            industry = '$industry',
            company_size = '$company_size',
            website = '$website',
            company_description = '$company_description',
            contact_person_name = '$contact_person_name',
            contact_position = '$contact_position',
            contact_email = '$contact_email',
            contact_phone_number = '$contact_phone_number',
            office_address = '$office_address',
            linkedin_profile = '$linkedin_profile',
            twitter_handle = '$twitter_handle',
            facebook_page = '$facebook_page',
            other_social_link = '$other_social_link',
            company_logo = '$company_logo_path',
            registration_document = '$registration_document_path'
            WHERE r_id = '$r_id'";

        mysqli_query($conn, $update_query);
    } else {
        // Insert a new profile
        $insert_query = "INSERT INTO company_profile (
            r_id, company_name, industry, company_size, website, company_description,
            contact_person_name, contact_position, contact_email, contact_phone_number, office_address,
            linkedin_profile, twitter_handle, facebook_page, other_social_link, company_logo, registration_document
        ) VALUES (
            '$r_id', '$company_name', '$industry', '$company_size', '$website', '$company_description',
            '$contact_person_name', '$contact_position', '$contact_email', '$contact_phone_number', '$office_address',
            '$linkedin_profile', '$twitter_handle', '$facebook_page', '$other_social_link', '$company_logo_path', '$registration_document_path'
        )";

        mysqli_query($conn, $insert_query);
    }

    // Redirect to the dashboard after submission
    header('Location: http://localhost/INTERNLINk/Frontend/DashBoard/Recruiter/recruiter_dashboard.php?status=success');
    exit;
}
?>
