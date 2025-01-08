<?php
include '../../../../Backend/dbconfig.php';

// Get the raw POST data
$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['application_id']) || !isset($data['status'])) {
    echo json_encode(['error' => 'Missing application_id or status']);
    exit;
}

$application_id = $data['application_id'];
$status = $data['status'];

// Update the application status in the database
$query = "UPDATE internship_applications SET status = ? WHERE application_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("si", $status, $application_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => "$status successfully updated."]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update status.']);
}

$stmt->close();
$conn->close();
?>

