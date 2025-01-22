<?php
// Start the session to access session variables
session_start();

// Check if the user is logged in, if not redirect to login page
if (!isset($_SESSION['recruiter_email'])) {
    header("Location: ../../Frontend/Login/Sub_Logins/recruiter_login.html");
    exit;
}

// Retrieve the logged-in recruiter's email from the session
$email = $_SESSION['recruiter_email'];
$recruiter_id = $_SESSION['r_id'];

// Include the database configuration file
include('../../../Backend/dbconfig.php');

// Query to fetch the recruiter's company profile details, including the logo
$query = "SELECT r_id, company_logo FROM company_profile WHERE contact_email = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$recruiter = mysqli_fetch_assoc($result);

// Check if the recruiter details were found
if ($recruiter) {
    $r_id = $recruiter['r_id'];
    // Use the company logo from the database or default if not found
    $company_logo = $recruiter['company_logo'] ? '../../../Backend/uploads/' . $recruiter['company_logo'] : '../../images/default-profile.png';
} else {
    $company_logo = '../../images/default-profile.png';
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Recruiter Dashboard</title>
    <link rel="icon" href="../../images/favicon.ico"
        type="image/x-icon" />
    <link rel="stylesheet" href="recruiter_dashboard.css?v=1.0">

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
            <li><a href="../../Internships/internships.php">Internships</a></li>
        </ul>

        <!-- Profile Picture -->
        <div class="recruiter-dashboard-actions">
            <div class="recruiter-profile">
                <img src="<?php echo $company_logo; ?>" alt="Profile Picture" class="profile-pic">
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
            <img src="../../images/DashBoard Icons/Profile.svg" alt="Company Profile" class="nav-icon" /> Company Profile
          </a>
          <div class="dropdown">
            <a href="post-internship-main-section" class="dropdown-toggle">
              <img src="../../images/DashBoard Icons/Internships.svg" alt="Internships" class="nav-icon" /> Internships
            </a>
            <div class="dropdown-content">
              <a href="#post-internship-form">
                <img src="../../images/DashBoard Icons/Post.svg" alt="Post Internship" class="nav-icon" /> Post Internship
              </a>
              <a href="#internships">
                <img src="../../images/DashBoard Icons/Status.svg" alt="View Status" class="nav-icon" /> View Status
              </a>
            </div>
          </div>
          <a href="#manage-applicants">
            <img src="../../images/DashBoard Icons/Manage Applicants.svg" alt="Manage Applicants" class="nav-icon" /> Manage Applicants
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
        <a href="/InternLink/Backend/Recruiter_DashBoard/logout.php">
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
        
      <!-- Dashboard -->
  <section id="dashboard" class="section">
    <div class="content" id="dashboardContent">
        <?php
        // Include database connection
        include('../../../Backend/dbconfig.php');

        // Get the recruiter ID from the session
        $recruiter_id = $_SESSION['r_id'];

        // Query to fetch total internships posted by the recruiter
        $query_total_posted = "SELECT COUNT(*) AS total_posted FROM post_internship_form_detail WHERE r_id = ?";
        $stmt_total_posted = $conn->prepare($query_total_posted);
        $stmt_total_posted->bind_param('i', $recruiter_id);
        $stmt_total_posted->execute();
        $result_total_posted = $stmt_total_posted->get_result()->fetch_assoc();
        $total_posted = $result_total_posted['total_posted'] ?? 0;

        // Query to fetch total applicants for the recruiter's internships
        $query_total_applicants = "
            SELECT COUNT(*) AS total_applicants 
            FROM internship_applications ia
            INNER JOIN post_internship_form_detail p ON ia.internship_id = p.internship_id
            WHERE p.r_id = ?
        ";
        $stmt_total_applicants = $conn->prepare($query_total_applicants);
        $stmt_total_applicants->bind_param('i', $recruiter_id);
        $stmt_total_applicants->execute();
        $result_total_applicants = $stmt_total_applicants->get_result()->fetch_assoc();
        $total_applicants = $result_total_applicants['total_applicants'] ?? 0;

        // Query to fetch total rejected applicants
        $query_total_rejected = "
            SELECT COUNT(*) AS total_rejected 
            FROM internship_applications ia
            INNER JOIN post_internship_form_detail p ON ia.internship_id = p.internship_id
            WHERE p.r_id = ? AND ia.status = 'rejected'
        ";
        $stmt_total_rejected = $conn->prepare($query_total_rejected);
        $stmt_total_rejected->bind_param('i', $recruiter_id);
        $stmt_total_rejected->execute();
        $result_total_rejected = $stmt_total_rejected->get_result()->fetch_assoc();
        $total_rejected = $result_total_rejected['total_rejected'] ?? 0;
        ?>

        <!-- Statistics Section -->
        <section class="stats">
            <div class="stat-card">
                <h2><?php echo $total_posted; ?></h2>
                <p>Total Internship Posted</p>
            </div>
            <div class="stat-card">
                <h2><?php echo $total_applicants; ?></h2>
                <p>Total Applicants</p>
            </div>
            <div class="stat-card">
                <h2><?php echo $total_rejected; ?></h2>
                <p>Rejected</p>
            </div>
        </section>

        <section class="recent-activities">
    <div class="recent-applications">
        <h3>Recent Internships</h3>
        <?php
        // Query to fetch recent internships posted by the recruiter
        $query_recent_internships = "
            SELECT company_name, internship_title, deadline, created_at 
            FROM post_internship_form_detail 
            WHERE r_id = ? 
            ORDER BY created_at DESC 
            LIMIT 5
        ";
        $stmt_recent_internships = $conn->prepare($query_recent_internships);
        $stmt_recent_internships->bind_param('i', $recruiter_id);
        $stmt_recent_internships->execute();
        $result_recent_internships = $stmt_recent_internships->get_result();

        if ($result_recent_internships->num_rows > 0) {
            $counter = 1;
            while ($row = $result_recent_internships->fetch_assoc()) {
                $created_at = new DateTime($row['created_at']);
                $deadline = new DateTime($row['deadline']);
                $interval = $created_at->diff($deadline);
                $days_remaining = $interval->format('%r%a'); // Calculate days remaining

                if ($days_remaining > 0) {
                    $subtractedDateMessage = $days_remaining . " days remaining";
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
            echo '<p>No recent internships posted</p>';
        }
        ?>
    </div>
    <div class="recent-details">
        <h3 onclick="toggleApplicantList()" class="dropdown-header">
            Recent Applicants ▼
        </h3>
        <div class="applicant-list" id="applicant-list">
            <?php
            // Query to fetch recent applicants for the recruiter's internships
            $query_recent_applicants = "
                SELECT ia.application_id, ia.c_id, ia.internship_title, cp.full_name 
                FROM internship_applications ia
                INNER JOIN post_internship_form_detail p ON ia.internship_id = p.internship_id
                INNER JOIN candidate_profiles cp ON ia.c_id = cp.c_id
                WHERE p.r_id = ?
                ORDER BY ia.application_date DESC
                LIMIT 5
            ";
            $stmt_recent_applicants = $conn->prepare($query_recent_applicants);
            $stmt_recent_applicants->bind_param('i', $recruiter_id);
            $stmt_recent_applicants->execute();
            $result_recent_applicants = $stmt_recent_applicants->get_result();

            if ($result_recent_applicants->num_rows > 0) {
                $counter = 1; // Initialize counter for numbering
                while ($row = $result_recent_applicants->fetch_assoc()) {
                    // Display the applicant's details
                    echo '<p>' . $counter . ') 📋 ' . $row['full_name'] . ' applied for ' . $row['internship_title'] . '.</p>';
                    $counter++; // Increment counter
                }
            } else {
                echo '<p>No recent applicants</p>';
            }
            ?>
        </div>
    </div>
    </section>
    </div>
  </section>


<!-- Company Profile -->
<section id="company-profile" class="section">
    <div class="content">
        <form id="company-profile-form" class="company-profile-form" action="../../../Backend/Recruiter_DashBoard/Post_CompanyProfile.php" method="post" enctype="multipart/form-data">
            <h1>Company Profile</h1>
            <a href="edit-profile.php" style="text-decoration:none;"><h4  id="edit-p">View Profile</h4> </a>
            <h3>Company Information</h3>
            <div class="form-group">
                <label>Company Name <span class="required">*</span></label>
                <input type="text" name="company_name" placeholder="Enter company name" required value="<?php echo isset($company_profile) ? htmlspecialchars($company_profile['company_name']) : ''; ?>" pattern="[A-Za-z\s]+" title="Only letters and spaces allowed" />
            </div>
            <div class="form-group">
                <label>Industry <span class="required">*</span></label>
                <input type="text" name="industry" placeholder="e.g., Technology, Finance, Web-Development" required value="<?php echo isset($company_profile) ? htmlspecialchars($company_profile['industry']) : ''; ?>" pattern="[A-Za-z\s]+" title="Only letters and spaces allowed" />
            </div>
            <div class="form-group">
                <label>Company Size <span class="required">*</span></label>
                <select name="company_size">
                    <option <?php echo (isset($company_profile) && $company_profile['company_size'] == '1-10 Employees') ? 'selected' : ''; ?>>1-10 Employees</option>
                    <option <?php echo (isset($company_profile) && $company_profile['company_size'] == '11-50 Employees') ? 'selected' : ''; ?>>11-50 Employees</option>
                    <option <?php echo (isset($company_profile) && $company_profile['company_size'] == '51-200 Employees') ? 'selected' : ''; ?>>51-200 Employees</option>
                    <option <?php echo (isset($company_profile) && $company_profile['company_size'] == '201-500 Employees') ? 'selected' : ''; ?>>201-500 Employees</option>
                    <option <?php echo (isset($company_profile) && $company_profile['company_size'] == '500+ Employees') ? 'selected' : ''; ?>>500+ Employees</option>
                </select>
            </div>
            <div class="form-group">
                <label>Company Website</label>
                <input type="url" name="company_website" placeholder="e.g., www.internlink.com" value="<?php echo isset($company_profile) ? htmlspecialchars($company_profile['company_website']) : ''; ?>" />
            </div>
            <div class="form-group">
                <label>Company Description*</label>
                <textarea name="company_description" placeholder="Write a brief description..." required><?php echo isset($company_profile) ? htmlspecialchars($company_profile['company_description']) : ''; ?></textarea>
            </div>

            <h3>Contact Information</h3>
            <div class="form-group">
                <label>Contact Person Name <span class="required">*</span></label>
                <input type="text" name="contact_person_name" placeholder="Enter contact person's name" value="<?php echo isset($company_profile) ? htmlspecialchars($company_profile['contact_person_name']) : ''; ?>" />
            </div>
            <div class="form-group">
                <label>Contact Position <span class="required">*</span></label>
                <input type="text" name="contact_position" placeholder="e.g., HR Manager" value="<?php echo isset($company_profile) ? htmlspecialchars($company_profile['contact_position']) : ''; ?>" />
            </div>
            <div class="form-group">
                <label>Contact Email <span class="required">*</span></label>
                <input type="email" name="contact_email" placeholder="Enter contact email" value="<?php echo isset($company_profile) ? htmlspecialchars($company_profile['contact_email']) : ''; ?>" />
            </div>
            <div class="form-group">
                <label>Contact Phone Number <span class="required">*</span></label>
                <input type="tel" name="contact_phone" placeholder="e.g., (977) 9869696969" value="<?php echo isset($company_profile) ? htmlspecialchars($company_profile['contact_phone_number']) : ''; ?>" />
            </div>
            <div class="form-group">
                <label>Office Address <span class="required">*</span></label>
                <input type="text" name="office_address" placeholder="Enter office address" value="<?php echo isset($company_profile) ? htmlspecialchars($company_profile['office_address']) : ''; ?>" />
            </div>

            <h3>Social Media Links</h3>
            <div class="form-group">
                <label>LinkedIn Profile</label>
                <input type="url" name="linkedin_profile" placeholder="e.g., www.linkedin.com/company/internlink" value="<?php echo isset($company_profile) ? htmlspecialchars($company_profile['linkedin_profile']) : ''; ?>" />
            </div>
            <div class="form-group">
                <label>Twitter Handle</label>
                <input type="text" name="twitter_handle" placeholder="e.g., @internlink" value="<?php echo isset($company_profile) ? htmlspecialchars($company_profile['twitter_handle']) : ''; ?>" />
            </div>
            <div class="form-group">
                <label>Facebook Page</label>
                <input type="text" name="facebook_page" placeholder="e.g., www.facebook.com/internlink" value="<?php echo isset($company_profile) ? htmlspecialchars($company_profile['facebook_page']) : ''; ?>" />
            </div>
            <div class="form-group">
                <label>Other Social Link</label>
                <input type="text" name="other_social_link" placeholder="Other social media link" value="<?php echo isset($company_profile) ? htmlspecialchars($company_profile['other_social_link']) : ''; ?>" />
            </div>

            <h3>Uploads</h3>
            <div class="form-group">
                <label>Company Logo</label>
                <input type="file" name="company_logo" />
                <?php if (isset($company_profile) && $company_profile['company_logo']) { ?>
                    <p>Current Logo: <img src="../uploads/<?php echo htmlspecialchars($company_profile['company_logo']); ?>" alt="Logo" width="100" /></p>
                <?php } ?>
            </div>
            <div class="form-group">
                <label>Registration Document</label>
                <input type="file" name="registration_document" />
                <?php if (isset($company_profile) && $company_profile['registration_document']) { ?>
                    <p>Current Document: <a href="../uploads/<?php echo htmlspecialchars($company_profile['registration_document']); ?>" target="_blank">View Document</a></p>
                <?php } ?>
            </div>

            <button type="submit" class="save-btn">Save Profile</button>
        </form>
    </div>
</section>


            <!-- Post Internships -->
  <section id="post-internship-form" class="post-internship-container section">
              <div>
                <h1>Post an Internship</h1>
                <form action="../../../Backend/Recruiter_DashBoard/Post_Internship.php" method="POST"  class="internship-post-form ">
                  <!-- Internship Information -->
                  <div class="internship-details">
                    <h2>Internship Information</h2>
                    <div class="form-group">
                      <label for="internship-title">Title: <span class="required">*</span></label>
                      <input type="text" id="internship-title" name="internship_title" placeholder="e.g., Java Developer" required />
                    </div>
                    <div class="form-group">
                      <label for="company-name">Company Name: <span class="required">*</span></label>
                      <input type="text" id="company-name" name="company_name" placeholder="e.g., InternLink" required />
                    </div>
                    <div class="form-group">
                      <label for="location">Location: <span class="required">*</span></label>
                      <input type="text" id="location" name="location" placeholder="e.g., Jhamsikhel, Balkuma ri, etc." required />
                    </div>
                    <div class="form-group">
                      <label for="duration">Duration: <span class="required">*</span></label>
                      <input type="number" id="duration" name="duration" placeholder="e.g., 3 months" required />
                    </div>
                    <div class="form-group">
                      <label>Type: <span class="required">*</span></label>
                      <div class="type-toggle">
                        <button type="button" id="type-remote" class="type-toggle-btn active" onclick="setType('Remote')">Remote</button>
                        <button type="button" id="type-hybrid" class="type-toggle-btn" onclick="setType('Hybrid')">Hybrid</button>
                        <button type="button" id="type-onsite" class="type-toggle-btn" onclick="setType('Onsite')">Onsite</button>
                      </div>
                      <input type="hidden" id="type-hidden-input" name="type" value="remote" />
                    </div>
                    <div class="form-group stipend-group">
                      <label>Stipend: <span class="required">*</span></label>
                      <div class="stipend-toggle">
                        <button type="button" id="btn-paid" class="toggle-btn" onclick="toggleStipendField('paid')">Paid</button>
                        <button type="button" id="btn-unpaid" class="toggle-btn active" onclick="toggleStipendField('unpaid')">Unpaid</button>
                      </div>
                    </div>
                    <div id="stipend-amount-container" class="form-group" style="display: none;">
                      <label for="stipend-amount">Stipend Amount: <span class="required">*</span></label>
                      <input type="number" id="stipend-amount" name="stipend_amount" placeholder="e.g., Rs 5000 / Month" />
                    </div>
                  </div>
                  <!-- Requirements -->
                  <div class="internship-requirements">
                    <h2>Requirements</h2>
                    <div class="form-group">
                      <label for="job-description">Job Description: <span class="required">*</span></label>
                      <textarea id="job-description" name="job_description" rows="4" placeholder="e.g., Proficiency in Java, SpringBoot,Jpa,Java-8,Leadership ,Good Communication Skills, etc."required></textarea>
                    </div>
                    <div class="form-group">
                      <label for="responsibility">Responsibilities:</label>
                      <textarea id="responsibility" name="responsibility" rows="4" placeholder="List responsibilities"></textarea>
                    </div>
                    <div class="form-group">
                      <label for="requirements">Requirements:</label>
                      <textarea id="requirements" name="requirements" rows="4" placeholder="List qualifications or prerequisites"></textarea>
                      </div>
                      <div class="form-group">
                      <label for="skills">Skills:</label>
                      <textarea id="skills" name="skills" rows="4" placeholder="List required skills"></textarea>
                      </div>
                    <div class="form-group">
                      <label for="perks">Perks:</label>
                      <textarea id="perks" name="perks" rows="4" placeholder="List any perks or benefits"></textarea>
                    </div>
                    <div class="form-group">
                      <label for="additional-info">Additional Information:</label>
                      <textarea id="additional-info" name="additional_info" rows="4" placeholder="Add any other details"></textarea>
                    </div>
                  </div>
                  <!-- Submit Button -->
                  <div class="form-group">
                    <button type="submit" class="submit-btn">Post Internship</button>
                  </div>
                </form>
              </div>
  </section>
          
          <!-- View Status -->
<section id="internships" class="section">
    <div class="content">
        <h2>Your Posted Internships</h2>
        <table class="internship-table">
            <thead>
                <tr>
                    <th>Internship ID</th>
                    <th>Position</th>
                    <th>Posted Date</th>
                    <th>Deadline</th>
                    <th>Applications</th>
                    <th>Duration</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="internship-list">
                <!-- Dynamic content will be populated here -->
            </tbody>
        </table>
    </div>
</section>

<!-- Setting -->
<section id="setting" class="section">
    <div class="content">
        <h2>Settings</h2>
        <form class="settings-form" action="../../../Backend/Recruiter_DashBoard/update_password.php" method="POST">
            <?php
            // Include database connection
            include('../../../Backend/dbconfig.php');

            // Get the recruiter ID from the session
            $recruiter_id = $_SESSION['r_id'];

            // Fetch the recruiter's email from the database
            $query = "SELECT r_email FROM recruiters_signup WHERE r_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('i', $recruiter_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $recruiter = $result->fetch_assoc();
            $recruiter_email = $recruiter['r_email'];
            ?>

            <div class="form-group">
                <label>Account Email</label>
                <input type="email" value="<?php echo htmlspecialchars($recruiter_email); ?>" placeholder="Enter your email" readonly />
                <small class="email-note">*Email cannot be changed</small>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="new_password" placeholder="Enter new password" required />
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" placeholder="Confirm new password" required />
            </div>
            <button type="submit" class="send-btn">Save Changes</button>
        </form>
    </div>
</section>
        
          <!-- Manage Applicants Section -->
<section id="manage-applicants" class="section">
    <div class="content">
        <h2>Manage Applicants</h2>
        <div id="dropdown-container">
            <!-- Dynamically populated dropdowns will go here -->
        </div>
    </div>
</section>

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

          <!-- Contact Us [Admin] Section -->
         <section id="contact-us" class="section">
    <div class="content">
        <form class="contact-admin-form" action="../../../Backend/Candidate_DashBoard/contact_adminRecruiter.php" method="post">
            <h1>Contact Admin</h1>
            <h3>Get in Touch</h3>
            <div class="form-group">
                <label for="subject">Subject*</label>
                <input type="text" id="subject" name="subject" placeholder="Enter subject" required />
            </div>
            <div class="form-group">
                <label for="message">Message*</label>
                <textarea id="message" name="message" placeholder="Write your message here..." required></textarea>
            </div>
            <h3>Your Contact Information</h3>
            <div class="form-group">
                <label for="admin-contact-name">Your Name*</label>
                <input type="text" id="admin-contact-name" name="admin_contact_name" placeholder="Enter your name" required />
            </div>
            <div class="form-group">
                <label for="admin-contact-email">Your Email*</label>
                <input type="email" id="admin-contact-email" name="admin_contact_email" placeholder="Enter your email" required />
            </div>
            <button type="submit" class="send-btn">Send Message</button>
        </form>
    </div>
</section>




      </main>
    </div>

    <!-- Footer -->
   <?php  include('D:\xampp\htdocs\InternLink\Frontend\footer.php'); ?>

    <script src="recruiter_dashboard.js"></script>
  </body>
</html>
