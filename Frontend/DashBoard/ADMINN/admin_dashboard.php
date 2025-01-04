<?php
// Start the session to access session variables
session_start();

// Retrieve the logged-in recruiter's email from the session
$email = $_SESSION['admin_email'];

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Recruiter Dashboard</title>
    <link rel="icon" href="../../images/favicon.ico"
        type="image/x-icon" />
    <link rel="stylesheet" href="admin_dashboard.css?v=1.0">

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
</header>

    <div class="container">
      <!-- Sidebar -->
      <aside class="sidebar">
        <nav class="sidebar-nav">
          <a href="#dashboard" class="active">
            <img src="../../images/DashBoard Icons/Dashboard.svg" alt="Dashboard" class="nav-icon" /> Dashboard
          </a>
          <a href="#company-profile">
            <img src="../../images/DashBoard Icons/Profile.svg" alt="Company Profile" class="nav-icon" /> Statistics
          </a>
          <div class="dropdown">
            <a href="post-internship-main-section" class="dropdown-toggle">
              <img src="../../images/DashBoard Icons/Internships.svg" alt="Internships" class="nav-icon" /> User Management
            </a>
            <div class="dropdown-content">
              <a href="#post-internship-form">
                <img src="../../images/DashBoard Icons/Post.svg" alt="Post Internship" class="nav-icon" /> Manage Candidates
              </a>
              <a href="#internships">
                <img src="../../images/DashBoard Icons/Status.svg" alt="View Status" class="nav-icon" /> Manage Recruiters
              </a>
            </div>
          </div>
          <a href="#manage-applicants">
            <img src="../../images/DashBoard Icons/Manage Applicants.svg" alt="Manage Applicants" class="nav-icon" /> Manage Applications
          </a>
          <a href="#membership">
            <img src="../../images/DashBoard Icons/membership.svg" alt="Membership" class="nav-icon" /> Membership
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
          <h1>Hey there Admin, <?php echo htmlspecialchars($email); ?>!</h1>
          <div class="user-profile">
              <span class="notification-icon">🔔</span>
              <span class="user-name"><?php echo htmlspecialchars($email); ?></span> <!-- Displaying Email -->
          </div>
</div>
        
      <!-- Dashboard -->
        <section id="dashboard" class="section">
          <div class="content" id="dashboardContent">
         
         <?php
// Include the database connection
include('D:\xampp\htdocs\InternLink\Backend\dbconfig.php'); // Adjust the path according to your project structure

// Start session for any session-related functionality (like error message)
if (session_status() == PHP_SESSION_NONE) {
  session_start();  // Start the session only if it's not already started
}

?>

<section class="stats">
    <div class="stat-card">
        <h2>
            <?php
            // Query to count the total number of internships posted
            $sql_internships = "SELECT COUNT(*) AS total_internships FROM post_internship_form_detail";
            $result_internships = $conn->query($sql_internships);
            if ($result_internships->num_rows > 0) {
                $row_internships = $result_internships->fetch_assoc();
                echo $row_internships['total_internships'];
            } else {
                echo "0"; // If no internships exist
            }
            ?>
        </h2>
        <p>Total Internship Posted</p>
    </div>
    <div class="stat-card">
        <h2>
            <?php
            // Query to count the total number of recruiters
            $sql_recruiters = "SELECT COUNT(*) AS total_recruiters FROM recruiters_signup";
            $result_recruiters = $conn->query($sql_recruiters);
            if ($result_recruiters->num_rows > 0) {
                $row_recruiters = $result_recruiters->fetch_assoc();
                echo $row_recruiters['total_recruiters'];
            } else {
                echo "0"; // If no recruiters exist
            }
            ?>
        </h2>
        <p>Total Recruiters</p>
    </div>
    <div class="stat-card">
        <h2>
            <?php
            // Query to count the total number of candidates
            $sql_candidates = "SELECT COUNT(*) AS total_candidates FROM candidates_signup";
            $result_candidates = $conn->query($sql_candidates);
            if ($result_candidates->num_rows > 0) {
                $row_candidates = $result_candidates->fetch_assoc();
                echo $row_candidates['total_candidates'];
            } else {
                echo "0"; // If no candidates exist
            }
            ?>
        </h2>
        <p>Total Candidates</p>
    </div>
    <div class="stat-card">
        <h2>
          0
        </h2>
        <p>Payment Subscriber</p>
    </div>
</section>

<!--Recent Activities  -->
            <section class="recent-activities">
            <?php
// Include the database connection
include('../../../Backend/dbconfig.php');

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Query to fetch recent internships in descending order
$sql = "SELECT company_name, internship_title, deadline, created_at FROM post_internship_form_detail ORDER BY created_at DESC"; // Assuming there is a 'created_at' column for sorting
$result = $conn->query($sql);
?>

