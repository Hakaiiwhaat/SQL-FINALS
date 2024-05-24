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
$sectionName = isset($_POST["sectionName"]) ? $_POST["sectionName"] : '';
$subName = isset($_POST["subName"]) ? $_POST["subName"] : '';
$subjectID = isset($_POST['subName']) ? $_POST['subName'] : '';
$sectionID = isset($_POST['sectionName']) ? $_POST['sectionName'] : '';

// Check if any of the variables is empty
if (empty($subjectID) || empty($sectionID)) {
    echo "One or more fields are empty. Please fill out all fields.";
} else {
    // Retrieve the section name from the database
    $sectionNameQuery = "SELECT sectionName FROM sections WHERE sectionID = '$sectionID'";
    $sectionNameResult = $conn->query($sectionNameQuery);
    if ($sectionNameResult->num_rows > 0) {
        $sectionRow = $sectionNameResult->fetch_assoc();
        $sectionName = $sectionRow['sectionName'];
    }

    // Prepare SQL statement to insert into subjects table
    $sqlSubjects = "DELETE FROM sectionssubjects
                    WHERE sectionID = '$sectionID' AND subjectID = '$subjectID'";

    // Execute SQL statement to insert into sectionsSubjects table
    if ($conn->query($sqlSubjects) === TRUE) {
        echo "Subject unassigned successfully to " . $sectionName;
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}


// Close connection
$conn->close();
?>
