<?php
// Start the session to access session variables
session_start();

// Check if the user is logged in, if not redirect to login page
if (!isset($_SESSION['email'])) {
    header("Location: ../../Frontend/Login/Sub_Logins/candidate_login.html");
    exit;
}

// Retrieve the logged-in user's email from the session
$email = $_SESSION['email'];

// Include the database configuration
include('../../../Backend/dbconfig.php');

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
    // Use the profile picture from the database or default if not found
    $profile_picture = $candidate['profile_picture'] ? '../../../Backend/uploads/' . $candidate['profile_picture'] : '../../images/default-profile.png';
} else {
    // Set a default profile picture if no profile found
    $profile_picture = '../../images/default-profile.png';
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Candidate Dashboard</title>
    <link rel="icon" href="../../images/favicon.ico"
        type="image/x-icon" />
    <link rel="stylesheet" href="candidate_dashboard.css?v=1.0">

    <link rel="stylesheet" href="../../Responsive/respo_index.css">
  </head>
  <body>
  
  <header>
    <div class="recruiter-dashboard-navigation">
        <!-- Logo -->
        <div class="recruiter-dashboard-logo">
            <a href="candidate_dashboard.php">
                <img src="../../images/LOGO/LOGO.svg" alt="Dashboard Logo">
            </a>
        </div>

        <!-- Navigation Links -->
        <ul class="nav-links">
            <li><a href="../../index.html">Home</a></li>
            <li><a href="../../Internships_Dashboard/internships_dashboard.php">Internships</a></li>
        </ul>

        <!-- Profile Picture -->
        <div class="recruiter-dashboard-actions">
            <div class="recruiter-profile">
                <img src="<?php echo $profile_picture; ?>" alt="Profile Picture" class="profile-pic">
            </div>
        </div>
    </div>
</header>


    <div class="container">
      <!-- Sidebar -->
      <aside class="sidebar">
        <nav class="sidebar-nav">
          <a href="#dashboard" class="active">
            <img src="../../images/DashBoard Icons/Dashboard.svg" alt="Dashboard" class="nav-icon" /> Dashboard
          </a>
          <a href="#company-profile">
            <img src="../../images/DashBoard Icons/User.svg" alt="Profile" class="nav-icon" /> Profile
          </a>
          <div class="dropdown">
            <a href="post-internship-main-section" class="dropdown-toggle">
              <img src="../../images/DashBoard Icons/Internships.svg" alt="Internships" class="nav-icon" /> Internships
            </a>
            <div class="dropdown-content">
              <a href="#post-internship-form">
                <img src="../../images/DashBoard Icons/Timeline.svg" alt="Timeline" class="nav-icon" /> Timeline
              </a>
              <a href="#internships">
                <img src="../../images/DashBoard Icons/Status.svg" alt="View Status" class="nav-icon" /> View Status
              </a>
            </div>
          </div>
          <a href="#manage-applicants">
            <img src="../../images/DashBoard Icons/Manage Applicants.svg" alt="Manage Application" class="nav-icon" /> Manage Application
          </a>
          <a href="#membership">
            <img src="../../images/DashBoard Icons/membership.svg" alt="Membership" class="nav-icon" /> Membership
          </a>
          <a href="#contact-us">
            <img src="../../images/DashBoard Icons/Contact Us.svg" alt="Contact Us" class="nav-icon" /> Contact Us
          </a>
          <a href="#setting">
            <img src="../../images/DashBoard Icons/Settting.svg" alt="Setting" class="nav-icon" /> Setting
          </a>
        </nav>
        <div class="logout">
        <a href="/InternLink/Backend/Candidate_DashBoard/logout.php">
            <img src="../../images/DashBoard Icons/Log Out.svg" alt="Logout" class="nav-icon" /> Logout
          </a>
        </div>
      </aside>
      

    <!-- Main Content -->
    
    <main class="main-content">
      <div class="top-bar">
          <h1>Hey there, <?php echo htmlspecialchars($email); ?>!</h1>
          <div class="user-profile">
              <span class="notification-icon">🔔</span>
              <span class="user-name"><?php echo htmlspecialchars($email); ?></span> <!-- Displaying Email -->
          </div>
</div>

<?php
// Include database connection
include('../../../Backend/dbconfig.php');

// Get the candidate ID (assuming it's passed as session or URL parameter)
$c_id = $_SESSION['c_id']; // Or get it from URL if passed: $_GET['c_id']

// Prepare SQL query to fetch the required counts
$query = "
    SELECT 
        (SELECT COUNT(*) FROM internship_applications WHERE c_id = ?) AS total_applied,
        (SELECT COUNT(*) FROM internship_applications WHERE c_id = ? AND status = 'rejected') AS total_rejected,
        (SELECT COUNT(*) FROM internship_applications WHERE c_id = ? AND status = 'short-listed') AS total_shortlisted
";

// Prepare the statement
$stmt = $conn->prepare($query);

// Bind the parameters to the query
$stmt->bind_param('iii', $c_id, $c_id, $c_id);

// Execute the query
$stmt->execute();

// Fetch the result
$result = $stmt->get_result()->fetch_assoc();

// Assign the values to variables
$total_applied = $result['total_applied'] ?? 0;
$total_rejected = $result['total_rejected'] ?? 0;
$total_shortlisted = $result['total_shortlisted'] ?? 0;
?>

      <!-- Dashboard -->
      <section id="dashboard" class="section">
    <div class="content" id="dashboardContent">
      
    <section class="stats">
        <div class="stat-card" id="total-internships-applied">
          <h2><?php echo $total_applied; ?></h2>
          <p>Total Internship Applied</p>
        </div>
        <div class="stat-card" id="total-applications">
          <h2><?php echo $total_applied; ?></h2>
          <p>Total Applications</p>
        </div>
        <div class="stat-card" id="rejected">
          <h2><?php echo $total_rejected; ?></h2>
          <p>Rejected</p>
        </div>
        <div class="stat-card" id="shortlisted">
          <h2><?php echo $total_shortlisted; ?></h2>
          <p>Shortlisted</p>
        </div>
      </section>
     
     
      <section class="recent-activities">
      <div class="recent-applications">
    <h3>Recent Internships</h3>
    <?php
// Example database query to fetch recent internships
$query = "SELECT company_name, internship_title, deadline, created_at FROM post_internship_form_detail ORDER BY created_at DESC LIMIT 5";
$result = $conn->query($query); // Execute the query and get the result object

if ($result->num_rows > 0) {
    $counter = 1;
    while ($row = $result->fetch_assoc()) {
        $created_at = new DateTime($row['created_at']);
        $deadline = new DateTime($row['deadline']);
        $interval = $created_at->diff($deadline);
        $days_remaining = $interval->format('%r%a'); // Calculate days remaining

        if ($days_remaining > 0) {
            $subtractedDateMessage = $days_remaining . " days ";
        } elseif ($days_remaining == 0) {
            $subtractedDateMessage = "Deadline is today";
        } else {
            $subtractedDateMessage = abs($days_remaining) . " days ago (expired)";
        }

        // Display the internship details
        echo '<p>' . $counter . ') ' . $row['company_name'] . ' posted an internship for "' . $row['internship_title'] . '" which ends in ' . $subtractedDateMessage . '.</p>';
        $counter++;
    }
} else {
    echo '<p>No recent applications</p>';
}
?>

</div>
<div class="recent-details">
                    <h3>Recent Activities</h3>
                    <ul>
                        <li>Account Verified - 1 month ago</li>
                        <li>New Account Created - 1 month ago</li>
                    </ul>
                </div>
            </section>
          </div>
      </section>


<!-- Candidate Profile -->
<section id="company-profile" class="section">
    <div class="content">
        <form id="company-profile-form" class="company-profile-form" action="../../../Backend/Candidate_DashBoard/Post_CandidateProfile.php" method="post" enctype="multipart/form-data">
            <h1>Candidate Profile</h1>
            <h3>Personal Information</h3>
            <div class="form-group">
                <label>Full Name <span class="required">*</span></label>
                <input type="text" name="full_name" placeholder="Enter your full name" required />
            </div>
            <div class="form-group">
                <label>Email Address <span class="required">*</span></label>
                <input type="email" name="email" placeholder="Enter your email address" required />
            </div>
            <div class="form-group">
                <label>Phone Number <span class="required">*</span></label>
                <input type="tel" name="phone_number" placeholder="e.g., (977) 9869696969" required />
            </div>
            <div class="form-group">
                <label>Date of Birth <span class="required">*</span></label>
                <input type="date" name="date_of_birth" required />
            </div>
            <div class="form-group">
                <label>Address <span class="required">*</span></label>
                <input type="text" name="address" placeholder="Enter your address" required />
            </div>

            <h3>Education</h3>
            <div class="form-group">
                <label>Highest Degree <span class="required">*</span></label>
                <input type="text" name="highest_degree" placeholder="e.g., Bachelor's in Computer Science" required />
            </div>
            <div class="form-group">
                <label>Institution Name <span class="required">*</span></label>
                <input type="text" name="institution" placeholder="Enter your institution name" required />
            </div>
            <div class="form-group">
                <label>Graduation Year</label>
                <input type="text" name="graduation_year" placeholder="e.g., 2024" />
            </div>

            <h3>Skills</h3>
            <div class="form-group">
                <label>Technical Skills <span class="required">*</span></label>
                <textarea name="technical_skills" placeholder="List your technical skills..." required></textarea>
            </div>
            <div class="form-group">
                <label>Experience <span class="required">*</span></label>
                <textarea name="experience" placeholder="List your technical skills..." required></textarea>
            </div>
            <div class="form-group">
                <label>Soft Skills</label>
                <textarea name="soft_skills" placeholder="List your soft skills..."></textarea>
            </div>

            <h3>Portfolio</h3>
            <div class="form-group">
                <label>LinkedIn Profile</label>
                <input type="url" name="linkedin_profile" placeholder="e.g., www.linkedin.com/in/yourname" />
            </div>
            <div class="form-group">
                <label>GitHub Profile</label>
                <input type="url" name="github_profile" placeholder="e.g., www.github.com/yourusername" />
            </div>
            <div class="form-group">
                <label>Portfolio Website</label>
                <input type="url" name="portfolio_website" placeholder="e.g., www.yourportfolio.com" />
            </div>

            <h3>Uploads</h3>
            <div class="form-group">
                <label>Resume (pdf format)<span class="required">*</span></label>
                <input type="file" name="resume" required />
            </div>
            <div class="form-group">
                <label>Profile Picture</label>
                <input type="file" name="profile_picture" />
            </div>

            <button type="submit" class="save-btn">Save Profile</button>
        </form>
    </div>
</section>

          <!-- Timeline -->
  <section id="post-internship-form" class="post-internship-container section">
          <div class="timeline-title-container">
    <h1 class="timeline-title">View Your Internship Timeline</h1>
    </div>

    <div class="card">
      <div class="card-header" onclick="toggleCard(this)">
    
    
      <div class="card-body">
        <div class="timeline">
          <div class="timeline-step" id="step1">
            <div class="timeline-icon"></div>
            <div class="timeline-content">
              <h3>Application Submitted</h3>
              <p>Status: <span id="status1">Pending</span></p>
            </div>
          </div>

          <div class="timeline-step" id="step2">
            <div class="timeline-icon"></div>
            <div class="timeline-content">
              <h3>Under Review</h3>
              <p>Status: <span id="status2">Pending</span></p>
            </div>
          </div>

          <div class="timeline-step" id="step3">
            <div class="timeline-icon"></div>
            <div class="timeline-content">
              <h3>Selected / Rejected</h3>
              <p>Status: <span id="status3">Pending</span></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
          
          <!-- View Status -->
  <section id="internships" class="section">
    <div class="content">
        <h2>Your Applied Internships</h2>
        <table class="internship-table">
            <thead>
                <tr>
                    <th>Internship ID</th>
                    <th>Position</th>
                    <th>Company Name</th>
                    <th>Posted Date</th>
                    <th>Deadline</th>
                    <th>Applied Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody id="internship-list">
                <!-- Dynamic content will be populated here -->
            </tbody>
        </table>
    </div>
</section>


<!-- Manage Applicants Section -->
<section id="manage-applicants" class="section">

  <div class="content">
  
    <h2>Manage Applications</h2>
    <table class="applicants-table">
      <thead>
        <tr>
          <th>Application ID</th>
          <th>Company Name</th>
          <th>Position Applied</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody id="applicant-table-body">
        <!-- Data will be populated here dynamically -->
      </tbody>
    </table>
  </div>
</section>

<!-- Confirmation Modal -->
<div id="confirmation-modal" class="confirmation-modal">
  <div class="modal-content">
    <h3>Are you sure you want to retract this application?</h3>
    <button id="confirm-retract" class="action-btn reject">Yes, Retract</button>
    <button id="cancel-retract" class="action-btn">Cancel</button>
  </div>
</div>



          <!-- Memebership -->
            <section id="membership" class="section">
              <div class="content">
                  <h2>Choose Your Membership Plan</h2>
                  <div class="membership-plans">
                      <!-- Plan Cards -->
                      <div class="plan-card">
                          <h3>Basic Plan</h3>
                          <p class="price">$29/month</p>
                          <p>Access to 10 Internship postings</p>
                          <p>Basic support</p>
                          <button class="select-plan-btn" onclick="showPaymentPopup('Basic Plan', '$29/month')">Choose Plan</button>
                      </div>
                      <div class="plan-card">
                          <h3>Standard Plan</h3>
                          <p class="price">$49/month</p>
                          <p>Access to 20 Internship postings</p>
                          <p>Priority support</p>
                          <button class="select-plan-btn" onclick="showPaymentPopup('Standard Plan', '$49/month')">Choose Plan</button>
                      </div>
                      <div class="plan-card">
                          <h3>Premium Plan</h3>
                          <p class="price">$99/month</p>
                          <p>Unlimited Internship postings</p>
                          <p>Dedicated support</p>
                          <button class="select-plan-btn" onclick="showPaymentPopup('Premium Plan', '$99/month')">Choose Plan</button>
                      </div>
                  </div>
              </div>
            
              <!-- Payment Popup -->
              <div id="payment-popup" class="payment-popup">
                  <div class="popup-content">
                      <span class="close-btn" onclick="closePaymentPopup()">&times;</span>
                      <h3>Payment for <span id="plan-name"></span></h3>
                      <p><strong>Price:</strong> <span id="plan-price"></span></p>
                      <form class="payment-form">
                          <label>Card Number</label>
                          <input type="text" placeholder="1234 5678 9012 3456" required>
                          <label>Expiry Date</label>
                          <input type="text" placeholder="MM/YY" required>
                          <label>CVV</label>
                          <input type="text" placeholder="123" required>
                          <button type="submit" class="pay-btn">Pay Now</button>
                      </form>
                  </div>
              </div>
            </section>


   <!-- Setting Section -->
   <section id="setting" class="section">
              <div class="content">
                <h2>Settings</h2>
                <form class="settings-form">
                  <div class="form-group">
                    <label>Account Email</label>
                    <input type="email" placeholder="Enter your email" required />
                  </div>
                  <div class="form-group">
                    <label>Password</label>
                    <input type="password" placeholder="Enter new password" />
                  </div>
                  <div class="form-group">
                    <label>Notification Preferences</label>
                    <select>
                      <option>Email Notifications</option>
                      <option>SMS Notifications</option>
                      <option>Push Notifications</option>
                    </select>
                  </div>
                  <button type="submit" class="send-btn">Save Changes</button>
                </form>
              </div>
            </section>

          <!-- Contact Us [Admin] Section -->

      <section id="contact-us" class="section">
             <div class="content">
          <form class="contact-admin-form" action="../../../Backend/Candidate_DashBoard/contact_admin.php" method="post">
         <h1>Contact Admin</h1>
          <h3>Get in Touch</h3>
         <div class="form-group">
        <label for="subject">Subject*</label>
        <input type="text" id="subject" placeholder="Enter subject" required />
         </div>
         <div class="form-group">
        <label for="message">Message*</label>
        <textarea id="message" placeholder="Write your message here..." required></textarea>
          </div>
         <h3>Your Contact Information</h3>
         <div class="form-group">
        <label for="admin-contact-name">Your Name*</label>
        <input type="text" id="admin-contact-name" placeholder="Enter your name" required />
         </div>
         <div class="form-group">
        <label for="admin-contact-email">Your Email*</label>
        <input type="email" id="admin-contact-email" placeholder="Enter your email" required />
         </div>
          <button type="submit" id="send-btn">Send Message</button>
           </form>
          </div>
    </section>




      </main>
    </div>

    <!-- Dummy Footer -->
    <footer class="dummy-footer">
      <a
        href="../Candidate/candidate_dashboard.html"
        style="text-decoration: none"
      >
        <div class="arko">Go to Candidate DashBoard</div>
      </a>
      <p>Footer Content</p>
    </footer>

    <script src="candidate_dashboard.js"></script>
  </body>
</html>
