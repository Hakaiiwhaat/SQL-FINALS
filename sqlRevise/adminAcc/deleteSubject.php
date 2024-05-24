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
    // Retrieve the student data from the form
    $subName = isset($_POST['subName']) ? $_POST['subName'] : '';

    if (empty($subName)) {
        echo "One or more fields are empty. Please fill out all fields.";
    } else {
        // Prepare SQL statement
        $sql = "DELETE FROM subjects WHERE subName = '$subName'";

        // Execute SQL statement
        if ($conn->query($sql) === TRUE) {
            echo "Subject deleted successfully!";
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    }
    
}

// Close connection
$conn->close();
?>
