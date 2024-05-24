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
$semesterID = isset($_POST['semesterName']) ? $_POST['semesterName'] : '';

// Check if any of the variables is empty
if (empty($semesterID)) {
    echo "Please fill out all fields.";
} else {
    // Prepare SQL statement to insert into sectionsSubjects table
    $sqlSemester = "UPDATE sections SET semesterID = '$semesterID'";

    // Retrieve the section name from the database
    $semesterNameQuery = "SELECT semesterName FROM semester WHERE semesterID = '$semesterID'";
    $semesterResult = $conn->query($semesterNameQuery);
    if ($semesterResult->num_rows > 0) {
        $semesterRow = $semesterResult->fetch_assoc();
        $semesterName = $semesterRow['semesterName'];
    }
    // Execute SQL statement to insert into sectionsSubjects table
    if ($conn->query($sqlSemester) === TRUE) {
        echo "Semester successfully changed to " . $semesterName;
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}


// Close connection
$conn->close();
?>
