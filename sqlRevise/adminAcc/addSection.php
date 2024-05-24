<?php
// Database connection parameters
$servername = "localhost"; // Change if necessary
$username = "root"; // Change if necessary
$password = ""; // Change if necessary
$database = "gradingsystem"; // Change to your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare data to insert
$sectName = isset($_POST['sectName']) ? $_POST['sectName'] : '';
$semesterID = isset($_POST['semesterName']) ? $_POST['semesterName'] : '';


// Check if any of the variables is empty
if (empty($sectName)) {
    echo "Please fill out all fields.";
} else {
    // Check if subject already exists based on full name
    $checkQuery = "SELECT * FROM sections WHERE sectionName = '$sectName'";
    $checkResult = $conn->query($checkQuery);

    if ($checkResult->num_rows > 0) {
        echo"Error: Section already exists";
    } else {
        // Prepare SQL statement
        $sql = "INSERT INTO sections (sectionName, semesterID)
                VALUES ('$sectName', '$semesterID')";

        // Execute SQL statement
        if ($conn->query($sql) === TRUE) {
            echo "New section added successfully!";
            exit();
        } else {
            echo "Error: " . $conn->error . "";
        }
    }
}


// Close connection
$conn->close();
?>
