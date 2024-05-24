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
    $profID = isset($_POST['fullName']) ? $_POST['fullName'] : '';

    // Check if any of the variables is empty
    if (empty($profID)) {
        echo "Please select a professor.";
    } else {
        // Prepare SQL statement
        $sql = "DELETE FROM professorsaccount
        WHERE profID = '$profID'";

        // Execute SQL statement
        if ($conn->query($sql) === TRUE) {
            echo "Professor account deleted successfully!";
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    }
}

// Close connection
$conn->close();
?>
