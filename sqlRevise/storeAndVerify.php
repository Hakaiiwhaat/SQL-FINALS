<?php
session_start();

// Establish a connection to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gradingsystem";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve username and password from login form
$username = $_POST['name'];
$password = $_POST['password'];


// Query the database to check if the username and password match any professor account
$sqlProfessor = "SELECT pa.*, p.lastName FROM professorsaccount AS pa
        INNER JOIN professors p ON pa.profID = p.profID
        WHERE pa.profUser='$username'";
$resultProfessor = $conn->query($sqlProfessor);

// Check if there is a matching record in the professor accounts table
if ($resultProfessor->num_rows == 1) {
    // Fetch the professor's username, name, and password from the database
    $professor_row = $resultProfessor->fetch_assoc();
    $storedPassword = $professor_row['profPass'];

    // Check if the stored password is hashed or plaintext
    if (password_verify($password, $storedPassword)) {
        // Password is hashed, proceed with login
        $professorUsername = $professor_row['profUser'];
        $professorName = $professor_row['lastName'];
        $_SESSION['professorID'] = $professor_row['profID'];

        // Store professor's username in session for later use
        $_SESSION['professorName'] = $professorName;

        // Redirect to professor's main page
        header("Location: profAcc/profMain.php");
        exit();
    } elseif ($password === $storedPassword) {
        // Password is plaintext, hash it and update the database
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        // Update the password in the database
        $updateSql = "UPDATE professorsaccount SET profPass = '$hashedPassword' WHERE profUser = '$username'";
        $conn->query($updateSql);

        // Proceed with login
        $professorUsername = $professor_row['profUser'];
        $professorName = $professor_row['lastName'];
        $_SESSION['professorID'] = $professor_row['profID'];

        // Store professor's username in session for later use
        $_SESSION['professorName'] = $professorName;

        // Redirect to professor's main page
        header("Location: profAcc/profMain.php");
        exit();
    }
}

// Query the database to check if the username and hashed password match any student account
$sqlStudent = "SELECT sa.*, s.lastName FROM studentsaccount AS sa
        INNER JOIN students s ON sa.studentID = s.studentID
        WHERE sa.studUser='$username'";
$resultStudent = $conn->query($sqlStudent);

// Check if there is a matching record in the professor accounts table
if ($resultStudent->num_rows == 1) {
    // Fetch the professor's username, name, and password from the database
    $student_row = $resultStudent->fetch_assoc();
    $storedPassword = $student_row['studPass'];

    // Check if the stored password is hashed or plaintext
    if (password_verify($password, $storedPassword)) {
        // Password is hashed, proceed with login
        $studentUsername = $student_row['studUser'];
        $studentName = $student_row['lastName'];
        $_SESSION['studentID'] = $student_row['studentID'];

        // Store professor's username in session for later use
        $_SESSION['studentName'] = $studentName;

        // Redirect to professor's main page
        header("Location: studentAcc/studentsPage.php");
        exit();
    } elseif ($password === $storedPassword) {
        // Password is plaintext, hash it and update the database
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        // Update the password in the database
        $updateSql = "UPDATE studentsaccount SET studPass = '$hashedPassword' WHERE studUser = '$username'";
        $conn->query($updateSql);

        // Proceed with login
        $studentUsername = $student_row['studUser'];
        $studentName = $student_row['lastName'];
        $_SESSION['studentID'] = $student_row['studentID'];

        // Store professor's username in session for later use
        $_SESSION['studentName'] = $studentName;

        // Redirect to professor's main page
        header("Location: studentAcc/studentsPage.php");
        exit();
    }
}
// Query the database to check if the username and password match any admin account
$sqlAdmin = "SELECT ac.*, ad.lastName FROM adminaccount AS ac
        INNER JOIN admin ad ON ac.adminID = ad.adminID
        WHERE ac.adminUser='$username'";
$resultAdmin = $conn->query($sqlAdmin);

// Check if there is a matching record in the admin accounts table
if ($resultAdmin->num_rows == 1) {
    // Fetch the admin's username, name, and password from the database
    $admin_row = $resultAdmin->fetch_assoc();
    $storedPassword = $admin_row['adminPass'];

    // Check if the stored password is hashed or plaintext
    if (password_verify($password, $storedPassword)) {
        // Password is hashed, proceed with login
        $adminUsername = $admin_row['adminUser'];
        $adminName = $admin_row['lastName'];
        $_SESSION['adminID'] = $admin_row['adminID'];

        // Store admin's username in session for later use
        $_SESSION['adminName'] = $adminName;

        // Redirect to admin's main page
        header("Location: adminAcc/adminPage.php");
        exit();
    } elseif ($password === $storedPassword) {
        // Password is plaintext, hash it and update the database
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        // Update the password in the database
        $updateSql = "UPDATE adminaccount SET adminPass = '$hashedPassword' WHERE adminUser = '$username'";
        $conn->query($updateSql);

        // Proceed with login
        $adminUsername = $admin_row['adminUser'];
        $adminName = $admin_row['lastName'];
        $_SESSION['adminID'] = $admin_row['adminID'];

        // Store admin's username in session for later use
        $_SESSION['adminName'] = $adminName;

        // Redirect to admin's main page
        header("Location: adminAcc/adminPage.php");
        exit();
    }
}

// Neither professor nor student account found, redirect to login page with error message
echo "<script>
    alert('Username or Password invalid');
    window.location.href='loginPage.php';
    </script>";
exit();

// Close the database connection
$conn->close();
?>
