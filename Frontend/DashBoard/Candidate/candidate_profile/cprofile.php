<?php
include 'getcprofile.php'; // Include the script that fetches profile data
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
    <a href="http://localhost/InternLink/Frontend/DashBoard/Recruiter/recruiter_dashboard.php" class="back-btn">Back to Dashboard</a>

    <div class="profile-container">
        <!-- Header Section -->
        <header class="profile-header">
            <div class="profile-pic-container">
            <img src="../../../../Backend/uploads/<?php echo $candidate['profile_picture']; ?>" alt="Profile Picture"  width="150" height="150">
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
