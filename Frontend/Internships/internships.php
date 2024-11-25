<?php
include '../../Backend/dbconfig.php'; // Include the database connection

// Fetch all internships from the database
$sql = "SELECT * FROM post_internship_form_detail ORDER BY internship_id DESC";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("SQL Error: " . mysqli_error($conn)); // Handle SQL errors
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Internship Listings</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="internships.css">
</head>
<body>

<!-- Dummy Navbar -->
<nav class="navbar">
    <div class="logo">InternLink</div>
    <ul class="nav-links">
        <li><a href="#">Home</a></li>
        <li><a href="#">Browse Internships</a></li>
        <li><a href="#">Companies</a></li>
        <li><a href="#">Contact</a></li>
    </ul>
</nav>

<!-- Internship Listings Section -->
<section class="internship-list-section">
    <div class="internship-list">
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <!-- Internship Card -->
                <div class="internship-card">
                    <div class="card-header">
                        <img src="/images/LOGO/PNG/ICON.png" alt="Company Logo" class="company-logo">
                        <div class="job-overview">
                            <h3><?php echo htmlspecialchars($row['internship_title']); ?></h3>
                            <p class="company-name"><?php echo htmlspecialchars($row['company_name']); ?></p>
                            <div class="job-details">
                                <span><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($row['location']); ?></span>
                                <span><i class="fas fa-dollar-sign"></i> <?php echo htmlspecialchars($row['stipend_amount'] ?: 'Unpaid'); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="tags">
                        <span>#<?php echo htmlspecialchars($row['type']); ?></span>
                        <span>#InternshipProgram</span>
                    </div>
                    <div class="card-footer">
                        <span id="days-left"><i class="fas fa-clock"></i> Apply Now</span>
                        <button class="details-btn" onclick="openModal('<?php echo htmlspecialchars(json_encode($row)); ?>')">View Details</button>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No internships available at the moment. Check back later!</p>
        <?php endif; ?>
    </div>
</section>

<!-- Internship Details Modal -->
<div id="internshipModal" class="modal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeModal()">&times;</span>
        
        <!-- Modal Header with Job Title and Company Name -->
        <div class="modal-header">
            <h2 id="modal-job-title">Job Title</h2>
            <p class="company-name-modal" id="modal-company-name">Company Name</p>
        </div>

        <!-- Modal Body with Detailed Job Information -->
        <div class="modal-body">
            <div class="modal-job-details">
                <p><i class="fas fa-dollar-sign"></i> <strong>Offered Salary:</strong> <span id="modal-stipend"></span></p>
                <p><i class="fas fa-map-marker-alt"></i> <strong>Location:</strong> <span id="modal-location"></span></p>
                <p><i class="fas fa-calendar-alt"></i> <strong>Duration:</strong> <span id="modal-duration"></span></p>
                <p><i class="fas fa-user"></i> <strong>Type:</strong> <span id="modal-type"></span></p>
            </div>

            <h3>Job Description</h3>
            <p id="modal-description"></p>

            <h3>Responsibilities</h3>
            <p id="modal-responsibilities"></p>

            <h3>Requirements</h3>
            <p id="modal-requirements"></p>

            <h3>Perks</h3>
            <p id="modal-perks"></p>
        </div>

        <!-- Modal Footer with Apply Button -->
        <div class="modal-footer">
            <button class="apply-btn">Apply Now</button>
        </div>
    </div>
</div>

<!-- Dummy Footer -->
<footer class="footer">
    <div class="footer-left">
        <a href="#">Privacy Policy</a>
    </div>
    <div class="footer-right">
        <a href="#">User Agreement</a>
        <p>© 2024 InternLink</p>
    </div>
</footer>

<script src="internship.js"></script>

<?php
mysqli_close($conn); // Close database connection
?>


</body>
</html>
