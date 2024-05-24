

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="profStyles.css">
    <link rel="stylesheet" href="studGradeStyles.css">
    <title>Set Grade</title>
    <script src="../studentAcc/jsFuncs.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

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
            <p class="display-6 title mt-3">Professor's Account</p>
        </div>
        <div class="welcome text-center">
            <p class="welc display-4">Student's List</p>
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
    </div>

    <div class="row justify-content-center align-items-center">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="searchBar">
                    <input type="text" name="query" placeholder="Enter Student No. or Name" value="<?php echo isset($_POST['query']) ? htmlspecialchars($_POST['query']) : ''; ?>">
                    <button type="submit" >Search</button>
            </form>
    </div>
    <div class="table">
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

    $profID = $_SESSION['professorID'];
    // Retrieve section ID and subject ID from URL parameters
    $sectionID = $_SESSION['sectionID'];
    $subjectID = $_SESSION['subjectID'];
    $_SESSION['sectionID'] = $sectionID;
    $_SESSION['subjectID'] = $subjectID;
    // Echo the subjectID for debugging purposes
    echo "Subject ID: " . $subjectID . "<br>";

    $sqlSectionID = "SELECT FROM sectionsession WHERE profID = '$profID' AND sectionID = '$sectionID'";

    // Retrieve the section ID from the URL parameter
    // $sectionID = isset($_GET['sectionID']) ? $_GET['sectionID'] : '';

    // Debugging: Output sectionID to check if it's retrieved correctly
    // echo "Section ID: $sectionID <br>";

    // Retrieve the search query from the POST parameter
    $search_query = isset($_POST['query']) ? $_POST['query'] : '';

    // Debugging: Output sectionID and search_query to check their values
    // echo "Section ID: $sectionID <br>";
    // echo "Search Query: $search_query <br>";

    // Query the database to fetch the students for the selected section
    if (!empty($search_query)) {
        $sql = "SELECT 
                    s.studentID, 
                    CONCAT(s.lastName, ', ', s.firstName) AS fullName, 
                    s.studNo, 
                    s.phoneNo, 
                    s.emailAdd,
                    s.sectionID,
                    sec.sectionName 
                FROM 
                    students AS s
                INNER JOIN 
                    sections AS sec ON '$sectionID' = sec.sectionID
                
                WHERE
                    s.sectionID = '$sectionID' AND
                    (CONCAT(s.lastName, ', ', s.firstName) LIKE '%$search_query%' OR s.studNo LIKE '%$search_query%')";
    } else {
        $sql = "SELECT 
                    s.studentID, 
                    CONCAT(s.lastName, ', ', s.firstName) AS fullName, 
                    s.studNo, 
                    s.phoneNo, 
                    s.emailAdd,
                    s.sectionID,
                    sec.sectionName
                FROM 
                    students AS s
                INNER JOIN 
                    sections AS sec ON '$sectionID' = sec.sectionID
                WHERE
                    s.sectionID = '$sectionID'";
    }

    // Debugging: Output the SQL query to check its correctness
    // echo "SQL Query: $sql <br>";

    $result = $conn->query($sql);

    // Error handling: Check if the query execution was successful
    if (!$result) {
        die("Error in SQL query: " . $conn->error);
    }
    // // Output the student list in a table
    echo "<table id='studTable'>";
    echo "<tr>
            <th>Name</th>
            <th>Section</th>
            <th>Set Grade</th>
        </tr>";
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td class='left'>".$row["fullName"]."</td>
                        <td>".$row["sectionName"]."</td>
                        <td>
                            <form class='gradeForm' action='setGrade.php' method='post'>
                                <input type='hidden' name='grades[".$row['studentID']."][studentID]' value='".$row['studentID']."'>
                                <input type='hidden' name='grades[".$row['studentID']."][sectionID]' value='".$row['sectionID']."'>
                                <input type='hidden' name='grades[".$row['studentID']."][subjectID]' value='".$subjectID."'>
                                <input type='number' name='grades[".$row['studentID']."][grade]' class='inputGrade' required>
                                <button type='submit' style='display: none;'>Apply</button>
                            </form>
                        </td>
                    </tr>";
            }
            
    } else {
    echo "<tr><td colspan='3'>No students found for the selected section.</td></tr>";
    }
    // Close the database connection
    $conn->close();
    ?>
        <tr class="retrieveGradesForm" id="retrieveGradesForm">
            <td colspan="3" class="text-center">
                <button type="submit" name="retrieveGradesBtn" id="retrieveGradesBtn" class="retrieveButton">Submit Grades</button>
            </td>
        </tr>
    
    </table>
    </div>
    
    <script>
        document.addEventListener("DOMContentLoaded", function() {
        // Function to submit all grade forms asynchronously
        function submitAllForms() {
            var allGradeForms = document.querySelectorAll('.gradeForm');
            var formDataArray = [];

            // Collect form data
            allGradeForms.forEach(function(form) {
                var formData = new FormData(form);
                formDataArray.push(formData);
            });

            // Send form data asynchronously
            formDataArray.forEach(function(formData) {
                fetch('setGrade.php', {
                    method: 'POST',
                    body: formData
                }).then(function(response) {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.text();
                }).then(function(data) {
                    console.log(data); // Log success response
                    // Optionally display success message to user
                })
            });
        }

        // Attach event listener to the "Submit Grades" button
        document.querySelector('#retrieveGradesBtn').addEventListener('click', function(event) {
            // Prevent default form submission
            event.preventDefault();

            // Call the function to submit all forms
            submitAllForms();

            // Show alert after submitting forms
            alert('Grades submitted successfully!');
            window.location.reload();
        });
    });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="highlightTableRow.js"></script>
</body>
</html>
