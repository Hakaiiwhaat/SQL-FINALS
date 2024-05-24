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
    $sectName = isset($_POST['sectName']) ? $_POST['sectName'] : '';

    if (empty($sectName)) {
        echo "Please fill out section name.";
    } else {
        // Prepare SQL statement
        $sql = "DELETE FROM sections WHERE sectionName = '$sectName'";

        // Execute SQL statement
        if ($conn->query($sql) === TRUE) {
            echo "Section deleted successfully!";
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    }
    
}

// Close connection
$conn->close();
?>
