<?php
session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$servername = "107.180.1.16";
$username = "sprc2023team3";
$password = "sprc2023team3";
$dbname = "sprc2023team3";

$action = $_POST['action'];
$name = isset($_POST['name']) ? $_POST['name'] : null;
$email = $_POST['email'];
$user_password = $_POST['password'];

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
}

if ($action === 'login') {
    $sql = "SELECT * FROM new_user WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
        echo json_encode($row);
    } else {
        echo json_encode(['error' => 'User not found']);
    }
    if ($row) {
        if ($row['password'] === $user_password) {
            // Set session variables for email and password
            $_SESSION['email'] = $email;
            $_SESSION['password'] = $user_password;
            echo json_encode(['success' => 'Login successful']);
        } else {
            echo json_encode(['error' => 'Incorrect password']);
        }
    } else {
        echo json_encode(['error' => 'User not found']);
    }
} elseif ($action === 'create_account') {
    $sql = "INSERT INTO new_user (name, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $email, $user_password);

    if ($stmt->execute()) {
        echo json_encode(['success' => 'User created successfully']);
    } else {
        echo json_encode(['error' => 'Error: ' . $stmt->error]);
    }
} else {
    echo json_encode(['error' => 'Invalid action']);
}

$conn->close();
}
?>