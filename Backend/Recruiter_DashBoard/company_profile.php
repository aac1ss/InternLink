<?php
session_start();
include("../db_connection.php");

if (isset($_SESSION['r_id'])) {
    $r_id = $_SESSION['r_id'];

    // Fetch existing profile data
    $query = "SELECT * FROM company_profiles WHERE r_id = '$r_id'";
    $result = mysqli_query($conn, $query);
    $profile = mysqli_fetch_assoc($result);

    // Check if a profile exists
    if ($profile) {
        // Pre-fill the form with existing values
        $company_name = $profile['company_name'];
        $industry = $profile['industry'];
        $company_size = $profile['company_size'];
        $website = $profile['website'];
        $description = $profile['description'];
        $contact_person = $profile['contact_person'];
        $contact_position = $profile['contact_position'];
        $contact_email = $profile['contact_email'];
        $contact_phone = $profile['contact_phone'];
        $office_address = $profile['office_address'];
        $linkedin = $profile['linkedin'];
        $twitter = $profile['twitter'];
        $facebook = $profile['facebook'];
        $other_social = $profile['other_social'];
        // Logo and registration document can be handled similarly
    }
} else {
    echo "You need to be logged in to view your profile.";
}
?>
