<?php
// Include database configuration
include '../../Backend/dbconfig.php';

// Query to fetch company details
$query = "SELECT * FROM company_profile";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query Failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Partner Companies</title>
    <link rel="icon" type="image/x-icon" href="../images/favicon.ico">
    <link rel="stylesheet" href="company.css">
    <link rel="stylesheet" href="Responsive/respo_nav_footer.css">
    <link rel="stylesheet" href="Responsive/respo_index.css">
</head>
<body>

<header>
        <div class="navigation">
            <!-- Default Logo -->
            <div class="logo primary-logo">
                <a href="index.html">
                    <img src="../images/LOGO/LOGO.svg" alt="InternLink Logo">
                </a>
            </div>
            
            <!-- Secondary Logo for Small Screens -->
            <div class="logo secondary-logo">
                <a href="index.html">
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
                    <li><a href="company.php">Companies</a></li>
                    <li><a href="../index.html">About Us</a></li>
                </ul>
                <div class="nav-buttons">
                    <a href="../Login/Nav_Login/Login_index.htm">
                        <button class="login-btn">Login</button>
                    </a>
                    <a href="../Register/Nav_Register/register_index.htm">
                        <button class="register-btn">Register</button>
                    </a>
                    <button class="admin-btn"><a href="../Login/Sub_Logins/admin_Login_form.php" id="admin-btn" style="text-decoration: none;"> Admin </a></button>
                </div>
            </nav>
        </div>
    </header>
    

<div class="container">
    <div class="header">
        <h1>Our Trusted Partners</h1>
        <p>Learn more about the amazing companies we collaborate with.</p>
    </div>

    <div class="company-grid">
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <div class="company-card" data-company="<?php echo $row['r_id']; ?>" onclick="openModal(<?php echo $row['r_id']; ?>)">
                <img src="../../Backend/uploads/<?php echo $row['company_logo']; ?>" alt="Company Logo">
                <h3><?php echo htmlspecialchars($row['company_name']); ?></h3>
                <p><?php echo htmlspecialchars($row['industry']); ?></p>
            </div>
        <?php } ?>
    </div>
</div>

<!-- Modal -->
<!-- Modal -->
<div class="modal" id="companyModal">
    <div class="modal-content">
        <span class="modal-close" id="closeModal">&times;</span>
        <div class="modal-header">
            <img id="modalCompanyLogo" src="" alt="Company Logo" class="modal-logo">
            <h2 id="modalCompanyName"></h2>
            <p id="modalCompanyIndustry" class="modal-subtitle"></p>
        </div>
        <div class="modal-body">
            <div class="modal-section">
                <h3>About</h3>
                <p id="modalCompanyDescription"></p>
            </div>
            <div class="modal-section">
                <h3>Contact Details</h3>
                <p><strong>Email:</strong> <a id="modalCompanyEmail" href=""></a></p>
                <p><strong>Phone:</strong> <span id="modalCompanyPhone"></span></p>
                <p><strong>Address:</strong> <span id="modalCompanyAddress"></span></p>
            </div>
            <div class="modal-section">
                <h3>Social Links</h3>
                <div class="social-links">
                    <a id="modalLinkedin" href="" target="_blank" class="social-link">
                        <img src="../images/social/linkedin.png" alt="LinkedIn">
                    </a>
                    <a id="modalTwitter" href="" target="_blank" class="social-link">
                        <img src="../images/social/twitter.png" alt="Twitter">
                    </a>
                    <a id="modalFacebook" href="" target="_blank" class="social-link">
                        <img src="../images/social/facebook.png" alt="Facebook">
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const companies = <?php 
        // Fetch all data for use in the modal
        $resultModal = mysqli_query($conn, $query);
        $companiesData = [];
        while ($row = mysqli_fetch_assoc($resultModal)) {
            $companiesData[$row['r_id']] = $row;
        }
        echo json_encode($companiesData);
    ?>;

function openModal(companyId) {
    const company = companies[companyId];
    const modal = document.getElementById('companyModal');

    // Set modal content
    document.getElementById('modalCompanyLogo').src = `../../Backend/uploads/${company.company_logo}`;
    document.getElementById('modalCompanyName').textContent = company.company_name;
    document.getElementById('modalCompanyIndustry').textContent = company.industry;
    document.getElementById('modalCompanyDescription').textContent = company.company_description;
    document.getElementById('modalCompanyEmail').href = `mailto:${company.contact_email}`;
    document.getElementById('modalCompanyEmail').textContent = company.contact_email;
    document.getElementById('modalCompanyPhone').textContent = company.contact_phone_number;
    document.getElementById('modalCompanyAddress').textContent = company.office_address;

    // Set social links
    document.getElementById('modalLinkedin').href = company.linkedin_profile;
    document.getElementById('modalTwitter').href = company.twitter_handle;
    document.getElementById('modalFacebook').href = company.facebook_page;

    // Show modal
    modal.style.display = 'flex';
}

document.getElementById('closeModal').onclick = function() {
    document.getElementById('companyModal').style.display = 'none';
};

window.onclick = function(event) {
    const modal = document.getElementById('companyModal');
    if (event.target === modal) {
        modal.style.display = 'none';
    }
};
</script>

<?php include '../footer.php'; ?>
</body>
</html>
