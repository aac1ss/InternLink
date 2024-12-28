<?php
session_start();
include('../db_connection.php'); // Assume you have a file to handle DB connection

$r_id = $_SESSION['r_id']; // Get the recruiter ID from the session

// Check if the company profile already exists
$query = "SELECT * FROM company_profile WHERE r_id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$r_id]);
$company_profile = $stmt->fetch();

// If profile exists, update it; otherwise, insert a new one
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $company_name = $_POST['company_name'];
    $industry = $_POST['industry'];
    $company_size = $_POST['company_size'];
    $company_website = $_POST['company_website'];
    $company_description = $_POST['company_description'];
    $contact_person_name = $_POST['contact_person_name'];
    $contact_position = $_POST['contact_position'];
    $contact_email = $_POST['contact_email'];
    $contact_phone = $_POST['contact_phone'];
    $office_address = $_POST['office_address'];
    $linkedin_profile = $_POST['linkedin_profile'];
    $twitter_handle = $_POST['twitter_handle'];
    $facebook_page = $_POST['facebook_page'];
    $other_social_link = $_POST['other_social_link'];

    // Handle file uploads
    $company_logo = $_FILES['company_logo']['name'];
    $registration_document = $_FILES['registration_document']['name'];

    // Insert or update profile
    if ($company_profile) {
        // Update existing profile
        $update_query = "UPDATE company_profile SET company_name = ?, industry = ?, company_size = ?, company_website = ?, company_description = ?, contact_person_name = ?, contact_position = ?, contact_email = ?, contact_phone = ?, office_address = ?, linkedin_profile = ?, twitter_handle = ?, facebook_page = ?, other_social_link = ?, company_logo = ?, registration_document = ? WHERE r_id = ?";
        $update_stmt = $pdo->prepare($update_query);
        $update_stmt->execute([$company_name, $industry, $company_size, $company_website, $company_description, $contact_person_name, $contact_position, $contact_email, $contact_phone, $office_address, $linkedin_profile, $twitter_handle, $facebook_page, $other_social_link, $company_logo, $registration_document, $r_id]);
    } else {
        // Insert new profile
        $insert_query = "INSERT INTO company_profile (r_id, company_name, industry, company_size, company_website, company_description, contact_person_name, contact_position, contact_email, contact_phone, office_address, linkedin_profile, twitter_handle, facebook_page, other_social_link, company_logo, registration_document) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $insert_stmt = $pdo->prepare($insert_query);
        $insert_stmt->execute([$r_id, $company_name, $industry, $company_size, $company_website, $company_description, $contact_person_name, $contact_position, $contact_email, $contact_phone, $office_address, $linkedin_profile, $twitter_handle, $facebook_page, $other_social_link, $company_logo, $registration_document]);
    }

    // Redirect to the same page to show the profile or edit button
    header('Location: Recruiter_Dashboard.php');
}
?>
