<?php
session_start();
include '../../Backend/dbconfig.php';

// Redirect if not logged in
if (!isset($_SESSION['email'])) {
    header("Location: ../../Frontend/Login/Sub_Logins/candidate_login.html");
    exit;
}

// Retrieve logged-in user's details
$email = $_SESSION['email'];
$query = "SELECT c_id, full_name, profile_picture FROM candidate_profiles WHERE email = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$candidate = mysqli_fetch_assoc($result);

if ($candidate) {
    $c_id = $candidate['c_id'];
    $full_name = $candidate['full_name'] ?? 'Candidate';
    $profile_picture = !empty($candidate['profile_picture']) ? '../../Backend/uploads/' . $candidate['profile_picture'] : '../../images/default-profile.png';
} else {
    $c_id = 'Unknown';
    $full_name = 'Guest User';
    $profile_picture = '../../images/default-profile.png';
}

// Fetch all internships
$sql = "SELECT * FROM post_internship_form_detail ORDER BY internship_id DESC";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("SQL Error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Internship Listings</title>
    <link rel="icon" href="../images/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="internships_dashboard.css">
    <link rel="stylesheet" href="../Responsive/respo_nav_footer.css">
</head>
<body>

<header>
    <div class="navigation">
        <div class="logo primary-logo">
            <a href="../index.html">
                <img src="../images/LOGO/LOGO.svg" alt="InternLink Logo">
            </a>
        </div>
        <div class="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <nav>
            <ul class="nav-links">
                <li><a href="../index.html">Home</a></li>
                <li><a href="../Dashboard/Candidate/candidate_dashboard.php">Dashboard</a></li>
            </ul>
        </nav>
        <div class="recruiter-profile">
            <img src="<?php echo $profile_picture; ?>" alt="Profile Picture" class="profile-pic">
        </div>
    </div>
</header>

<div class="profile-details-container">
    <div class="profile-details">
        <p class="candidate-name"><?php echo "Hi, " . htmlspecialchars($full_name, ENT_QUOTES, 'UTF-8'); ?></p>
    </div>
</div>

<section class="internship-list-section">
    <div class="internship-list">
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <?php
                $r_id = $row['r_id'];
                $internship_id = $row['internship_id'];

                // Fetch company logo
                $sql_logo = "SELECT company_logo FROM company_profile WHERE r_id = ?";
                $stmt_logo = mysqli_prepare($conn, $sql_logo);
                mysqli_stmt_bind_param($stmt_logo, "i", $r_id);
                mysqli_stmt_execute($stmt_logo);
                $result_logo = mysqli_stmt_get_result($stmt_logo);
                $company_logo = ($logo_row = mysqli_fetch_assoc($result_logo)) ? '../../Backend/uploads/' . $logo_row['company_logo'] : '../images/default-company-logo.png';
                ?>
                <div class="internship-card">
                    <div class="card-header">
                        <img src="<?php echo $company_logo; ?>" alt="Company Logo" class="company-logo">
                        <div class="job-overview">
                            <h3><?php echo htmlspecialchars($row['internship_title'], ENT_QUOTES, 'UTF-8'); ?></h3>
                            <p class="company-name"><?php echo htmlspecialchars($row['company_name'] ?? 'Unknown Company', ENT_QUOTES, 'UTF-8'); ?></p>
                            <div class="job-details">
                                <span><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($row['location'] ?? 'Not Specified', ENT_QUOTES, 'UTF-8'); ?></span>
                                <span><img src="../images/rs.png" style="width: 20px; height: 18px; margin-right:5px;">
                                    <?php echo htmlspecialchars($row['stipend_amount'] ?: 'Unpaid', ENT_QUOTES, 'UTF-8'); ?>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="tags">
                        <span>#<?php echo htmlspecialchars($row['type'], ENT_QUOTES, 'UTF-8'); ?></span>
                        <span>#<?php echo htmlspecialchars($row['location'], ENT_QUOTES, 'UTF-8'); ?></span>
                        <span>#InternshipProgram</span>
                    </div>
                    <div class="card-footer">
                        <?php
                        $created_at = new DateTime($row['created_at']);
                        $deadline = new DateTime($row['deadline']);
                        $current_date = new DateTime();
                        $remaining_text = $current_date > $deadline
                            ? '<i class="fas fa-clock"></i> Deadline Passed'
                            : '<i class="fas fa-clock"></i> ' . $current_date->diff($deadline)->days . ' days left';
                        ?>
                        <span id="days-left"><?php echo $remaining_text; ?></span>
                        <small class="created-at">Posted on: <?php echo $created_at->format('M d, Y'); ?></small>
                        <a href="../../Backend/Internship/apply_internship.php?internship_id=<?php echo urlencode($row['internship_id']); ?>&internship_title=<?php echo urlencode($row['internship_title']); ?>&created_at=<?php echo urlencode($row['created_at']); ?>&company_name=<?php echo urlencode($row['company_name']); ?>" class="apply-btn">Apply Now</a>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No internships available at the moment. Check back later!</p>
        <?php endif; ?>
    </div>
</section>

<?php if ($conn) mysqli_close($conn); ?>

<footer class="footer">
    <div class="footer-left">
        <a href="#">Privacy Policy</a>
    </div>
    <div class="footer-right">
        <a href="#">User Agreement</a>
        <p>© 2024 InternLink</p>
    </div>
</footer>

</body>
</html>
