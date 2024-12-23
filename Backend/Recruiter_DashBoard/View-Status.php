<?php
include 'dbconfig.php'; // Include the database configuration

// Fetch internships
$sql = "SELECT internship_id, internship_title, status, created_at, type, duration, stipend_amount FROM post_internship_form_detail";
$result = $conn->query($sql);

$internships = [];

// Process results
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $internships[] = $row;
    }
}

// Output JSON
header('Content-Type: application/json');
echo json_encode($internships);

// Close connection
$conn->close();
?>