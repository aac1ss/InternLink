<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InternLink - Admin Login</title>
    <link rel="stylesheet" href="login.css"> <!-- Updated path to login.css -->
</head>
<body>
    <!-- Navigation -->
    <header>
        <div class="navigation">
            <div class="logo">
            <img src="../../images/LOGO/PNG/ICON.png" alt="InternLink Logo">
            </div>
            <nav>
                <ul class="nav-links">
                    <li><a href="../../index.html">Home</a></li>
                    <li><a href="../../Internships/internship.php">Internships</a></li>
                    <li><a href="../../company/company.php">Companies</a></li>
                    <li><a href="../../index.html">About Us</a></li>
                </ul>
                <div class="nav-buttons">
                    <a href="../Nav_Login/Login_index.htm"> <button class="login-btn">Login</button></a>                         
                    <a href="../../Register/Nav Register/register_index.htm">  <button class="register-btn"> Register  </button>  </a>  
                    <h1>|</h1>
                    <button class="admin-btn">Admin</button>
                </div>
            </nav>
        </div>
    </header>

    <!-- Admin Login Form -->
    <main>
        <div class="form-container">
            <h2>Admin Login</h2>
            <p>Please login to the Admin panel.</p>

            <!-- Display error message if login failed -->
            <?php
            session_start();
            if (isset($_SESSION['error_message'])) {
                echo "<p style='color: red;'>".$_SESSION['error_message']."</p>";
                unset($_SESSION['error_message']);
            }
            ?>

            <form id="formvalidation" action="../../../Backend/Log_In/admin_login.php" method="post">
                <label for="email">Email*</label>
                <input type="email" id="email" name="email" required>
                
                <label for="password">Password*</label>
                <input type="password" id="password" name="password" required>

                <button type="submit" class="sign-in">Sign In</button>
            </form>
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <div class="footer-logo">
            <img src="../../images/LOGO/LOGO@2x.png" alt="InternLink Logo"> 
                <h3>InternLink</h3>
                <div class="footer-details">
                    <p>Balkumari, Lalitpur</p>
                    <p>+977-9864240733</p>
                    <p>contact@internlink.com</p>
                </div>
            </div>
            <div class="footer-links">
                <div class="footer-column">
                    <h4>About InternLink</h4>
                    <ul>
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Our Services</a></li>
                        <li><a href="#">Our Blogs</a></li>
                        <li><a href="#">Contact Us</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h4>For Candidates</h4>
                    <ul>
                        <li><a href="#">Internships</a></li>
                        <li><a href="#">Dashboard</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h4>For Recruiters</h4>
                    <ul>
                        <li><a href="#">Become a Recruiter</a></li>
                        <li><a href="#">Post Internship</a></li>
                        <li><a href="#">Dashboard</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h4>More</h4>
                    <ul>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms of Use</a></li>
                        <li><a href="#">FAQs</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