<!-- Recent Applications Section -->
<div class="recent-applications">
    <h3>Recent Internships</h3>

    <?php
   if ($result->num_rows > 0) {
    $counter = 1; // Initialize the counter
    // Loop through the results and display each internship
    while ($row = $result->fetch_assoc()) {
        // Calculate the difference between deadline and created_at
        $created_at = new DateTime($row['created_at']);
        $deadline = new DateTime($row['deadline']);
        $interval = $created_at->diff($deadline);

        // Get the number of days difference
        $days_remaining = $interval->format('%r%a'); // '%r' adds a negative sign if the date has passed

        // Format the message based on days remaining
        if ($days_remaining > 0) {
            $subtractedDateMessage = $days_remaining . " days ";
        } elseif ($days_remaining == 0) {
            $subtractedDateMessage = "Deadline is today";
        } else {
            $subtractedDateMessage = abs($days_remaining) . " days ago (expired)";
        }

        // Print the internship details
        echo '<p>' . $counter . ') ' . $row['company_name'] . ' posted an internship for "' . $row['internship_title'] . '" which ends in ' . $subtractedDateMessage . '.</p>';
        $counter++; // Increment the counter
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


<!-- Company Profile -->
<section id="company-profile" class="section">
    <div class="content">
        <form id="company-profile-form" class="company-profile-form" action="../../../Backend/Recruiter_DashBoard/Post_CompanyProfile.php" method="post" enctype="multipart/form-data">
            <h1>Company Profile</h1>
            <h3>Company Information</h3>
            <div class="form-group">
                <label>Company Name <span class="required">*</span></label>
                <input type="text" name="company_name" placeholder="Enter company name" required value="<?php echo isset($email) ? htmlspecialchars($company_profile['company_name']) : ''; ?>" />
            </div>
            <div class="form-group">
                <label>Industry <span class="required">*</span></label>
                <input type="text" name="industry" placeholder="e.g., Technology, Finance, Web-Development" required value="<?php echo isset($company_profile) ? htmlspecialchars($company_profile['industry']) : ''; ?>" />
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


          <!-- Manage Candidates -->
          <section id="post-internship-form" class="section">
    <div class="content">
        <h2>All Candidates</h2>
        <table class="internship-table">
            <thead>
                <tr>
                    <th>Candidate ID</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Membership</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="internship-list">
                <?php
                include('D:\xampp\htdocs\InternLink\Backend\dbconfig.php');

                // Fetch data from candidate_profiles
                $sql = "SELECT * FROM candidate_profiles";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($row['c_id']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['full_name']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['email']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['phone']) . '</td>';
                        echo '<td>
                            <select class="membership-dropdown">
                                <option value="Basic" selected>Basic</option>
                                <option value="Standard">Standard</option>
                                <option value="Premium">Premium</option>
                            </select>
                          </td>';
                        echo '<td>
                            <button class="delete-btn" onclick="confirmDelete(' . $row['c_id'] . ')">Delete</button>
                          </td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="6">No candidates found</td></tr>';
                }

                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</section>

<script>
    // Two-step confirmation for delete
    function confirmDelete(candidateId) {
        const confirmFirst = confirm("Are you sure you want to delete candidate ID: " + candidateId + "?");
        if (confirmFirst) {
            const confirmSecond = confirm("This action is irreversible. Do you really want to proceed?");
            if (confirmSecond) {
                // Send AJAX request to delete the candidate
                fetch(`delete_candidate.php?c_id=${candidateId}`, {
                    method: 'GET',
                })
                .then(response => response.text())
                .then(data => {
                    alert(data);
                    // Refresh the page or remove the row from the table
                    location.reload();
                })
                .catch(error => console.error('Error:', error));
            }
        }
    }
</script>

          
          <!-- Manage -->
          <section id="internships" class="section">
    <div class="content">
        <h2>All Recruiters</h2>
        <table class="internship-table">
            <thead>
                <tr>
                    <th>Recruiter ID</th>
                    <th>Company Name</th>
                    <th>Industry</th>
                    <th>Contact Person Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Membership</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="internship-list">
                <?php
                include('D:\xampp\htdocs\InternLink\Backend\dbconfig.php');


                $sql = "SELECT * FROM company_profile";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($row['r_id']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['company_name']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['industry']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['contact_person_name']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['contact_email']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['contact_phone_number']) . '</td>';
                        echo '<td>
                            <select class="membership-dropdown">
                                <option value="Basic" selected>Basic</option>
                                <option value="Standard">Standard</option>
                                <option value="Premium">Premium</option>
                            </select>
                          </td>';
                        echo '<td>
                            <button class="delete-btn" onclick="confirmDelete(' . $row['r_id'] . ')">Delete</button>
                          </td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="8">No recruiters found</td></tr>';
                }

                $conn->close();
                ?>  
            </tbody>
        </table>
    </div>
</section>

<script>
    // Two-step confirmation for delete
    function confirmDelete(recruiterId) {
        const confirmFirst = confirm("Are you sure you want to delete recruiter ID: " + recruiterId + "?");
        if (confirmFirst) {
            const confirmSecond = confirm("This action is irreversible. Do you really want to proceed?");
            if (confirmSecond) {
                // Send AJAX request to delete the recruiter
                fetch(`delete_recruiter.php?r_id=${recruiterId}`, {
                    method: 'GET',
                })
                .then(response => response.text())
                .then(data => {
                    alert(data);
                    // Refresh the page to reflect changes
                    location.reload();
                })
                .catch(error => console.error('Error:', error));
            }
        }
    }
</script>





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
        
          <!-- Manage Applicants Section -->
            <section id="manage-applicants" class="section">
              <div class="content">
                <h2>Manage Applicants</h2>
                <table class="applicants-table">
                  <thead>
                    <tr>
                      <th>Applicant Name</th>
                      <th>Position Applied</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>John Doe</td>
                      <td>Software Intern</td>
                      <td>Under Review</td>
                      <td>
                        <button class="action-btn approve">Approve</button>
                        <button class="action-btn reject">Reject</button>
                      </td>
                    </tr>
                    <tr>
                      <td>Jane Smith</td>
                      <td>Data Analyst Intern</td>
                      <td>Interview Scheduled</td>
                      <td>
                        <button class="action-btn approve">Approve</button>
                        <button class="action-btn reject">Reject</button>
                      </td>
                    </tr>
                    <!-- Additional rows as needed -->
                  </tbody>
                </table>
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
          <form class="contact-admin-form">
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
          <button type="submit" class="send-btn">Send Message</button>
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

    <script src="admin_dashboard.js"></script>
  </body>
</html>
