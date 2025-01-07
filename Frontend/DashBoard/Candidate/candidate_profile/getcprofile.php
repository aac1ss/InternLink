<?php
// get_profile.php
include '../../../../Backend/dbconfig.php';  // Include the database configuration

// Check if c_id is passed via GET
if (isset($_GET['c_id'])) {
    $c_id = $_GET['c_id'];

    // Query to fetch candidate data
    $query = "SELECT * FROM candidate_profiles WHERE c_id = $c_id";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        // Fetch candidate data from the result
        $candidate = mysqli_fetch_assoc($result);

        // Store profile details in variables
        $full_name = $candidate['full_name'];
        $email = $candidate['email'];
        $phone = $candidate['phone'];
        $address = $candidate['address'];
        $education_level = $candidate['education_level'];
        $skills = $candidate['skills'];
        $experience = $candidate['experience'];
        $linkedin_url = $candidate['linkedin_url'];
        $github_url = $candidate['github_url'];
        $portfolio_url = $candidate['portfolio_url'];
        $resume_file = $candidate['resume_file'];
        $profile_picture = $candidate['profile_picture'];
    } else {
        // If candidate not found, redirect or show error
        echo "Candidate not found!";
        exit;
    }
} else {
    // If no c_id is passed, redirect or show error
    echo "No candidate ID provided!";
    exit;
}
?>
