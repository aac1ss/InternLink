<?php
include '../dbconfig.php';
session_start();

// Ensure recruiter ID is set in the session
if (!isset($_SESSION['r_id'])) {
    echo json_encode(["error" => "Recruiter ID is not set in the session."]);
    exit;
}

$recruiter_id = $_SESSION['r_id'];

// Check for a request to extend the deadline
if (isset($_POST['action']) && $_POST['action'] === 'extend_deadline') {
    $internship_id = $_POST['internship_id'];
    $new_deadline = $_POST['new_deadline'];

    // SQL query to update the deadline
    $sql = "UPDATE post_internship_form_detail 
            SET deadline = '$new_deadline' 
            WHERE internship_id = '$internship_id' AND r_id = '$recruiter_id'";

    if (mysqli_query($conn, $sql)) {
        echo json_encode(["success" => true, "message" => "Deadline extended successfully."]);
    } else {
        echo json_encode(["error" => "Error updating deadline: " . mysqli_error($conn)]);
    }

    mysqli_close($conn);
    exit;
}

// Check for a request to delete the internship
if (isset($_POST['action']) && $_POST['action'] === 'delete_internship') {
    $internship_id = $_POST['internship_id'];

    // SQL query to delete the internship
    $sql = "DELETE FROM post_internship_form_detail WHERE internship_id = '$internship_id' AND r_id = '$recruiter_id'";

    if (mysqli_query($conn, $sql)) {
        echo json_encode(["success" => true, "message" => "Internship deleted successfully."]);
    } else {
        echo json_encode(["error" => "Error deleting internship: " . mysqli_error($conn)]);
    }

    mysqli_close($conn);
    exit;
}

// SQL query to fetch internships along with the number of applicants
$sql = "
SELECT 
    p.internship_id, 
    p.internship_title, 
    p.company_name, 
    p.location, 
    p.duration, 
    p.created_at, 
    p.deadline, 
    p.status,
    (SELECT COUNT(*) FROM internship_applications WHERE internship_id = p.internship_id) AS total_applicants
FROM post_internship_form_detail p
WHERE p.r_id = '$recruiter_id'
ORDER BY p.created_at DESC;
";

$result = mysqli_query($conn, $sql);

// Check for errors
if (!$result) {
    echo json_encode(["error" => "Error fetching internships: " . mysqli_error($conn)]);
    exit;
}

// Fetch the result as an associative array
$internships = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Return the data as JSON
echo json_encode($internships);

// Close the connection
mysqli_close($conn);
?>
