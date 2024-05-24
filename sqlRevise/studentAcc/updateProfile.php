<?php
// Start the session
session_start();

// Establish a connection to the database
$servername = "localhost";
$username = "root";
$password = "";
$database = "gradingsystem";

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is logged in
if (!isset($_SESSION['studentName'])) {
    // Redirect to the login page if not logged in
    header("Location: ../loginPage.php");
    exit; // Stop further execution
}

// Check if form data has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $lastName = $_POST['lName'];
    $firstName = $_POST['fName'];
    $middleName = $_POST['mName'];
    $phoneNo = $_POST['phoNo'];
    $emailAdd = $_POST['eMail'];
    $studNo = $_POST['studNo'];
    

    // Retrieve professor's ID from the session
    $studentID = $_SESSION['studentID'];

    // Prepare update statement with placeholders
    $sql = "UPDATE students SET lastName=?, firstName=?, middleName=?, studNo=?, phoneNo=?, emailAdd=? WHERE studentID=?";

    // Prepare and bind parameters
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $lastName, $firstName, $middleName, $studNo, $phoneNo, $emailAdd, $studentID); 


    // Execute the statement
    if ($stmt->execute()) {
        echo "<script>alert('Profile updated successfully');</script>";
        echo "<script>window.location.href = 'profilePage.php';</script>";
    
    } else {
        echo "<script>alert('Error updating profile: " . $conn->error . "');</script>";
    }
    
    $_SESSION['studentID'] = $studentID;
    $_SESSION['studentName'] = $lastName;
    // Close the statement and database connection
    $stmt->close();
    $conn->close();
}
?>
