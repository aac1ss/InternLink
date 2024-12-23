<?php
// Start the session to access session variables
session_start();

// Check if the user is logged in, if not redirect to login page
if (!isset($_SESSION['email'])) {
    header("Location: ../../Frontend/Login/recruiter_login.html");
    exit;
}

// Retrieve the logged-in user's email from the session
$email = $_SESSION['email'];
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Recruiter Dashboard</title>
    <link
      rel="stylesheet"
      href="recruiter_dashboard.css"
    />
    <link rel="stylesheet" href="../../Responsive/respo_index.css">
  </head>
  <body>
  <header>
    <div class="recruiter-navigation">
        <!-- Default Logo -->
        <div class="recruiter-logo primary-recruiter-logo">
            <a href="index.html">
                <img src="images/LOGO/LOGO.svg" alt="InternLink Logo">
            </a>
        </div>

        <!-- Secondary Logo for Small Screens -->
        <div class="recruiter-logo secondary-recruiter-logo">
            <a href="index.html">
                <img src="images/LOGO/PNG/ICON - Copy.png" alt="InternLink Small Logo">
            </a>
        </div>

        <!-- Hamburger Menu -->
        <div class="recruiter-hamburger">
            <span></span>
            <span></span>
            <span></span>
        </div>

        <nav>
            <ul class="recruiter-nav-links">
                <li><a href="index.html">Home</a></li>
                <li><a href="Internships/internships.php">Internships</a></li>
                <li><a href="#about-us">About Us</a></li>
            </ul>
            <div class="recruiter-nav-buttons">
                <a href="Login/Nav_Login/Login_index.htm">
                    <button class="recruiter-login-btn">Login</button>
                </a>
            </div>
        </nav>
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
          <a href="#logout">
            <img src="../../images/DashBoard Icons/Log Out.svg" alt="Logout" class="nav-icon" /> Logout
          </a>
        </div>
      </aside>
      

    <!-- Main Content -->
    <main class="main-content">
      <header class="top-bar">
          <h1>Hey there, <?php echo htmlspecialchars($email); ?>!</h1>
          <div class="user-profile">
              <span class="notification-icon">🔔</span>
              <span class="user-name"><?php echo htmlspecialchars($email); ?></span> <!-- Displaying Email -->
          </div>
      </header>
        
      <!-- Dashboard -->
        <section id="dashboard" class="section">
          <div class="content" id="dashboardContent">
            <section class="stats">
                <div class="stat-card">
                    <h2>0</h2>
                    <p>Applied</p>
                </div>
                <div class="stat-card">
                    <h2>55</h2>
                    <p>Alerts</p>
                </div>
                <div class="stat-card">
                    <h2>0</h2>
                    <p>Rejected</p>
                </div>
                <div class="stat-card">
                    <h2>0</h2>
                    <p>Bookmarks</p>
                </div>
            </section>
            <section class="recent-activities">
                <div class="recent-applications">
                    <h3>Internship Applied Recently</h3>
                    <p>No recent applications</p>
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
            <form class="company-profile-form">
              <h1>Company Profile</h1>
              <h3>Company Information</h3>
              <div class="form-group">
                <label>Company Name <span class="required">*</span></label>
                <input type="text" placeholder="Enter company name" required />
              </div>
              <div class="form-group">
                <label>Industry <span class="required">*</span></label>
                <input
                  type="text"
                  placeholder="e.g., Technology, Finance, Web-Development"
                  required
                />
              </div>
              <div class="form-group">
                <label>Company Size <span class="required">*</span></label>
                <select>
                  <option>1-10 Employees</option>
                  <option>11-50 Employees</option>
                  <option>51-200 Employees</option>
                  <option>201-500 Employees</option>
                  <option>500+ Employees</option>
                </select>
              </div>
              <div class="form-group">
                <label>Company Website</label>
                <input type="url" placeholder="e.g., www.internlink.com" />
              </div>
              <div class="form-group">
                <label>Company Description*</label>
                <textarea
                  placeholder="Write a brief description..."
                  required
                ></textarea>
              </div>

              <h3>Contact Information</h3>
              <div class="form-group">
                <label>Contact Person Name <span class="required">*</span></label>
                <input type="text" placeholder="Enter contact person's name" />
              </div>
              <div class="form-group">
                <label>Contact Position <span class="required">*</span></label>
                <input type="text" placeholder="e.g., HR Manager" />
              </div>
              <div class="form-group">
                <label>Contact Email <span class="required">*</span></label>
                <input type="email" placeholder="Enter contact email" />
              </div>
              <div class="form-group">
                <label>Contact Phone Number <span class="required">*</span></label>
                <input type="tel" placeholder="e.g., (977) 9869696969" />
              </div>
              <div class="form-group">
                <label>Office Address <span class="required">*</span></label>
                <input type="text" placeholder="Enter office address" />
              </div>

              <h3>Social Links</h3>
              <div class="form-group">
                <label>LinkedIn Profile</label>
                <input type="url" placeholder="LinkedIn URL" />
              </div>
              <div class="form-group">
                <label>Twitter Handle</label>
                <input type="text" placeholder="Twitter handle" />
              </div>
              <div class="form-group">
                <label>Facebook Page</label>
                <input type="url" placeholder="Facebook URL" />
              </div>
              <div class="form-group">
                <label>Other</label>
                <input type="url" placeholder="Other social link" />
              </div>

              <h3>Documents</h3>
              <div class="form-group">
                <label>Upload Company Logo <span class="required">*</span></label>
                <input type="file" />
              </div>
              <div class="form-group">
                <label>Upload Registration Document <span class="required">*</span></label>
                <input type="file" />
              </div>

              <button type="submit" class="save-btn">Save</button>
            </form>
          </div>
        </section>

          <!-- Post Internships -->
          <section id="post-internship-form" class="post-internship-container section">
            <div>
              <h1>Post an Internship</h1>
              <form action="../../../Backend/Recruiter_DashBoard/Post_Internship.php" method="post" class="internship-post-form">
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
                    <input type="text" id="location" name="location" placeholder="e.g., Jhamsikhel, Balkumamri, etc." required />
                  </div>
                  <div class="form-group">
                    <label for="duration">Duration: <span class="required">*</span></label>
                    <input type="text" id="duration" name="duration" placeholder="e.g., 3 months" required />
                  </div>
                  <div class="form-group">
                    <label>Type: <span class="required">*</span></label>
                    <div class="type-toggle">
                      <button type="button" id="type-remote" class="type-toggle-btn active" onclick="setType('remote')">Remote</button>
                      <button type="button" id="type-hybrid" class="type-toggle-btn" onclick="setType('hybrid')">Hybrid</button>
                      <button type="button" id="type-onsite" class="type-toggle-btn" onclick="setType('onsite')">Onsite</button>
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
                    <input type="text" id="stipend-amount" name="stipend_amount" placeholder="e.g., Rs 5000 / Month" />
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
                </div>
                 <!-- Application Process -->
                <div class="section application-process">
                    <h2>Application Process</h2>
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
                    <th>Status</th>
                    <th>Posted Date</th>
                    <th>Deadline</th>
                    <th>Applications</th>
                    <th>Duration</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Dynamic content will be populated here -->
            </tbody>
        </table>
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

    <script src="recruiter_dashboard.js"></script>
  </body>
</html>
