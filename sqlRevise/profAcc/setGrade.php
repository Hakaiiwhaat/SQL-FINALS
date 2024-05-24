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

// Retrieve the subjectID based on the professor's username
$professorName = $_SESSION['professorName'];
$subjectID = $_SESSION['subjectID'];

$sql_subject = "SELECT subjects.subjectID 
                FROM subjects 
                INNER JOIN professors ON subjects.profID = professors.profID 
                WHERE professors.lastName = '$professorName'";

$result_subject = $conn->query($sql_subject);

if ($result_subject->num_rows > 0) {
    $row_subject = $result_subject->fetch_assoc();
    $subjectID = $row_subject['subjectID'];

    foreach ($_POST['grades'] as $gradeData) {
        // Retrieve data for each grade
        $studentID = $gradeData['studentID'];
        $sectionID = $gradeData['sectionID'];
        $subjectID = $gradeData['subjectID'];
        $grade = $gradeData['grade'];

        // Check if the studentID already exists in the grades table
        $sql_check = "SELECT * FROM grades WHERE studentID = '$studentID' AND sectionID = '$sectionID' AND subjectID = '$subjectID'";
        $result_check = $conn->query($sql_check);

        if ($result_check->num_rows > 0) {
            // If a new grade is provided, update the existing grade
            if (!empty($grade)) {
                $sql_update = "UPDATE grades SET grade = '$grade' WHERE studentID = '$studentID' AND sectionID = '$sectionID' AND subjectID = '$subjectID'";
                if ($conn->query($sql_update) === TRUE) {
                    echo "<script>alert('Grades submitted succesfully!');</script>";
                    header("Location: setStudGrade.php");
                } else {
                    echo "Error updating grade, Error: " . $conn->error . "";
                }
            } else {
                
                echo "New grade is empty, existing grade for student ID: $studentID remains unchanged.";
            }
        } else {
            // Insert a new grade
            $sql_insert = "INSERT INTO grades (studentID, sectionID, subjectID, grade) VALUES ('$studentID', '$sectionID', '$subjectID', '$grade')";
            if ($conn->query($sql_insert) === TRUE) {
                echo "Grade inserted successfully for student ID: $studentID";
                echo "<script>alert('Grades submitted succesfully!');</script>";
                header("Location: setStudGrade.php");
            } else {
                echo "Error inserting grade for student ID: $studentID, Error: " . $conn->error . "";
            }
        }
    }
} else {
    echo "Error: No subject found for professor username: " . $professorName;
}

$conn->close();


?>
