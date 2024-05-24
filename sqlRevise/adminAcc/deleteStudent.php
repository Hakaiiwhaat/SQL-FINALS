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

$studNo = isset($_POST['studNo']) ? $_POST['studNo'] : '';

if (empty($studNo)) {
    echo "Student Number is empty. Please fill out.";
} else {
    // Check if the form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve the student data from the form
        $studNo = $_POST['studNo'];

        // Prepare SQL statement
        $sql = "DELETE FROM students WHERE studNo = '$studNo'";

        // Execute SQL statement
        if ($conn->query($sql) === TRUE) {
            echo "Student deleted successfully!";
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    }
}



// Close connection
$conn->close();
?>
