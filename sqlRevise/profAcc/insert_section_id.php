<?php
session_start();
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gradingsystem";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$profID = $_SESSION['professorID'];

// Check if sectionID is provided in the query string
if (isset($_GET['sectionID'])) {
    $sectionID = $_GET['sectionID'];
    $_SESSION['sectionID'] = $sectionID;
    $sectID = $_SESSION['sectionID'];

    // Check the current row count
    $countSql = "SELECT COUNT(*) as total FROM sectionsession WHERE sectionID = $sectionID";
    $result = $conn->query($countSql);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $totalCount = $row['total'];
        if ($totalCount >= 10) {
            // Truncate the table
            $truncateSql = "TRUNCATE TABLE sectionsession";
            if (!$conn->query($truncateSql)) {
                echo "Error truncating table: " . $conn->error;
                exit;
            }
        }
    } else {
        echo "Error: Unable to count records.";
        exit;
    }

    // Insert the sectionID into the sectids table
    $insertSql = "INSERT INTO sectionsession (profID, sectionID) VALUES ($profID, $sectID)";
    if ($conn->query($insertSql) !== TRUE) {
        echo "Error: " . $insertSql . "<br>" . $conn->error;
    } else {
        // Insertion successful, redirect to secStudList.php
        header("Location: secStudList.php?sectionID=".$sectID);
        exit;
    }
}

// Close the database connection
$conn->close();
?>
