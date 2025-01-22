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
          <!-- <a href="#manage-applicants">
            <img src="../../images/DashBoard Icons/Manage Applicants.svg" alt="Manage Applicants" class="nav-icon" /> Manage Applications
          </a> -->
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
        <h2>Stipend Distribution</h2>

        <?php
        // Database connection
        include('D:\xampp\htdocs\InternLink\Backend\dbconfig.php');

        // Fetch stipend data from the table
        $query = "SELECT stipend_amount FROM post_internship_form_detail";
        $result = mysqli_query($conn, $query);

        // Initialize an array to hold stipend amounts
        $stipends = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $stipends[] = $row['stipend_amount'];
        }

        // Calculate the total stipend sum
        $totalStipend = array_sum($stipends);

        // Categorize the stipend amounts
        $below5k = 0;
        $between5k15k = 0;
        $above15k = 0;

        foreach ($stipends as $stipend) {
            if ($stipend < 5000) {
                $below5k++;
            } elseif ($stipend >= 5000 && $stipend <= 15000) {
                $between5k15k++;
            } else {
                $above15k++;
            }
        }

        // Calculate the percentages for each category
        $below5kPercent = ($below5k / count($stipends)) * 100;
        $between5k15kPercent = ($between5k15k / count($stipends)) * 100;
        $above15kPercent = ($above15k / count($stipends)) * 100;
        ?>

        <div class="card">
            <div class="chart-container">
                <div id="pieChart" class="pie-chart">
                    <div class="label">
                        <span>Stipend</span>
                    </div>
                </div>
            </div>

            <div class="legend">
                <ul id="salary-legend">
                    <!-- Dynamic legend will be populated here -->
                </ul>
            </div>
        </div>

        <script>
            // Dynamic stipend categories data (from PHP)
            const stipendData = [
                { range: 'Below 5k', percentage: <?php echo $below5kPercent; ?>, color: '#4caf50' },
                { range: '5k - 15k', percentage: <?php echo $between5k15kPercent; ?>, color: '#ff9800' },
                { range: 'Above 15k', percentage: <?php echo $above15kPercent; ?>, color: '#f44336' }
            ];

            // Function to update the chart dynamically
            function updateChart(data) {
                let gradientString = '';
                let cumulativePercentage = 0;

                data.forEach(item => {
                    gradientString += `${item.color} ${cumulativePercentage}% ${cumulativePercentage + item.percentage}%, `;
                    cumulativePercentage += item.percentage;
                });

                gradientString = gradientString.slice(0, -2);
                document.getElementById('pieChart').style.background = `conic-gradient(${gradientString})`;

                const legend = document.getElementById('salary-legend');
                data.forEach(item => {
                    const li = document.createElement('li');
                    li.innerHTML = `<span style="color: ${item.color};">&#8226;</span> ${item.range} (${item.percentage.toFixed(2)}%)`;
                    legend.appendChild(li);
                });
            }

            // Update the chart with the stipend data
            updateChart(stipendData);
        </script>

    </div>
</section>


        <!-- Manage Candidates Section (UPDATED) -->
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
                        <tbody>
                            <?php
                            include('D:\xampp\htdocs\InternLink\Backend\dbconfig.php');
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
                                        <button class="delete-btn" onclick="confirmCandidateDelete(' . $row['c_id'] . ')">Delete</button>
                                      </td>';
                                    echo '</tr>';
                                }
                            }
                            $conn->close();
                            ?>
                        </tbody>
                    </table>
                </div>
    </section>

        <!-- Manage Recruiters Section (UPDATED) -->
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
                        <tbody>
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
                                        <button class="delete-btn" onclick="confirmRecruiterDelete(' . $row['r_id'] . ')">Delete</button>
                                      </td>';
                                    echo '</tr>';
                                }
                            }
                            $conn->close();
                            ?>  
                        </tbody>
                    </table>
                </div>
      </section>


      <script>
                // Candidate deletion
                function confirmCandidateDelete(candidateId) {
                    if (confirm("Are you sure you want to delete candidate ID: " + candidateId + "?")) {
                        if (confirm("This action is permanent! Confirm deletion:")) {
                            fetch(`delete_candidate.php?c_id=${candidateId}`)
                            .then(response => response.text())
                            .then(data => {
                                alert(data);
                                location.reload();
                            });
                        }
                    }
                }

                // Recruiter deletion
                function confirmRecruiterDelete(recruiterId) {
                    if (confirm("Are you sure you want to delete recruiter ID: " + recruiterId + "?")) {
                        if (confirm("This action is permanent! Confirm deletion:")) {
                            fetch(`delete_recruiter.php?r_id=${recruiterId}`)
                            .then(response => response.text())
                            .then(data => {
                                alert(data);
                                location.reload();
                            });
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
      </main>
    </div>

    <!-- Dummy Footer -->
    <footer >
      <?php include 'D:\xampp\htdocs\InternLink\Frontend\footer.php' ?>
    </footer>

    <script src="admin_dashboard.js"></script>
  </body>
</html>
