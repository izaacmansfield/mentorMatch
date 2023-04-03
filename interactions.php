<?php
$servername = "107.180.1.16";
$username = "sprc2023team3";
$password = "sprc2023team3";
$dbname = "sprc2023team3";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$userEmail = $_POST['userEmail'];
$profileEmail = $_POST['profileEmail'];
$status = $_POST['status'];

$sql = "INSERT INTO interactions (user_email, profile_email, status) VALUES (?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $userEmail, $profileEmail, $status);

if ($stmt->execute()) {
    echo "New interaction saved successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$stmt->close();
$conn->close();
?>
