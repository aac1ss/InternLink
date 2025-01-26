<?php
include '../../../Backend/dbconfig.php';

// Handle POST requests for actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    if ($action === 'extend_deadline') {
        $internshipId = $_POST['internship_id'];
        $newDeadline = $_POST['new_deadline'];

        // Update the deadline in the database
        $query = "UPDATE post_internship_form_detail SET deadline = '$newDeadline' WHERE internship_id = $internshipId";
        $result = mysqli_query($conn, $query);

        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Deadline extended successfully.']);
        } else {
            echo json_encode(['success' => false, 'error' => 'Error extending deadline: ' . mysqli_error($conn)]);
        }
    } elseif ($action === 'end_posting') {
        $internshipId = $_POST['internship_id'];

        // Delete the posting from the database
        $query = "DELETE FROM post_internship_form_detail WHERE internship_id = $internshipId";
        $result = mysqli_query($conn, $query);

        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Posting deleted successfully.']);
        } else {
            echo json_encode(['success' => false, 'error' => 'Error deleting posting: ' . mysqli_error($conn)]);
        }
    }
} else {
    // Fetch data for the table
    $query = "
       SELECT 
        p.internship_id, 
        p.company_name, 
        p.internship_title, 
        p.type, 
        p.stipend_amount, 
        p.deadline, 
        p.status 
    FROM 
        post_internship_form_detail p
    WHERE 
        p.status = 'on'  -- Filter rows where status is 'on'
    ORDER BY 
        p.internship_id ASC;  
    ";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die(json_encode(['success' => false, 'error' => 'Query Failed: ' . mysqli_error($conn)]));
    }

    $internships = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $internships[] = $row;
    }

    echo json_encode($internships);
}

mysqli_close($conn);
?>