<?php
// Include database configuration
include('../dbconfig.php');

// Check if session is started and candidate ID exists
session_start();
if (!isset($_SESSION['c_id'])) {
    echo json_encode(['error' => 'No session found for candidate']);
    exit;
}

// Fetch the internships the candidate has applied for
$query = "SELECT 
            applications.internship_id,
            internships.internship_title,
            applications.applied_at,
            applications.submitted_status,
            applications.review_status,
            applications.selection_status
          FROM applications
          JOIN internships ON applications.internship_id = internships.internship_id
          WHERE applications.c_id = ? ORDER BY applications.applied_at DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $_SESSION['c_id']); // Get the candidate's ID from the session
$stmt->execute();
$result = $stmt->get_result();

// Prepare an array to store internship application details
$applications = [];

while ($row = $result->fetch_assoc()) {
    $applications[] = [
        'internship_id' => $row['internship_id'],
        'internship_title' => $row['internship_title'],
        'application_date' => $row['applied_at'],
        'submitted_status' => $row['submitted_status'],  // 'Pending', 'Under Review', 'Selected', etc.
        'review_status' => $row['review_status'],  // 'Pending', 'Under Review', 'Selected', etc.
        'selection_status' => $row['selection_status'],  // 'Pending', 'Selected', 'Rejected'
    ];
}

// Return the data as a JSON response
echo json_encode($applications);
?>
