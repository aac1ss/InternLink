<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer</title>
    <link rel="stylesheet" href="/InternLink/Frontend/Responsive/respo_nav_footer.css">
<style> 
    :root {
    --primary-color: #59CBE8; /* Main accent color */
    --secondary-color: #141E30; /* Background color for header and footer */
    --text-color: #fff; /* Text color */
    --bg-color: #f4f4f4; /* Background color for body and sections */
    --border-color: #00b3ff; /* Border color for buttons */
    }
footer {
    background-color: var(--secondary-color);
    padding: 40px 20px;
    color: var(--text-color);
}

.footer-content {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    max-width: 1200px;
    margin: 0 auto;
    gap: 40px; /* Uniform gap between columns */
}

.footer-column {
    text-align: left;
}

.footer-logo img {
    max-width: 250px;
}

.footer-column h3 {
    color: var(--primary-color);
    font-size: 18px;
    margin-bottom: 10px;
}

.footer-column ul {
    list-style-type: none;
}

.footer-column ul li {
    margin-bottom: 8px;
}

.footer-column ul li a {
    text-decoration: none;
    color: var(--text-color);
    font-size: 14px;
}

.footer-column ul li a:hover {
    color: var(--primary-color);
}

.fsocial-icons {
    display: flex;
    gap: 20px;
}

.fsocial-icons a {
    color: var(--text-color);
}

.fsocial-icons a i {
    font-size: 24px;
    transition: all 0.3s ease;
}

.fsocial-icons a:hover i {
    color: var(--primary-color);
}

/* Separator line */
.footer-separator {
    margin-top: 20px;
    border: 0;
    border-top: 1px solid var(--text-color);
}

/* Footer bottom part with equal spacing */
.footer-bottom {
    display: flex;
    justify-content: space-between;
    align-items: center;
    max-width: 1200px;
    margin: 20px auto 0;
    font-size: 14px;
    padding: 10px 0;
}

/* Left side for Privacy Policy */
.footer-left {
    flex: 1;
    text-align: left;
}

.footer-left a {
    text-decoration: none;
    color: #a6a6a6;
}

.footer-left a:hover {
    color: var(--text-color);
}

/* Centered part for © 2024 internlink */
.footer-center {
    flex: 1;
    text-align: center;
}

.footer-center p {
    margin: 0;
    color: var(--text-color);
}

/* Right side for User Agreement */
.footer-right {
    flex: 1;
    text-align: right;
}

.footer-right a {
    text-decoration: none;
    color: #a6a6a6;
}

.footer-right a:hover {
    color: var(--text-color);
}
</style>

</head>
<body>
    <footer>
        <!-- Logo Section -->
        <div class="footer-content">
           <a href="index.php">
               <div class="footer-column footer-logo">
               <img src="/INTERNLINK/Frontend/images/LOGO/LOGO@2x.png" alt="internlink Logo">
                </div>
           </a> 
            <!-- For Candidates -->
            <div class="footer-column">
                <h3>For Candidates</h3>
                <ul>
                    <li><a href="/InternLink/Frontend/Internships/internships.php">Internships</a></li>
                    <li><a href="/InternLink/Frontend/company/company.php">Companies</a></li>
                </ul>
            </div>
            <!-- For Recruiters -->
            <div class="footer-column">
                <h3>For Recruiters</h3>
                <ul>
                    <li><a href="/InternLink/Frontend/Login/Sub_Logins/recruiter_login.html">Become a Recruiter</a></li>
                    <li><a href="/InternLink/Frontend/Login/Sub_Logins/recruiter_login.html">Post Internship</a></li>
                    <li><a href="/InternLink/Frontend/Login/Sub_Logins/recruiter_login.html">Dashboard</a></li>
                </ul>
            </div>
            <!-- Company -->
            <div class="footer-column" id="foot-left">
                <h3>InternLink</h3>
                <ul>
                    <li><a href="/InternLink/Frontend/index.html">About Us</a></li>
                    <li><a href="#">Join Us</a></li>
                    <li><a href="#">Contact Us</a></li>
                </ul>
            </div>
            <!-- Social Media Icons -->
            <div class="footer-column fsocial-icons">
                <a href="http://www.twitter.com/" target="_blank">
                    <i class="fa-brands fa-x-twitter fa-2x"></i>
                </a>
                <a href="http://www.linkedin.com/" target="_blank">
                    <i class="fa-brands fa-linkedin fa-2x"></i>
                </a>
                <a href="http://www.instagram.com/" target="_blank">
                    <i class="fa-brands fa-instagram fa-2x"></i>
                </a>
            </div>
        </div>
        <hr class="footer-separator">
        <div class="footer-bottom">
            <div class="footer-left">
                <a href="#">Privacy Policy</a>
            </div>
            <div class="footer-center">
                <p>&copy; 2024 internlink</p>
            </div>
            <div class="footer-right">
                <a href="#">User Agreement</a>
            </div>
        </div>
    </footer>
    
</body>
</html>