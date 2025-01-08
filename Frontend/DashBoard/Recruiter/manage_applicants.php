<?php
include '../../../../Backend/dbconfig.php';
session_start();

// Ensure recruiter ID is set in the session
if (!isset($_SESSION['r_id'])) {
    echo json_encode(["error" => "Recruiter ID is not set in the session."]);
    exit;
}

$recruiter_id = $_SESSION['r_id'];

// SQL query to fetch applicants grouped by internship_title
$sql = "
   SELECT 
    ia.application_id,
    ia.c_id,  -- Add this to ensure c_id is selected
    ia.internship_title,
    ia.status,
    ia.application_date,
    cp.full_name,
    cp.resume_file
FROM 
    internship_applications ia
INNER JOIN 
    candidate_profiles cp 
    ON ia.c_id = cp.c_id
INNER JOIN 
    post_internship_form_detail pifd 
    ON ia.internship_id = pifd.internship_id
WHERE 
    pifd.r_id = '$recruiter_id'
ORDER BY 
    ia.internship_title ASC, 
    ia.application_date ASC;

";

$result = mysqli_query($conn, $sql);

// Check for errors
if (!$result) {
    echo json_encode(["error" => "Error fetching applicants: " . mysqli_error($conn)]);
    exit;
}

// Fetch data
$applicants = [];
while ($row = mysqli_fetch_assoc($result)) {
    $applicants[$row['internship_title']][] = $row;
}

// Return grouped data as JSON
echo json_encode($applicants);

// Close connection
mysqli_close($conn);
?>
