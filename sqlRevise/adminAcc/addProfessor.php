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
$lastName = isset($_POST['lastName']) ? $_POST['lastName'] : '';
$firstName = isset($_POST['firstName']) ? $_POST['firstName'] : '';
$middleName = isset($_POST['middleName']) ? $_POST['middleName'] : '';
$emailAdd = isset($_POST['emailAdd']) ? $_POST['emailAdd'] : '';
$phoneNo = isset($_POST['phoneNo']) ? $_POST['phoneNo'] : '';

// Check if any of the variables is empty
if (empty($lastName) || empty($firstName) || empty($middleName) || empty($emailAdd) || empty($phoneNo)) {
    
    echo "One or more fields are empty. Please fill out all fields.";
} else {
    // Check if professor already exists based on full name
    $checkQuery = "SELECT * FROM professors WHERE CONCAT(lastName, ' ', firstName) = '" . $lastName . ' ' . $firstName . "'";
    $checkResult = $conn->query($checkQuery);


    if ($checkResult->num_rows > 0) {
        echo"Error: Professor already exists";
    } else {
        // Prepare SQL statement
        $sql = "INSERT INTO professors (lastName, firstName, middleName, emailAdd, phoneNo)
                VALUES ('$lastName', '$firstName', '$middleName', '$emailAdd', '$phoneNo')";

        // Execute SQL statement
        if ($conn->query($sql) === TRUE) {
            echo "New professor added successfully!";
            exit();
        } else {
            echo "Error: " . $conn->error . "";
        }
    }
}



// Close connection
$conn->close();
?>
