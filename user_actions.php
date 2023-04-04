<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Set session expiration time to 30 minutes (1800 seconds)
ini_set('session.gc_maxlifetime', 1800);
session_start();
header('Content-Type: application/json');

if (isset($_POST['action'])) {
$action = $_POST['action'];
$servername = "107.180.1.16";
$username = "sprc2023team3";
$password = "sprc2023team3";
$dbname = "sprc2023team3";


$name = isset($_POST['name']) ? $_POST['name'] : null;
$email = isset($_POST['email']) ? $_POST['email'] : null;
$user_password = isset($_POST['password']) ? $_POST['password'] : null;

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
}

if ($action === 'login') {
    $sql = "SELECT * FROM new_user2 WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
  
    if ($row = $result->fetch_assoc()) {
        error_log("Entered password: " . $user_password);
        error_log("Stored password: " . $row['password']);
        if ($user_password === $row['password']) {
            // Store the user's email in the session variable
            $_SESSION['user_email'] = $email;
            echo json_encode(['success' => 'Login successful']);
        } else {
            echo json_encode(['error' => 'Incorrect password']);
        }
    } else {
        echo json_encode(['error' => 'User not found']);
    }

 
} elseif ($action === 'create_account') {
    $mentor = $_POST['mentor'];
    $sql = "INSERT INTO new_user2 (password, email, name, mentor) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $user_password, $email, $name, $mentor);

    if ($stmt->execute()) {
        echo json_encode(['success' => 'User created successfully']);
    } else {
        echo json_encode(['error' => 'Error: ' . $stmt->error, 'sql_query' => $sql]);
    }
} 


 elseif ($action === 'create_profile') {
    $email = $_POST['email'];
    $major = $_POST['major'];
    $school_year = $_POST['schoolyear'];
    $description = $_POST['description'];
    $sql = "INSERT INTO mentee_information2 (Email, major, School_year, description) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $email, $major, $school_year, $description);

    if ($stmt->execute()) {
        echo json_encode(['success' => 'Profile created successfully']);
    } else {
        echo json_encode(['error' => 'Error: ' . $stmt->error, 'sql_query' => $sql]);
    }
} 



elseif ($action === 'get_email') {
    if (isset($_SESSION['user_email'])) {
        echo json_encode(['user_email' => $_SESSION['user_email']]);
    } else {
        echo json_encode(['error' => 'Email not found in session']);
    }
}


elseif ($action === "logout") {
    // Destroy all session variables
    session_unset();

    // End the current session
    session_destroy();

    echo json_encode(['success' => 'User logged out']);
}


$conn->close();
}
?>