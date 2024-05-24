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
$profUser = isset($_POST['profUser']) ? $_POST['profUser'] : '';
$profPass = isset($_POST['profPass']) ? $_POST['profPass'] : '';
$profID = isset($_POST['fullName']) ? $_POST['fullName'] :'';

// Check if any of the variables is empty
if (empty($profUser) || empty($profPass)) {
    echo "One or more fields are empty. Please fill out all fields.";
} else {
    // Check if professor already exists based on full name
    $checkQuery = "SELECT * FROM professorsaccount WHERE profUser = '$profUser'";
    $checkResult = $conn->query($checkQuery);


    if ($checkResult->num_rows > 0) {
        echo"Error: Username already exists";
    } else {
        // Prepare SQL statement
        $sql = "INSERT INTO professorsaccount (profUser, profPass, profID)
                VALUES ('$profUser', '$profPass', '$profID')";

        // Execute SQL statement
        if ($conn->query($sql) === TRUE) {
            echo "New professor account added successfully!";
            exit();
        } else {
            echo "Error: " . $conn->error . "";
        }
    }
}



// Close connection
$conn->close();
?>
