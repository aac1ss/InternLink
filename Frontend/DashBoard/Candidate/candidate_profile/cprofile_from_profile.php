<?php
// Start the session
session_start();

// Check if the candidate ID is provided in the query parameter
if (!isset($_GET['c_id'])) {
    die("No candidate ID provided!");
}

// Get the candidate ID from the query parameter
$c_id = $_GET['c_id'];

// Include database connection
include('../../../../Backend/dbconfig.php');

// Fetch candidate profile data from the database
$query = "SELECT * FROM candidate_profiles WHERE c_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $c_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if the candidate profile exists
if ($result->num_rows === 0) {
    die("Candidate profile not found!");
}

// Fetch the candidate's profile data
$candidate = $result->fetch_assoc();

// Assign profile data to variables
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

// Construct file paths for profile picture and resume
$uploads_path = '../../../../Backend/uploads/';
$resume_file = $candidate['resume_file'] ? $uploads_path . $candidate['resume_file'] : "No resume available.";
$profile_picture = $candidate['profile_picture'] ? $uploads_path . $candidate['profile_picture'] : "../../images/default-profile.png";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Candidate Profile</title>
    <link rel="stylesheet" href="cprofile.css">
</head>
<body>
    <!-- Back Button -->
    <a href="http://localhost/InternLink/Frontend/DashBoard/Candidate/candidate_dashboard.php" class="back-btn">Back to Dashboard</a>

    <div class="profile-container">
        <!-- Header Section -->
        <header class="profile-header">
            <div class="profile-pic-container">
                <img src="<?php echo $profile_picture; ?>" alt="Profile Picture" width="150" height="150">
            </div>
            <div class="profile-details">
                <h1 class="candidate-name"><?php echo $full_name; ?></h1>
                <p class="candidate-title"><?php echo $education_level; ?></p>
                <p class="candidate-location"><?php echo $address; ?></p>
            </div>
        </header>

        <!-- Detailed Information Section -->
        <section class="profile-info">
            <div class="info-item">
                <strong>Email:</strong>
                <p><?php echo $email; ?></p>
            </div>
            <div class="info-item">
                <strong>Phone:</strong>
                <p><?php echo $phone; ?></p>
            </div>
            <div class="info-item">
                <strong>Education:</strong>
                <p><?php echo $education_level; ?></p>
            </div>
            <div class="info-item">
                <strong>Skills:</strong>
                <p><?php echo $skills; ?></p>
            </div>
            <div class="info-item">
                <strong>Experience:</strong>
                <p><?php echo $experience; ?></p>
            </div>
        </section>

        <!-- Links to Social Profiles -->
        <section class="social-links">
            <a href="<?php echo $linkedin_url; ?>" target="_blank" class="social-link">LinkedIn</a>
            <a href="<?php echo $github_url; ?>" target="_blank" class="social-link">GitHub</a>
            <a href="<?php echo $portfolio_url; ?>" target="_blank" class="social-link">Portfolio</a>
        </section>

        <!-- Resume Section -->
        <section class="resume-section">
            <button id="view-resume" class="resume-btn" onclick="toggleResume()">View Resume</button>
            <div id="resume-container" class="resume-container">
                <?php if ($resume_file != "No resume available."): ?>
                    <iframe src="<?php echo $resume_file; ?>" width="100%" height="600px"></iframe>
                <?php else: ?>
                    <p>No resume available.</p>
                <?php endif; ?>
            </div>
        </section>
    </div>

    <script src="cprofile.js"></script>
</body>
</html>