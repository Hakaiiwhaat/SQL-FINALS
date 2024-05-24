<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="profStyles.css">
    <link rel="stylesheet" href="setGradeSectListStyles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="../studentAcc/jsFuncs.js"></script>
    <title>Sections</title>
</head>
<body>
    <div class="container-fluid">
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
            <p class="display-6 title mt-3">Professor's Account</p>
        </div>
        <div class="welcome text-center">
            <p class="welc display-4">Section's List</p>
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
                    <li class="list-group-item mt-4"><a href="setGradeSectList.php">Set Grade</a></li>
                    <li class="list-group-item mt-4"><a href="gradingCriteria.php">Grade Criteria</a></li>
                    <li class="list-group-item mt-4"><a href="profilePage.php">Profile</a></li>
                    <li class="list-group-item  mt-4"><a href="../logOut.php" style="color: red">Log out</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="row justify-content-center align-items-center">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="searchBar">
                    <input type="text" name="query" placeholder="Enter Student No. or Name" value="<?php echo isset($_POST['query']) ? htmlspecialchars($_POST['query']) : ''; ?>">
                    <button type="submit" >Search</button>
            </form>
    </div>

    <?php
    session_start();
    // Check if the user is not logged in
    if (!isset($_SESSION['professorName'])) {

        // Redirect to the login page
        header("Location: ../loginPage.php");
        exit; // Stop further execution
    }
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "gradingsystem";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    

    
    $search_query = isset($_POST['query']) ? $_POST['query'] : '';

    // Retrieve professor's ID from the session
    $professorID = $_SESSION['professorID'];

    if (!empty($search_query)) {
        $sql = "SELECT
                    sec.sectionID,
                    sec.sectionName,
                    sem.semesterName
                FROM
                    sections AS sec
                INNER JOIN
                    semester AS sem ON sec.semesterID = sem.semesterID
                INNER JOIN
                    sectionsSubjects AS ss ON sec.sectionID = ss.sectionID
                INNER JOIN
                    subjects AS subj ON ss.subjectID = subj.subjectID
                WHERE
                    subj.profID = '$professorID' AND
                    sec.sectionName LIKE '%$search_query%'";
    } else {
        $sql = "SELECT
                    sec.sectionID,
                    sec.sectionName,
                    sem.semesterName
                FROM
                    sections AS sec
                INNER JOIN
                    semester AS sem ON sec.semesterID = sem.semesterID
                INNER JOIN
                    sectionsSubjects AS ss ON sec.sectionID = ss.sectionID
                INNER JOIN
                    subjects AS subj ON ss.subjectID = subj.subjectID
                WHERE
                    subj.profID = '$professorID'";
    }
    $result = $conn->query($sql);

    // Display search results within a table
    echo "<table id='secTable'>";
    echo "<tr>
            <th>Section</th>
            <th>Semester</th>
        </tr>";
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Construct the URL dynamically for each section
            // $href = "setStudGrade.php?sectionID=" . $row["sectionID"];
            
            // Output the table row with a clickable section name
            echo "<tr>
                    <td><a href='insert_section_id2.php?sectionID=".$row["sectionID"]."'>".$row["sectionName"]."</a></td>
                    <td>".$row["semesterName"]."</td>
                </tr>";
        }
    }else {
        echo "<tr><td colspan='6'>No results found</td></tr>";
    }
    echo "</table>";
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>