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

// Check for a request to end the posting
if (isset($_POST['action']) && $_POST['action'] === 'end_posting') {
    $internship_id = $_POST['internship_id'];

    // SQL query to update the status to "Off"
    $sql = "UPDATE post_internship_form_detail 
            SET status = 'Off' 
            WHERE internship_id = '$internship_id' AND r_id = '$recruiter_id'";

    if (mysqli_query($conn, $sql)) {
        echo json_encode(["success" => true, "message" => "Posting ended successfully."]);
    } else {
        echo json_encode(["error" => "Error ending posting: " . mysqli_error($conn)]);
    }

    mysqli_close($conn);
    exit;
}

// SQL query to fetch internships posted by the logged-in recruiter
$sql = "SELECT internship_id, internship_title, company_name, location, duration, created_at, deadline, status
FROM post_internship_form_detail
WHERE r_id = '$recruiter_id'
ORDER BY created_at DESC;
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
