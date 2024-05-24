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
$studUser = isset($_POST['studUser']) ? $_POST['studUser'] : '';
$studPass = isset($_POST['studPass']) ? $_POST['studPass'] : '';
$fullName = isset($_POST['studentName']) ? $_POST['studentName'] : '';

// Check if any of the variables is empty
if (empty($studUser) || empty($studPass) || empty($fullName)) {
    echo "One or more fields are empty. Please fill out all fields.";
} else {
    // Retrieve studentID based on full name
    $getStudentIDQuery = "SELECT studentID FROM students WHERE CONCAT(lastName, ', ', firstName) = '$fullName'";
    $getStudentIDResult = $conn->query($getStudentIDQuery);

    if ($getStudentIDResult->num_rows > 0) {
        $row = $getStudentIDResult->fetch_assoc();
        $studentID = $row['studentID'];

        // Check if student account already exists based on username
        $checkQuery = "SELECT * FROM studentsaccount WHERE studUser = '$studUser'";
        $checkResult = $conn->query($checkQuery);

        if ($checkResult->num_rows > 0) {
            echo "Error: Username already exists";
        } else {
            // Prepare SQL statement
            $sql = "INSERT INTO studentsaccount (studUser, studPass, studentID)
                    VALUES ('$studUser', '$studPass', '$studentID')";

            // Execute SQL statement
            if ($conn->query($sql) === TRUE) {
                echo "New student account added successfully!";
            } else {
                echo "Error: " . $conn->error;
            }
        }
    } else {
        echo "Error: Student not found";
    }
}

// Close connection
$conn->close();
?>
