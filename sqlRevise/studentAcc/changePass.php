<?php
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
    $currentPassword = $_POST['currentPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    // Retrieve student's ID from the session
    $studentID = $_SESSION['studentID'];

    // Verify the current password
    $sql = "SELECT studPass FROM studentsaccount WHERE studentID = '$studentID'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $storedPassword = $row['studPass'];
        
        // Check if the stored password is hashed
        if (password_verify($currentPassword, $storedPassword)) {
            // Check if the new password and confirm password match
            if ($newPassword === $confirmPassword) {
                // Hash the new password if it's not already hashed
                if (!password_needs_rehash($storedPassword, PASSWORD_DEFAULT)) {
                    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                } else {
                    $hashedPassword = $newPassword; // Password is already hashed
                }

                // Update the password
                $updateSql = "UPDATE studentsaccount SET studPass = '$hashedPassword' WHERE studentID = '$studentID'";
                if ($conn->query($updateSql) === TRUE) {
                    echo "<script>alert('Password updated successfully')</script>";
                    echo "<script>window.location.href = 'profilePage.php';</script>";
                    exit(); 
                } else {
                    echo "<script>alert('Error updating password: " . $conn->error . "')</script>";
                    echo "<script>window.location.href = 'profilePage.php';</script>";
                    exit(); 
                }
            } else {
                echo "New passwords don't match";
                echo "<script>window.location.href = 'profilePage.php';</script>";
            }
        } elseif ($currentPassword === $storedPassword) {
            // Password is plaintext, proceed with verification and hashing
            if ($newPassword === $confirmPassword) {
                // Hash the new password
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                
                // Update the password
                $updateSql = "UPDATE studentsaccount SET studPass = '$hashedPassword' WHERE studentID = '$studentID'";
                if ($conn->query($updateSql) === TRUE) {
                    echo "<script>alert('Password updated successfully')</script>";
                    echo "<script>window.location.href = 'profilePage.php';</script>";
                    exit(); 
                } else {
                    echo "<script>alert('Error updating password: ' . $conn->error)</script>";
                    echo "<script>window.location.href = 'profilePage.php';</script>";
                    exit(); 
                }
            } else {
                echo "New passwords don't match";
                echo "<script>window.location.href = 'profilePage.php';</script>";
                exit(); 
            }
        } else {
            echo "Current password incorrect";
            echo "<script>window.location.href = 'profilePage.php';</script>";
            exit(); 
        }
    } else {
        echo "Error: Student not found";
    }

    // Close the database connection
    $conn->close();
}
?>
