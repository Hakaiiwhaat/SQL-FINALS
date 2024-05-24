<?php
    // session_start();
    // if (!isset($_SESSION['studentName'])) {
    //     // Set a session variable to indicate the alert message
    //     $_SESSION['login_alert'] = 'You are not logged in!';

    //     // Redirect to the login page
    //     header("Location: ../loginPage.php");
    //     exit; // Stop further execution
    // }
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
    $studentID = $_SESSION['studentID'];
    // Fetch subjects from database
    $sql = "SELECT 
        s.subName, 
        s.units,
        CONCAT(pr.lastName, ', ', pr.firstName) AS fullName 
        FROM 
        subjects AS s
        INNER JOIN
        sectionssubjects AS ss ON s.subjectID = ss.subjectID
        INNER JOIN 
        students AS stu ON ss.sectionID = stu.sectionID
        INNER JOIN
        professors AS pr ON s.profID = pr.profID
        WHERE
        stu.studentID = $studentID";

    $result = $conn->query($sql);


    // Output table rows for each subject
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td class='subName'>" . $row["subName"] . "</td>";
            echo "<td>" . $row["fullName"] . "</td>";
            echo "<td>" . $row["units"] . "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='3'>No subjects found</td></tr>";
    }

// Close connection
$conn->close();
?>
