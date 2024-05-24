<?php
// Database connection parameters
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$database = "gradingsystem";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare data to insert
$lastName = isset($_POST['lastName']) ? $_POST['lastName'] : '';
$firstName = isset($_POST['firstName']) ? $_POST['firstName'] : '';
$middleName = isset($_POST['middleName']) ? $_POST['middleName'] : '';
$studNo = isset($_POST['studNo']) ? $_POST['studNo'] : '';
$emailAdd = isset($_POST['emailAdd']) ? $_POST['emailAdd'] : '';
$phoneNo = isset($_POST['phoneNo']) ? $_POST['phoneNo'] : '';
$sectionID = isset($_POST['sectionName']) ? $_POST['sectionName'] : '';
$yearID = isset($_POST['yearLevel']) ? $_POST['yearLevel'] : '';

if (empty($lastName) || empty($firstName) || empty($middleName) || empty($studNo) || empty($emailAdd) || empty($phoneNo) || empty($sectionID) || empty($yearID)) {
    echo "One or more fields are empty. Please fill out all fields.";
} else {
    // Check if student already exists based on studNo
    $checkQuery = "SELECT * FROM students WHERE studNo = '$studNo'";
    $checkResult = $conn->query($checkQuery);

    if ($checkResult->num_rows > 0) {
        echo"<script>alert('Error: Student with the same student number already exists');</script>";
        echo "<script>window.location.href = 'adminPage.php';</script>";
    } else {
        // Prepare SQL statement
        $sql = "INSERT INTO students (lastName, firstName, middleName, studNo, emailAdd, phoneNo, sectionID, yearID)
                VALUES ('$lastName', '$firstName', '$middleName', '$studNo', '$emailAdd', '$phoneNo', '$sectionID', '$yearID')";

        // Execute SQL statement
        if ($conn->query($sql) === TRUE) {
            echo "New student added successfully!";
            exit();
        } else {
            echo "<script>aler('Error: " . $conn->error . "');</script>";
        }
    }
}


// Close connection
$conn->close();
?>
