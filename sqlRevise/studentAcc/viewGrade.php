<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="studentStyles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="viewGradeStyles.css">
    <title>Grade</title>
</head>
<body>
    <div class="transBg"></div>
    <div class="abs">
        <img src="../tcuBg.jpeg" alt="TCU" srcset="">
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
    <div class="sub">
        <p class="subTitle  display-4">GRADES</p>
    </div>
    
    <div class="gray">

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

            $sql = "SELECT 
                s.subName, 
                s.units,
                CONCAT(pr.lastName, ', ', pr.firstName) AS fullName,
                gr.grade AS grade 
            FROM 
                subjects AS s
            INNER JOIN
                sectionssubjects AS ss ON s.subjectID = ss.subjectID
            INNER JOIN 
                students AS stu ON ss.sectionID = stu.sectionID
            INNER JOIN
                professors AS pr ON s.profID = pr.profID
            LEFT JOIN
                grades AS gr ON s.subjectID = gr.subjectID AND gr.studentID = '$studentID'
            WHERE
                stu.studentID = $studentID";

            // Debugging: Output the SQL query to check its correctness
            // echo "SQL Query: $sql <br>";

            $result = $conn->query($sql);

            // Error handling: Check if the query execution was successful
            if (!$result) {
                die("Error in SQL query: " . $conn->error);
            }
            // Output the student list in a table
            echo "<table id='gradesTable'>";
            echo "<tr>
                    <th>Subject</th>
                    <th>Professor</th>
                    <th>Units</th>
                    <th>Grade</th>
                </tr>";
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td class='left'>".$row["subName"]."</td>
                            <td class='left'>".$row["fullName"]."</td>
                            <td>".$row["units"]."</td>
                            <td>".$row["grade"]."</td>
                        </tr>";
                } 
            } else {
                echo "<tr><td colspan='5'>No students found for the selected section.</td></tr>";
            }
            echo "</table>";

            // Close the database connection
            $conn->close();
            ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script src="jsFuncs.js"></script>
</body>
</html>