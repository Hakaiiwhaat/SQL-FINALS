<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="profStyles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>Professor's Account</title>
</head>
<body>
    <div class="container-fluid">
            <div class="transBg"></div>
            <div class="abs">
                <img src="../tcuBg.jpeg" alt="TCU" class="img-fluid" srcset="">
            </div>
            <div class="header align-items-center justify-content-center text-center">
                <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">
                    <div class="menu">
                        <div class="bar"></div>
                        <div class="bar"></div>
                        <div class="bar"></div>
                    </div>
                </button>     
                <p class="display-6 title mt-3 text-center">Professor's Account</p>
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
                    <li class="list-group-item mt-4"><a href="profMain.php">Dashboard</a></li>
                    <li class="list-group-item mt-4"><a href="studentList.php">Students</a></li>
                    <li class="list-group-item mt-4"><a href="sectList.php">Sections</a></li>
                    <li class="list-group-item mt-4"><a href="setGradeSubList.php">Set Grade</a></li>
                    <li class="list-group-item mt-4"><a href="gradingCriteria.php">Grade Criteria</a></li>
                    <li class="list-group-item mt-4"><a href="profilePage.php">Profile</a></li>
                    <li class="list-group-item  mt-4"><a href="../logOut.php" style="color: red">Log out</a></li>
                </ul>
            </div>
    </div>

    <?php
    session_start();
    // Check if the user is not logged in
    if (!isset($_SESSION['professorName'])) {
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

    // Retrieve professor's ID based on the logged-in username
    $professorName = $_SESSION['professorName'];
    $sqlProfID = "SELECT profID FROM professors WHERE lastName = '$professorName'";
    $resultProfID = $conn->query($sqlProfID);
    $rowProfID = $resultProfID->fetch_assoc();
    $profID = $rowProfID['profID'];

    // Query to get the number of students
    $sqlStudentsCount = "SELECT COUNT(*) AS studentsCount 
                        FROM students 
                        WHERE sectionID IN (SELECT sectionID FROM sectionssubjects WHERE subjectID IN (SELECT subjectID FROM subjects WHERE profID = '$profID'))";
    $resultStudentsCount = $conn->query($sqlStudentsCount);
    $rowStudentsCount = $resultStudentsCount->fetch_assoc();
    $studentsCount = $rowStudentsCount['studentsCount'];

    // Query to get the current semester
    $sqlCurrentSemester = "SELECT semesterName FROM semester WHERE semesterID = (SELECT MAX(semesterID) FROM sections)";
    $resultCurrentSemester = $conn->query($sqlCurrentSemester);
    $rowCurrentSemester = $resultCurrentSemester->fetch_assoc();
    $currentSemester = $rowCurrentSemester['semesterName'];

    // Query to get the total number of sections
    $sqlTotalSections = "SELECT COUNT(*) AS totalSections FROM sections WHERE sectionID IN (SELECT DISTINCT sectionID FROM sectionssubjects WHERE subjectID IN (SELECT subjectID FROM subjects WHERE profID = '$profID'))";
    $resultTotalSections = $conn->query($sqlTotalSections);
    $rowTotalSections = $resultTotalSections->fetch_assoc();
    $totalSections = $rowTotalSections['totalSections'];

    // Query to get the number of subjects
    $sqlSubjectsHolding = "SELECT COUNT(*) AS subjectsHolding FROM subjects WHERE profID = '$profID'";
    $resultSubjectsHolding = $conn->query($sqlSubjectsHolding);
    $rowSubjectsHolding = $resultSubjectsHolding->fetch_assoc();
    $subjectsHolding = $rowSubjectsHolding['subjectsHolding'];

    // Close the database connection
    $conn->close();
    ?>

    <div class="infos">
        <div class="block1 blocks">
            <p class="desc">Total Students:</p>
            <p class="studentsCount"><?php echo $studentsCount; ?></p>
        </div>
        <div class="block2 blocks">
        <p class="desc">Current Semester:</p>
            <p class="currentSem"><?php echo $currentSemester; ?></p>
        </div>
        <div class="block3 blocks">
        <p class="desc">Total Sections:</p>
            <p class="totalSections"><?php echo $totalSections; ?></p>
        </div>
        <div class="block4 blocks">
        <p class="desc">Total Subjects:</p>
            <p class="subjsHolding"><?php echo $subjectsHolding; ?></p>
        </div>
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script src="../studentAcc/jsFuncs.js"></script>
</body>
</html>