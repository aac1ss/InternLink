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
<div class="modal" id="companyModal">
    <div class="modal-content">
        <span class="modal-close" id="closeModal">&times;</span>
        <div class="modal-header" id="modalCompanyName"></div>
        <div class="modal-body" id="modalCompanyDetails"></div>
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
        
        document.getElementById('modalCompanyName').innerHTML = company.company_name;
        document.getElementById('modalCompanyDetails').innerHTML = `
            <p><strong>Industry:</strong> ${company.industry}</p>
            <p><strong>Company Size:</strong> ${company.company_size}</p>
            <p><strong>Website:</strong> <a href="${company.website}" target="_blank">${company.website}</a></p>
            <p><strong>Description:</strong> ${company.company_description}</p>
            <p><strong>Contact Name:</strong> ${company.contact_person_name}</p>
            <p><strong>Position:</strong> ${company.contact_position}</p>
            <p><strong>Email:</strong> <a href="mailto:${company.contact_email}">${company.contact_email}</a></p>
            <p><strong>Phone:</strong> ${company.contact_phone_number}</p>
            <p><strong>Address:</strong> ${company.office_address}</p>
            <p><strong>Social Links:</strong></p>
            <ul>
                <li><a href="${company.linkedin_profile}" target="_blank">LinkedIn</a></li>
                <li><a href="${company.twitter_handle}" target="_blank">Twitter</a></li>
                <li><a href="${company.facebook_page}" target="_blank">Facebook</a></li>
                <li><a href="${company.other_social_link}" target="_blank">Other</a></li>
            </ul>
        `;
        
        modal.style.display = 'block';
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
