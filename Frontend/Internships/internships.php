<?php
// Start the session to access session variables
session_start();

// Include the database connection
include '../../Backend/dbconfig.php';

// Check if the user is logged in as a candidate
$is_candidate = isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'candidate';

// If not logged in, redirect to the login page
if (!$is_candidate) {
    header("Location: ../../Frontend/Login/Sub_Logins/candidate_login.html");
    exit;
}

// Retrieve the logged-in user's email from the session
$email = $_SESSION['email']; // Assuming email is stored in session

// Query to fetch the candidate details, including the profile picture
$query = "SELECT c_id, profile_picture FROM candidate_profiles WHERE email = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$candidate = mysqli_fetch_assoc($result);

// Check if the candidate's details exist
if ($candidate) {
    $c_id = $candidate['c_id'];
    // Use the profile picture from the database or a default if not found
    $profile_picture = $candidate['profile_picture'] ? '../../Backend/uploads/' . $candidate['profile_picture'] : '../../images/default-profile.png';
} else {
    // Set a default profile picture if no profile found
    $profile_picture = '../../images/default-profile.png';
}

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
    <link rel="icon" href="../images/favicon.ico"
        type="image/x-icon" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="internships.css">
    <link rel="stylesheet" href="../Responsive/respo_nav_footer.css">
</head>
<body>

   <!-- Navigation -->
   
   <header>
        <div class="navigation">
            <!-- Default Logo -->
            <div class="logo primary-logo">
                <a href="../index.html">
                    <img src="../images/LOGO/LOGO.svg" alt="InternLink Logo">
                </a>
            </div>
            
            <!-- Secondary Logo for Small Screens -->
            <div class="logo secondary-logo">
                <a href="../index.html">
                    <img src="../images/LOGO/PNG/ICON - Copy.png" alt="InternLink Small Logo">
                </a>
            </div>
            
            <!-- Hamburger Menu -->
            <div class="hamburger">
                <span></span>
                <span></span>
                <span></span>
            </div>
            
            <nav>
                <ul class="nav-links">
                    <li><a href="../index.html">Home</a></li>
                    <li><a href="../Internships/internships.php">Internships</a></li>
                    <li><a href="#about-us">About Us</a></li>
                </ul>
                <div class="nav-buttons">
                    <a href="../Login/Nav_Login/Login_index.htm">
                        <button class="login-btn">Login</button>
                    </a>
                    <a href="../Register/Nav_Register/register_index.htm">
                        <button class="register-btn">Register</button>
                    </a>
                    <button class="admin-btn"><a href="../DashBoard/Adminn/admin.html" id="admin-btn" style="text-decoration: none;"> Admin </a></button>
                </div>
            </nav>
        </div>
    </header>
    
    <?php
include '../../Backend/dbconfig.php'; // Include the database connection

// Check if the user is logged in as a candidate
$is_candidate = isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'candidate';

// Fetch all internships from the database
$sql = "SELECT * FROM post_internship_form_detail ORDER BY internship_id DESC";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("SQL Error: " . mysqli_error($conn)); // Handle SQL errors
}
?>
<?php
include '../../Backend/dbconfig.php'; // Include the database connection

// Check if the user is logged in as a candidate
$is_candidate = isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'candidate';

// Fetch all internships from the database
$sql = "SELECT * FROM post_internship_form_detail ORDER BY internship_id DESC";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("SQL Error: " . mysqli_error($conn)); // Handle SQL errors
}
?>

<!-- Internship Listings Section -->
<section class="internship-list-section">
    <div class="internship-list">
        
    
    <?php if (mysqli_num_rows($result) > 0): ?>        
            <?php while ($row = mysqli_fetch_assoc($result)): ?> 
               <?php
    // Fetch the company logo from the company_profile table
    $company_name = $row['company_name']; // Get the company name
    $sql_logo = "SELECT company_logo FROM company_profile WHERE company_name = '$company_name'"; // New SQL query
    $result_logo = mysqli_query($conn, $sql_logo);
    $company_logo = '';

    if ($result_logo && mysqli_num_rows($result_logo) > 0) {
        $logo_row = mysqli_fetch_assoc($result_logo);
        $company_logo = $logo_row['company_logo']; // Get the company logo file name
    }

    // Define the path to the uploads folder
    $logo_path = '../../Backend/uploads/' . $company_logo; // Assuming the logo is saved in the 'uploads' folder
