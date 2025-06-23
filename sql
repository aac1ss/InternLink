-- Create database
CREATE DATABASE IF NOT EXISTS Internlink_db;
USE Internlink_db;

-- Table: recruiter_signup
CREATE TABLE recruiter_signup (
    recruiter_id INT PRIMARY KEY AUTO_INCREMENT,
    recruiter_email VARCHAR(255),
    recruiter_password VARCHAR(255),
    c_password VARCHAR(255) NOT NULL,
    c_created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table: post_internship_form_detail
CREATE TABLE post_internship_form_detail (
    internship_id INT AUTO_INCREMENT PRIMARY KEY,
    r_id INT,
    internship_title VARCHAR(255) NOT NULL,
    company_name VARCHAR(255) NOT NULL,
    location VARCHAR(255) NOT NULL,
    duration VARCHAR(255) NOT NULL,
    type ENUM('remote', 'hybrid', 'onsite') NOT NULL DEFAULT 'remote',
    stipend_amount VARCHAR(255),
    job_description TEXT NOT NULL,
    responsibility TEXT,
    requirements TEXT,
    skills TEXT,
    perks TEXT,
    additional_info TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    deadline DATE DEFAULT (DATE_ADD(CURRENT_DATE, INTERVAL 1 MONTH)),
    status ENUM('on', 'off') DEFAULT 'on',
    FOREIGN KEY (r_id) REFERENCES recruiter_signup(recruiter_id) ON DELETE CASCADE
);

-- Table: company_profile
CREATE TABLE company_profile (
    r_id INT PRIMARY KEY,
    company_name VARCHAR(255) NOT NULL,
    industry VARCHAR(255) NOT NULL,
    company_size VARCHAR(255) NOT NULL,
    website VARCHAR(255),
    company_description TEXT NOT NULL,
    contact_person_name VARCHAR(255) NOT NULL,
    contact_position VARCHAR(255) NOT NULL,
    contact_email VARCHAR(255) NOT NULL,
    contact_phone_number VARCHAR(20) NOT NULL,
    office_address TEXT NOT NULL,
    linkedin_profile VARCHAR(255),
    twitter_handle VARCHAR(255),
    facebook_page VARCHAR(255),
    other_social_link VARCHAR(255),
    company_logo VARCHAR(255),
    registration_document VARCHAR(255),
    FOREIGN KEY (r_id) REFERENCES recruiter_signup(recruiter_id) ON DELETE CASCADE
);

-- Table: candidate_profiles
CREATE TABLE candidate_profiles (
    c_id INT PRIMARY KEY AUTO_INCREMENT,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(15) NOT NULL,
    address VARCHAR(255),
    education_level VARCHAR(100) NOT NULL,
    skills TEXT,
    experience TEXT,
    linkedin_url VARCHAR(255),
    github_url VARCHAR(255),
    portfolio_url VARCHAR(255),
    resume_file VARCHAR(255),
    profile_picture VARCHAR(255),
    email_changed TINYINT(1) DEFAULT 0
);

-- Table: applications
CREATE TABLE applications (
    application_id INT AUTO_INCREMENT PRIMARY KEY,
    c_id INT NOT NULL,
    internship_id INT NOT NULL,
    applied_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    deadline DATETIME,
    status VARCHAR(50),
    FOREIGN KEY (c_id) REFERENCES candidate_profiles(c_id),
    FOREIGN KEY (internship_id) REFERENCES post_internship_form_detail(internship_id)
);

-- Table: internship_applications
CREATE TABLE internship_applications (
    application_id INT AUTO_INCREMENT PRIMARY KEY,
    c_id INT NOT NULL,
    internship_id INT NOT NULL,
    applied_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('under review', 'short-listed', 'rejected') DEFAULT 'under review',
    FOREIGN KEY (c_id) REFERENCES candidate_profiles(c_id),
    FOREIGN KEY (internship_id) REFERENCES post_internship_form_detail(internship_id)
);

-- Table: admin_signup
CREATE TABLE admin_signup (
    admin_id INT AUTO_INCREMENT PRIMARY KEY,
    admin_email VARCHAR(255) NOT NULL UNIQUE,
    admin_password VARCHAR(255) NOT NULL
);

-- Insert initial admin data (password : ashish / change it via adminDashboard)
INSERT INTO admin_signup (admin_email, admin_password) VALUES
    ('ashish@gmail.com', '$2y$10$Xn/7GRXqSf8roIHtIZa07ustvllpixMYO7PuZHVwlraRSWfFSO2RO');

-- Table: candidates_signup
CREATE TABLE candidates_signup (
    c_id INT PRIMARY KEY AUTO_INCREMENT,
    c_username VARCHAR(255) NOT NULL,
    c_email VARCHAR(255) NOT NULL UNIQUE
);
