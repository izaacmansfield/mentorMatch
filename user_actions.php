<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Set session expiration time to 30 minutes (1800 seconds)
ini_set('session.gc_maxlifetime', 1800);
session_start();
header('Content-Type: application/json');
// include 'interactions.php';
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
            $mentor_status= $row['mentor'];
            $_SESSION['mentor_status']= $mentor_status;
            $data= array(
                'success' => 'Login succesful',
                'mentor' => $_SESSION['mentor_status']
            );
            echo json_encode($data);
            // if($_SESSION['mentor_status']===1){
            //     tinder_match();
            // }
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
    $linkedin = $_POST['linkedin'];
    if($_SESSION['mentor_status']===1){
        $sql = "INSERT INTO mentee_inf (mentee_email, major, school_year, short_description,linkedin) VALUES (?, ?, ?, ?,?)";
    }
    else{
        $sql="INSERT INTO mentor_information2 (email, major, school_year, description, linkedin) VALUES (?,?,?,?,?)";
    }
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $email, $major, $school_year, $description, $linkedin);

    if ($stmt->execute()) {
        $data2=array(
            'success' => 'Profile created successfully',
            'mentor' => $_SESSION['mentor_status']
        );
        echo json_encode($data2);
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

elseif ($action ==='tinder_match'){
    $sql ="SELECT * from mentor_information2 m join new_user2 n where m.email=n.email";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    $row_num=$_POST['row_num'];
    for($i=0;$i< $row_num;$i++){
        $row1= $result->fetch_assoc();
    }
    $name= $row1['name'];
    $mentor_email= $row1['email'];
    $major= $row1['major'];
    $school_year= $row1['school_year'];
    $description = $row1['description'];
    $linkedin = $row1['linkedin'];
    $_SESSION['mentor_email']=$mentor_email;
    $row_data= array(
        'name'=> $name,
        'email'=> $mentor_email,
        'major'=> $major,
        'school_year'=> $school_year,
        'description'=> $description,
        'linkedin'=> $linkedin
    );
    echo json_encode($row_data);
}
elseif($action==="send_interaction"){
    $status=$_POST['status'];
    $sql ="INSERT INTO interactions2 (user_email, profile_email, status) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $_SESSION['user_email'], $_SESSION['mentor_email'], $status);
    $stmt->execute();

}


// elseif ($action === 'logout') {
//     session_unset();
//     session_destroy();
//     setcookie(session_name(), "", time() - 3600, "/");
//     echo json_encode(['success' => 'Logged out successfully']);
// }

elseif($action==="populateTable"){

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die ("Connection failed: " . $conn->connect_error);
    }

     $sql= "SELECT * FROM interactions2 WHERE status='accepted' and user_email = ?";
     $stmt= $conn->prepare($sql);
     $stmt->bind_param("s",$_SESSION['user_email']);
     $result = $conn->query($sql);

    if (!$result) {
        die("Invalid query: " . $conn->error);
    }
    // read each row's data
    while($row - $result->fetch_assoc()){
    echo "<tr>
    <td>" . $row["name"] . "</td>
    <td>" . $row["school_year"] . "</td>
    <td>" . $row["major"] . "</td>
    <td>" . $row["linkedin"] . "</td>
    <td>" . $row["description"] . "</td>
    <td>
        <a class=btn btn-primary btn-sm' href='accept'>Accept</a>
        <a class=btn btn-danger btn-sm' href='delete'>Delete</a>
    </td>
    </tr>";
    }
    }

$conn->close();
}
?>