?>

                <!-- Internship Card -->
              <div class="internship-card">
    <!-- Login Required Sticker (only visible if not logged in as a candidate) -->
    <?php if (!$is_candidate): ?>
        <div class="login-required-sticker">
            <span>Login to Apply</span>
        </div>
    <?php endif; ?>

    <div class="card-header">

<img src="<?php echo htmlspecialchars($logo_path, ENT_QUOTES, 'UTF-8'); ?>" alt="Company Logo" class="company-logo">

        <!-- <img src="/images/LOGO/PNG/ICON.png" alt="Company Logo" class="company-logo"> -->
        
        <div class="job-overview">
            <h3><?php echo htmlspecialchars($row['internship_title'], ENT_QUOTES, 'UTF-8'); ?></h3>
            <p class="company-name">
                <?php echo htmlspecialchars($row['company_name'] ?? 'Unknown Company', ENT_QUOTES, 'UTF-8'); ?>
            </p>

            <div class="job-details">
                <span><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($row['location'] ?? 'Location not specified', ENT_QUOTES, 'UTF-8'); ?></span>
                <span><img src="../images/rs.png" style="width: 20px; height: 18px; margin-right:5px;" >  
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
            // Retrieve created_at and deadline directly from the database
            $created_at = new DateTime($row['created_at']); 
            $deadline = new DateTime($row['deadline']);

            // Current date as the reference point
            $current_date = new DateTime();

            // Calculate days remaining or check expiration
            if ($current_date > $deadline) {
                $remaining_text = '<i class="fas fa-clock"></i> Deadline Passed';
            } else {
                $diff = $current_date->diff($deadline);
                $remaining_text = '<i class="fas fa-clock"></i> ' . $diff->days . ' days left';
            }

            // Format created_at for display
            $created_at_text = $created_at->format('M d, Y');
        ?>
        <span id="days-left"><?php echo $remaining_text; ?></span>
        <small class="created-at" style="color:grey; font-weight: bold;"  >Posted on: <?php echo htmlspecialchars($created_at_text, ENT_QUOTES, 'UTF-8'); ?></small>

        <!-- Check if the user is a candidate before displaying the "Apply Now" button -->
        <?php if ($is_candidate): ?>
            <button class="details-btn" onclick="openModal(<?php echo htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8'); ?>)">View Details</button>
            <button class="apply-btn" onclick="applyForInternship(<?php echo $row['internship_id']; ?>)">Apply Now</button>
        <?php else: ?>
            <button class="details-btn" onclick="openModal(<?php echo htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8'); ?>)">View Details</button>
            <!-- Login required sticker already displayed -->
        <?php endif; ?>
    </div>
</div>

            <?php endwhile; ?>
        <?php else: ?>
            <p>No internships available at the moment. Check back later!</p>
        <?php endif; ?>
    </div>
</section>

<?php
// Check if the connection is still open before attempting to close it
if ($conn) {
    mysqli_close($conn); // Close database connection
}
?>

<!-- Internship Details Modal -->
<div id="internshipModal" class="modal" style="display: none;">
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
                <p><img src="../images/rs.png" style="width: 20px; height: 18px; margin-right:5px;" >   <strong>Offered Salary:</strong> <span id="modal-stipend"></span></p>
                <p><i class="fas fa-map-marker-alt"></i> <strong>Location:</strong> <span id="modal-location"></span></p>
                <p><i class="fas fa-calendar-alt"></i> <strong>Duration:</strong> <span id="modal-duration"></span> months</p>
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


</body>
</html>
