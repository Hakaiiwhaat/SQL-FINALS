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
    $lastName = isset($_POST['lastName']) ? $_POST['lastName'] : '';
    $firstName = isset($_POST['firstName']) ? $_POST['firstName'] : '';
    $middleName = isset($_POST['middleName']) ? $_POST['middleName'] : '';
    $emailAdd = isset($_POST['emailAdd']) ? $_POST['emailAdd'] : '';
    $phoneNo = isset($_POST['phoneNo']) ? $_POST['phoneNo'] : '';

    // Check if any of the variables is empty
    if (empty($lastName) || empty($firstName) || empty($middleName) || empty($emailAdd) || empty($phoneNo)) {
        echo "One or more fields are empty. Please fill out all fields.";
    } else {
        // Prepare SQL statement
        $sql = "DELETE FROM professors 
        WHERE CONCAT(lastName, ' ', firstName) = '" . $lastName . ' ' . $firstName . "' 
        AND emailAdd = '" . $emailAdd . "' AND phoneNo = '" . $phoneNo . "'";

        // Execute SQL statement
        if ($conn->query($sql) === TRUE) {
            echo "Professor deleted successfully!";
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    }
}

// Close connection
$conn->close();
?>
