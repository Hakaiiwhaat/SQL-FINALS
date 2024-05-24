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

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Prepare data to insert
    $studentName = isset($_POST['studentName']) ? $_POST['studentName'] : '';

    // Check if any of the variables is empty
    if (empty($studentName)) {
        echo "Please select a student using the dropdown option.";
    } else {
        // Retrieve studentID based on full name
        $getStudentIDQuery = "SELECT studentID FROM students WHERE CONCAT(lastName, ', ', firstName) = '$studentName'";
        $getStudentIDResult = $conn->query($getStudentIDQuery);

        if ($getStudentIDResult->num_rows > 0) {
            $row = $getStudentIDResult->fetch_assoc();
            $studentID = $row['studentID'];


            // Prepare SQL statement
            $sql = "DELETE FROM studentsaccount 
            WHERE studentID = '$studentID'";

            // Execute SQL statement
            if ($conn->query($sql) === TRUE) {
                echo "Student account deleted successfully!";
                exit();
            } else {
                echo "Error: " . $conn->error;
            }
        } else {
            echo "Error: Student not found";
        }
    } 
}

// Close connection
$conn->close();
?>
