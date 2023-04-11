<?php
// session_start();
// $servername = "107.180.1.16";
// $username = "sprc2023team3";
// $password = "sprc2023team3";
// $dbname = "sprc2023team3";

$row_num = 1;
$name="";
$email="";
$major="";
$school_year="";
$description="";
$linkedin="";

// Create connection
// $conn = new mysqli($servername, $username, $password, $dbname);
// // Check connection
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

function tinder_match(){
    // $servername = "107.180.1.16";
    // $username = "sprc2023team3";
    // $password = "sprc2023team3";
    // $dbname = "sprc2023team3";
    // $conn1 = new mysqli($servername, $username, $password, $dbname);
    global $conn;
    $sql="SELECT * from mentor_information2 m join new_user2 n where m.email=n.email ";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result= $stmt->get_result();
    global $row_num;
    for($i=1;$i<= $row_num;$i++){
        $row1= mysqli_fetch_assoc($result);
    }
    global $name;
    global $email;
    global $major;
    global $school_year;
    global $description;
    global $linkedin;

    $name= $row1['name'];
    $email= $row1['email'];
    $major= $row1['major'];
    $school_year= $row1['school_year'];
    $description = $row1['description'];
    $linkedin = $row1['linkedin'];
echo '<script>var Name="'.$name.'"</script>';
echo '<script>var mentor_email="'.$email.'"</script>';
echo '<script>var major="'.$major.'"</script>';
echo '<script>var school_year="'.$school_year.'"</script>';
echo '<script>var description="'.$description.'"</script>';
echo '<script>var linkedin="'.$linkedin.'"</script>';

}



// if (isset($_SESSION['email']) && isset($_SESSION['password'])) {
//     $email = $_SESSION['email'];
//     $password = $_SESSION['password'];
    
//     // You can now use the email and password variables in your PHP code
//     echo "User email: " . $email . "<br>";
//     echo "User password: " . $password;
// } else {
//     echo "User not logged in";
// }

// // $userEmail = $_POST['userEmail'];
// // $profileEmail = $_POST['profileEmail'];
// $status = $_POST['status'];

// $sql = "INSERT INTO interactions (user_email, profile_email, status) VALUES (?, ?, ?)";

// $stmt = $conn->prepare($sql);
// $stmt->bind_param("sss", $userEmail, $profileEmail, $status);

// if ($stmt->execute()) {
//     echo "New interaction saved successfully";
// } else {
//     echo "Error: " . $sql . "<br>" . $conn->error;
// }

// $stmt->close();
// $conn->close();
?>
