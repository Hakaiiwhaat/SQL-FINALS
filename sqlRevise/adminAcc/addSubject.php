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
$subName = isset($_POST['subName']) ? $_POST['subName'] : '';
$noOfUnits = isset($_POST['units']) ? $_POST['units'] : '';
$profID = isset($_POST['profName']) ? $_POST['profName'] : '';
$sectionID = isset($_POST['sectionName']) ? $_POST['sectionName'] : '';

// Check if any of the variables is empty
if (empty($subName) || empty($noOfUnits) || empty($profID) || empty($sectionID)) {
    echo "One or more fields are empty. Please fill out all fields.";
} else {
    // Check if subject already exists based on subject name
    $checkQuery = "SELECT * FROM subjects WHERE subName = '$subName'";
    $checkResult = $conn->query($checkQuery);

    if ($checkResult->num_rows > 0) {
        echo "Error: Subject already exists";
    } else {
        // Prepare SQL statement to insert into subjects table
        $sqlSubjects = "INSERT INTO subjects (subName, units, profID)
                        VALUES ('$subName', '$noOfUnits', '$profID')";

        // Execute SQL statement to insert into subjects table
        if ($conn->query($sqlSubjects) === TRUE) {
            // Get the ID of the inserted subject
            $subjectID = $conn->insert_id;

            // Prepare SQL statement to insert into sectionsSubjects table
            $sqlSectionSubject = "INSERT INTO sectionsSubjects (sectionID, subjectID)
                                  VALUES ('$sectionID', '$subjectID')";

            // Retrieve the section name from the database
            $sectionNameQuery = "SELECT sectionName FROM sections WHERE sectionID = '$sectionID'";
            $sectionNameResult = $conn->query($sectionNameQuery);
            if ($sectionNameResult->num_rows > 0) {
                $sectionRow = $sectionNameResult->fetch_assoc();
                $sectionName = $sectionRow['sectionName'];
            }
            // Execute SQL statement to insert into sectionsSubjects table
            if ($conn->query($sqlSectionSubject) === TRUE) {
                echo "Subject added successfully and assigned to " . $sectionName;
                exit();
            } else {
                echo "Error: " . $conn->error;
            }
        } else {
            echo "Error: " . $conn->error;
        }
    }
}


// Close connection
$conn->close();
?>
