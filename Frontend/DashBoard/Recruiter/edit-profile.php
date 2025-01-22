<?php
session_start();
include('../../../Backend/dbconfig.php');
$r_id = $_SESSION['r_id']; // Get the recruiter ID from the session

// Ensure the recruiter ID is valid
if (!$r_id) {
    die("You must be logged in to view the company profile.");
}

// Fetch the company profile data
$query = "SELECT * FROM company_profile WHERE r_id = '$r_id'";
$result = mysqli_query($conn, $query);

// Error check for the query
if (!$result) {
    die("Error fetching profile: " . mysqli_error($conn));
}

$company_profile = mysqli_fetch_assoc($result); // Fetch the company profile data
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Profile</title>
    <link rel="stylesheet" href="edit-profile.css">
</head>
<body>
<!-- Back Button -->
<a href="http://localhost/InternLink/Frontend/DashBoard/Recruiter/recruiter_dashboard.php" class="back-btn">Back to Dashboard</a>

<div class="profile-container">
    <div class="profile-header">
        <h1><?php echo htmlspecialchars($company_profile['company_name'] ?? 'N/A'); ?></h1>
        <p>View your company details</p>
    </div>
    
    <?php if ($company_profile): ?>
        <div class="profile-card">
            <h2>Company Information</h2>
            <div class="profile-info">
                <p><strong>Company Name:</strong> <?php echo htmlspecialchars($company_profile['company_name'] ?? 'N/A'); ?></p>
                <p><strong>Industry:</strong> <?php echo htmlspecialchars($company_profile['industry'] ?? 'N/A'); ?></p>
                <p><strong>Company Size:</strong> <?php echo htmlspecialchars($company_profile['company_size'] ?? 'N/A'); ?></p>
                <p><strong>Website:</strong> 
                    <?php 
                    // Check if company_website is set and not null
                    if (isset($company_profile['website']) && !empty($company_profile['website'])): ?>
                        <a href="<?php echo htmlspecialchars($company_profile['website']); ?>" target="_blank"><?php echo htmlspecialchars($company_profile['website']); ?></a>
                    <?php else: ?>
                        N/A
                    <?php endif; ?>
                </p>
                <p><strong>Company Description:</strong> <?php echo nl2br(htmlspecialchars($company_profile['company_description'] ?? 'No description available')); ?></p>
            </div>
        </div>

        <div class="profile-card">
            <h2>Contact Information</h2>
            <div class="profile-info">
                <p><strong>Contact Person Name:</strong> <?php echo htmlspecialchars($company_profile['contact_person_name'] ?? 'N/A'); ?></p>
                <p><strong>Contact Position:</strong> <?php echo htmlspecialchars($company_profile['contact_position'] ?? 'N/A'); ?></p>
                <p><strong>Contact Email:</strong> <?php echo htmlspecialchars($company_profile['contact_email'] ?? 'N/A'); ?></p>
                <p><strong>Contact Phone Number:</strong> <?php echo htmlspecialchars($company_profile['contact_phone_number'] ?? 'N/A'); ?></p>
                <p><strong>Office Address:</strong> <?php echo htmlspecialchars($company_profile['office_address'] ?? 'N/A'); ?></p>
            </div>
        </div>

        <div class="profile-card">
            <h2>Social Media Links</h2>
            <div class="profile-info">
                <p><strong>LinkedIn Profile:</strong> 
                    <?php 
                    if (isset($company_profile['linkedin_profile']) && !empty($company_profile['linkedin_profile'])): ?>
                        <a href="<?php echo htmlspecialchars($company_profile['linkedin_profile']); ?>" target="_blank"><?php echo htmlspecialchars($company_profile['linkedin_profile']); ?></a>
                    <?php else: ?>
                        N/A
                    <?php endif; ?>
                </p>
                <p><strong>Twitter Handle:</strong> <?php echo htmlspecialchars($company_profile['twitter_handle'] ?? 'N/A'); ?></p>
                <p><strong>Facebook Page:</strong> <?php echo htmlspecialchars($company_profile['facebook_page'] ?? 'N/A'); ?></p>
                <p><strong>Other Social Link:</strong> <?php echo htmlspecialchars($company_profile['other_social_link'] ?? 'N/A'); ?></p>
            </div>
        </div>

        <div class="profile-card">
            <h2>Uploads</h2>
            <div class="profile-info">
                <p><strong>Company Logo:</strong></p>
                <?php if ($company_profile['company_logo']): ?>
                    <img src="../../../Backend/uploads/<?php echo htmlspecialchars($company_profile['company_logo']); ?>" alt="Company Logo" class="company-logo" />
                <?php else: ?>
                    <p>No logo uploaded.</p>
                <?php endif; ?>

                <p><strong>Registration Document:</strong></p>
                <?php if ($company_profile['registration_document']): ?>
                    <a href="../../../Backend/uploads/<?php echo htmlspecialchars($company_profile['registration_document']); ?>" target="_blank" class="doc-link">View Registration Document</a>
                <?php else: ?>
                    <p>No registration document uploaded.</p>
                <?php endif; ?>
            </div>
        </div>

    <?php else: ?>
        <div class="no-profile">
            <h2>FILL THE COMPANY PROFILE</h2>
            <p>No company profile found. Please fill in your company profile details.</p>
        </div>
    <?php endif; ?>
</div>

</body>
</html>
