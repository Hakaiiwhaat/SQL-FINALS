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
if (!isset($_SESSION['professorName'])) {
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
    

    // Retrieve professor's ID from the session
    $professorID = $_SESSION['professorID'];

    // Prepare update statement with placeholders
    $sql = "UPDATE professors SET lastName=?, firstName=?, middleName=?, phoneNo=?, emailAdd=? WHERE profID=?";

    // Prepare and bind parameters
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $lastName, $firstName, $middleName, $phoneNo, $emailAdd, $professorID);

    // Execute the statement
    if ($stmt->execute()) {
        echo "<script>alert('Profile updated successfully');</script>";
        echo "<script>window.location.href = 'profilePage.php';</script>";
    
    } else {
        echo "<script>alert('Error updating profile: " . $conn->error . "');</script>";
    }
    
    $_SESSION['professorID'] = $professorID;
    $_SESSION['professorName'] = $lastName;
    // Close the statement and database connection
    $stmt->close();
    $conn->close();
}
?>
