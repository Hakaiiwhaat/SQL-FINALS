<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="studentStyles.css">
    <title>Student's Account</title>
</head>
<body>
        <div class="transBg"></div>
        <div class="abs">
            <img src="../tcuBg.jpeg" alt="TCU" class="img-fluid" srcset="">
        </div>
        <div class="header align-items-center justify-content-center">
            <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">
                <div class="menu">
                    <div class="bar"></div>
                    <div class="bar"></div>
                    <div class="bar"></div>
                </div>
            </button>    
            <p class="display-6 title mt-3">Student's Account</p>
        </div>
        <div class="welcome text-center mt-5">
            <p class="welc display-1">WELCOME!</p>
        </div>
        

        <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions" aria-labelledby="offcanvasWithBothOptionsLabel">
            <div class="offcanvas-header">
            <img src="../tcuLogo.png" alt="TCU" srcset="" class="tcuLogo">
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
            <ul class="list-group list-group-flush mt-3">
                <li class="list-group-item mt-4"><a href="studentsPage.php">Dashboard</a></li>
                <li class="list-group-item mt-4"><a href="subjPage.php">Subjects</a></li>
                <li class="list-group-item mt-4"><a href="viewGrade.php">View Grade</a></li>
                <li class="list-group-item mt-4"><a href="gradingCriteria.php">Grade Criteria</a></li>
                <li class="list-group-item mt-4"><a href="profilePage.php">Profile</a></li>
                <li class="list-group-item  mt-4"><a href="../logOut.php" style="color: red">Log out</a></li>
            </ul>
            </div>
        </div>

        <?php
    session_start();
    // Check if the user is not logged in
    if (!isset($_SESSION['studentName'])) {
        // Set a session variable to indicate the alert message
        $_SESSION['login_alert'] = 'You are not logged in!';

        // Redirect to the login page
        header("Location: ../loginPage.php");
        exit; // Stop further execution
    }

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

    // Retrieve student's ID based on the logged-in username
    $studentName = $_SESSION['studentName'];
    $studentID = $_SESSION['studentID'];
    $sqlStudID = "SELECT studentID FROM students WHERE lastName = '$studentName'";
    $resultStudID = $conn->query($sqlStudID);
    $rowStudID = $resultStudID->fetch_assoc();
    $StudID = $rowStudID['studentID'];

    // Query to get the number of subjects
    $sqlSubjectCount = "SELECT COUNT(*) AS subjectCount
        FROM sectionsSubjects AS ss
        INNER JOIN subjects AS sub ON ss.subjectID = sub.subjectID
        INNER JOIN students AS stu ON ss.sectionID = stu.sectionID
        WHERE stu.studentID = '$studentID'";
    $resultSubjectCount = $conn->query($sqlSubjectCount);
    $rowSubjectCount = $resultSubjectCount->fetch_assoc();
    $subjectCount = $rowSubjectCount['subjectCount'];


    // Query to get the current semester
    $sqlCurrentSemester = "SELECT semesterName FROM semester WHERE semesterID = (SELECT MAX(semesterID) FROM sections)";
    $resultCurrentSemester = $conn->query($sqlCurrentSemester);
    $rowCurrentSemester = $resultCurrentSemester->fetch_assoc();
    $currentSemester = $rowCurrentSemester['semesterName'];

    // Calculate the total number of units for the current semester
    $sqlTotalUnits = "SELECT SUM(sub.units) AS totalUnits
                    FROM students AS stu
                    INNER JOIN sectionsSubjects AS ss ON stu.sectionID = ss.sectionID
                    INNER JOIN subjects AS sub ON ss.subjectID = sub.subjectID
                    WHERE stu.studentID = '$studentID'";
    $resultTotalUnits = $conn->query($sqlTotalUnits);
    $rowTotalUnits = $resultTotalUnits->fetch_assoc();
    $totalUnits = $rowTotalUnits['totalUnits'];

    // Query to get the number of subjects
    $sqlYearLevel = "SELECT yearlevel.yearLevel AS yearLevel
                 FROM yearlevel
                 INNER JOIN students ON yearlevel.yearID = students.yearID
                 WHERE students.studentID = '$studentID'";
    $resultYearLevel = $conn->query($sqlYearLevel);
    $rowYearLevel = $resultYearLevel->fetch_assoc();
    $yearLevel = $rowYearLevel['yearLevel'];


    // Close the database connection
    $conn->close();
    ?>

        <div class="infos row">
            <div class="block1 blocks text-black rounded-3 col-md-3">
                <p class="desc">Total Subjects:</p>
                <p class="subjectCount"><?php echo $subjectCount; ?></p>
            </div>
            <div class="block2 blocks text-black rounded-3 col-md-3">
                <p class="desc">Current Semester:</p>
                <p class="currentSem"><?php echo $currentSemester; ?></p>
            </div>
            <div class="block3 blocks text-black rounded-3 col-md-3">
                <p class="desc">Total Units:</p>
                <p class="totalUnits"><?php echo $totalUnits; ?></p>
            </div>
            <div class="block4 blocks text-black rounded-3 col-md-3">
                <p class="desc">Year Level:</p>
                <p class="yearLevel"><?php echo $yearLevel; ?></p>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>
</html>
