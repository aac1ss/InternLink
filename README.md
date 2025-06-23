# Internlink: Linking Talents With Opportunities

![Internlink Logo](https://github.com/user-attachments/assets/fb62883f-754f-4448-b117-1ebe23f8b0d8)

Internlink is a PHP-based web platform that connects talented students and individuals with valuable internship opportunities. Our mission is to bridge the gap between aspiring talent and potential employers, facilitating a seamless recruitment process benefiting both candidates and companies.

---

## Key Features:

- **User-Friendly Interface:** Easy navigation through all functionalities.
- **Profile Creation:** Personalized profiles showcasing skills, experiences, and aspirations.
- **Internship Search:** Advanced search options to find internships matching career goals.
- **Application Management:** Efficient tracking of applications and employer responses.
- **Streamlined Recruitment:** Employers can discover and recruit top talent effortlessly.

---

## Supporting Economic Growth

Internlink is committed to fostering economic growth, workforce development, and inclusive employment practices. By connecting talented individuals with opportunities, we aim to empower the next generation of professionals.

---

## Technology Stack

- HTML  
- CSS  
- JavaScript  
- PHP  
- MySQL  
- phpMyAdmin (for database management)

---

## Database Schema Overview

The project uses a MySQL database named `Internlink_db` with the following tables:

1. **recruiter_signup**  
   Stores recruiter credentials and information.

2. **post_internship_form_detail**  
   Contains internship postings with details such as title, company, location, duration, type, stipend, description, and status.

3. **company_profile**  
   Holds company-related information linked to recruiters.

4. **candidate_profiles**  
   Stores candidate personal and professional profile data.

5. **applications**  
   Tracks internship applications submitted by candidates.

6. **internship_applications**  
   Manages application statuses with options like 'under review', 'short-listed', and 'rejected'.

7. **admin_signup**  
   Contains admin user credentials.

8. **candidates_signup**  
   Candidate signup credentials.

---

## Installation Instructions

1. **Requirements:**  
   - Apache server with PHP support (e.g., XAMPP, WAMP, LAMP)  
   - MySQL server  
   - phpMyAdmin for database management

2. **Setup Steps:**  
   - Place all project files inside the `htdocs` directory of your local server (e.g., `C:\xampp\htdocs\internlink`).  
   - Create the database `Internlink_db` using phpMyAdmin.  
   - Import the SQL schema (tables and initial data) into the database.  
   - Configure database connection details in the project’s PHP config file.  
   - Start Apache and MySQL services.  
   - Open your browser and navigate to `http://localhost/internlink` to run the project.

---

## Usage

- **Recruiters:** Register, create company profiles, and post internship opportunities.  
- **Candidates:** Sign up, build profiles, search internships, and apply.  
- **Admins:** Manage users and oversee platform operations.

---

## License

© 2024 Internlink. All rights reserved.

---

*For questions or support, please contact the project maintainer.*

