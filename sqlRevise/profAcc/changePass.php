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
if (!isset($_SESSION['professorName'])) {
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

    // Retrieve professor's ID from the session
    $professorID = $_SESSION['professorID'];

    // Verify the current password
    $sql = "SELECT profPass FROM professorsaccount WHERE profID = '$professorID'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $storedPassword = $row['profPass'];
    
        // Check if the stored password is hashed
        if (password_verify($currentPassword, $storedPassword)) {
            // Password is hashed, proceed with verification
            if ($newPassword === $confirmPassword) {
                // Hash the new password
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                
                // Update the password
                $updateSql = "UPDATE professorsaccount SET profPass = '$hashedPassword' WHERE profID = '$professorID'";
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
        } elseif ($currentPassword === $storedPassword) {
            // Password is plaintext, proceed with verification and hashing
            if ($newPassword === $confirmPassword) {
                // Hash the new password
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                
                // Update the password
                $updateSql = "UPDATE professorsaccount SET profPass = '$hashedPassword' WHERE profID = '$professorID'";
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
        echo "Error: Professor not found";
    }
    

    // Close the database connection
    $conn->close();
}
?>
