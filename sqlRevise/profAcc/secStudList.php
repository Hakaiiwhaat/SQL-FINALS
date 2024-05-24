<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="profStyles.css">
    <link rel="stylesheet" href="sectStudListStyles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>Student's List</title>
    <script src="../studentAcc/jsFuncs.js"></script>
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
        <p class="display-6 title mt-3 text-center">Professor's Account</p>
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
    <div class="row justify-content-center align-items-center">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="searchBar">
                    <input type="text" name="query" placeholder="Enter Student No. or Name" value="<?php echo isset($_POST['query']) ? htmlspecialchars($_POST['query']) : ''; ?>">
                    <button type="submit" >Search</button>
            </form>
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
    $sectionID = $_SESSION['sectionID'];

    $sqlSectionID = "SELECT FROM sectionsession WHERE profID = '$profID' AND sectionID = '$sectionID'";

    // Retrieve the section ID from the URL parameter
    // $sectionID = isset($_GET['sectionID']) ? $_GET['sectionID'] : '';

    // Debugging: Output sectionID to check if it's retrieved correctly
    // echo "Section ID: $sectionID <br>";

    // Retrieve the search query from the POST parameter
    $search_query = isset($_POST['query']) ? $_POST['query'] : '';

    // Debugging: Output sectionID and search_query to check their values
    echo "Section ID: $sectionID <br>";
    echo "Search Query: $search_query <br>";

    // Query the database to fetch the students for the selected section
    if (!empty($search_query)) {
        $sql = "SELECT 
                    s.studentID, 
                    CONCAT(s.lastName, ', ', s.firstName) AS fullName, 
                    s.studNo, 
                    s.phoneNo, 
                    s.emailAdd,
                    sec.sectionName 
                FROM 
                    students AS s
                INNER JOIN 
                    sections AS sec ON '$sectionID' = sec.sectionID
                
                WHERE
                    s.sectionID = '$sectionID' AND (CONCAT(s.lastName, ', ', s.firstName) LIKE '%$search_query%' OR s.studNo LIKE '%$search_query%')";
    } else {
        $sql = "SELECT 
                    s.studentID, 
                    CONCAT(s.lastName, ', ', s.firstName) AS fullName, 
                    s.studNo, 
                    s.phoneNo, 
                    s.emailAdd,
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
    // Output the student list in a table
    echo "<table id='studTable'>";
    echo "<tr>
            <th>Name</th>
            <th>Section</th>
        </tr>";
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            // Add data attributes to store student information
            echo "<tr class='student-row' 
                    data-fullname='" . $row["fullName"] . "' 
                    data-studno='" . $row["studNo"] . "' 
                    data-phonenumber='" . $row["phoneNo"] . "' 
                    data-email='" . $row["emailAdd"] . "' 
                    data-section='" . $row["sectionName"] . "'>";
            echo "<td class='left'>" . $row["fullName"] . "</td>";
            echo "<td>" . $row["sectionName"] . "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='5'>No students found for the selected section.</td></tr>";
    }
    echo "</table>";

    // Close the database connection
    $conn->close();
    ?>

    <!-- Modal for displaying student details -->
    <div id="studentModal" class="modal text-center">
            <div class="modal-content">
                <span id="closeModal" class="close">&times;</span>
                <div id="studentDetails">
                    <p><strong>Name: </strong><span id="fullName"></span></p>
                    <p><strong>Student Number: </strong><span id="studNo"></span></p>
                    <p><strong>Phone Number: </strong><span id="phoneNo"></span></p>
                    <p><strong>Email Address: </strong><span id="email"></span></p>
                    <p><strong>Section: </strong><span id="section"></span></p>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
        // Get all table rows with class 'student-row'
        var studentRows = document.querySelectorAll(".student-row");

        // Add click event listener to each table row
        studentRows.forEach(function(row) {
            row.addEventListener("click", function() {
                // Get student information from data attributes
                var fullName = this.getAttribute("data-fullname");
                var studNo = this.getAttribute("data-studno");
                var phoneNo = this.getAttribute("data-phonenumber");
                var email = this.getAttribute("data-email");
                var section = this.getAttribute("data-section");

                // Display student information in a modal
                showModal(fullName, studNo, phoneNo, email, section);
            });
        });

        // Function to display student information in a modal
        function showModal(fullName, studNo, phoneNo, email, section) {
            // Replace the content of the modal with student information
            document.getElementById("fullName").textContent = fullName;
            document.getElementById("studNo").textContent = studNo;
            document.getElementById("phoneNo").textContent = phoneNo;
            document.getElementById("email").textContent = email;
            document.getElementById("section").textContent = section;

            // Display the modal
            document.getElementById("studentModal").style.display = "block";
        }

        // Close the modal when the close button is clicked
        document.getElementById("closeModal").addEventListener("click", function() {
            document.getElementById("studentModal").style.display = "none";
        });

        // Close the modal when the user clicks anywhere outside the modal
        window.addEventListener("click", function(event) {
            if (event.target == document.getElementById("studentModal")) {
                document.getElementById("studentModal").style.display = "none";
            }
        });
    });
    </script>
    <script src="highlightTableRow.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>
</html>