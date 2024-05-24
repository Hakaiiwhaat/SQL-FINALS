<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="profStyles.css">
    <link rel="stylesheet" href="setGradeSubStyles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>Subject List</title>
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
                    <input type="text" name="query" placeholder="Enter Subject" value="<?php echo isset($_POST['query']) ? htmlspecialchars($_POST['query']) : ''; ?>">
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
                    sn.sectionName,
                    sub.subName,
                    sub.subjectID
                FROM
                    sectionssubjects AS sec
                INNER JOIN
                    subjects AS sub ON sec.subjectID = sub.subjectID
                INNER JOIN
                    sections AS sn ON sec.sectionID = sn.sectionID
                WHERE
                    sub.profID = '$professorID' AND
                    sub.subName LIKE '%$search_query%'";
    } else {
        $sql = "SELECT
                    sec.sectionID,
                    sn.sectionName,
                    sub.subName,
                    sub.subjectID
                FROM
                    sectionssubjects AS sec
                INNER JOIN
                    subjects AS sub ON sec.subjectID = sub.subjectID
                INNER JOIN
                    sections AS sn ON sec.sectionID = sn.sectionID
                WHERE
                    sub.profID = '$professorID'";
    }
    
    
    $result = $conn->query($sql);
    
    // Display search results within a table
    echo "<table id='secTable'>";
    echo "<tr>
            <th>Subject</th>
            <th>Section</th>
        </tr>";
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Output the table row with subject name and section name
            echo "<tr>
            <td><a href='insert_section_id2.php?sectionID=".$row["sectionID"]."&subjectID=".$row["subjectID"]."'>".$row["subName"]."</a></td>
                    <td>".$row["sectionName"]."</td>
                </tr>";
        }
    } else {
        echo "<tr><td colspan='2'>No results found</td></tr>";
    }
    echo "</table>";
    ?>
    
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>
</html>