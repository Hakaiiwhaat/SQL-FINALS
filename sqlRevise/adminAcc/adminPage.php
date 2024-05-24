<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="adminStyles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>Admin</title>
</head>
<body>
    
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
        <p class="display-5 title mt-3 text-center">Admin's Account</p>
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
            <li class="list-group-item mt-4"><a href="adminPage.php">Dashboard</a></li>
            <li class="list-group-item mt-4"><a href="allStudents.php">Students</a></li>
            <li class="list-group-item mt-4"><a href="allSections.php">Sections</a></li>
            <li class="list-group-item mt-4"><a href="gradingCriteria.php">Grade Criteria</a></li>
            <li class="list-group-item  mt-4"><a href="../logOut.php" style="color: red">Log out</a></li>
        </ul>
        </div>
    </div>

    <div class="infos">
        <div class="block1 blocks">
            <p class="desc">Add/Delete <br> Student</p>
        </div>
        <div class="block2 blocks">
            <p class="desc">Add/Delete <br> Professor</p>
        </div>
        <div class="block3 blocks">
            <p class="desc">Add/Delete <br> Subject</p>
        </div>
        <div class="block4 blocks">
            <p class="desc">Add/Delete <br> Section</p>
        </div>
        <div class="block5 blocks">
            <p class="desc">Add/Delete <br> Professor Account</p>
        </div>
        <div class="block6 blocks">
            <p class="desc">Add/Delete <br>Student Account</p>
        </div>
        <div class="block7 blocks">
            <p class="desc">Assign/Unassign <br>Subject</p>
        </div>
        <div class="block8 blocks">
            <p class="desc">Change <br>Semester</p>
        </div>
    </div>

    <?php
        session_start();
        // Check if the user is not logged in
        if (!isset($_SESSION['adminName'])) {
            // Set a session variable to indicate the alert message
            $_SESSION['login_alert'] = 'You are not logged in!';
    
            // Redirect to the login page
            header("Location: ../loginPage.php");
            exit; // Stop further execution
        }

        // Database connection parameters
    $servername = "localhost"; 
    $username = "root"; 
    $password = ""; 
    $database = "gradingsystem";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve available sections
    $sectionQuery = "SELECT sectionID, sectionName FROM sections";
    $sectionResult = $conn->query($sectionQuery);

    // Retrieve available year levels
    $yearQuery = "SELECT yearID, yearLevel FROM yearlevel";
    $yearResult = $conn->query($yearQuery);

    //Retrive available subjects
    $subjectQuery = "SELECT subjectID, subName, units, profID FROM subjects";
    $subjectResult = $conn->query($subjectQuery);

    // Retrieve available sections
    $sectionQuery2 = "SELECT sectionID, sectionName FROM sections";
    $sectionResult2 = $conn->query($sectionQuery2);

    // Retrieve available sections
    $sectionQuery3 = "SELECT sectionID, sectionName FROM sections";
    $sectionResult3 = $conn->query($sectionQuery3);

    //Retrieve availabe professors
    $professorQuery = "SELECT profID, CONCAT(lastName, ', ', firstName) AS fullName FROM professors";
    $professorResult = $conn->query($professorQuery);
    

    //Retrieve availabe professors for prof acc
    $profAccQuery = "SELECT profID, CONCAT(lastName, ', ', firstName) AS fullName FROM professors";
    $profAccResult = $conn->query($profAccQuery);

    //Retrieve availabe students
    $studAccQuery = "SELECT studentID, CONCAT(lastName, ', ', firstName) AS fullName FROM students";
    $studAccResult = $conn->query($studAccQuery);

    //Retrievesemesters
    $semesterQuery2 = "SELECT semesterID, semesterName FROM semester";
    $semesterResult2 = $conn->query($semesterQuery2);

    //Retrieve availabe sections
    $semesterQuery = "SELECT semesterID, semesterName FROM semester";
    $semesterResult = $conn->query($semesterQuery);
    if ($sectionResult->num_rows > 0) {
        echo "Rows founds!";
    } else {
        echo "No rows found.";
    }
    ?>

    <!-- <p id="clickable">Change password</p> -->
    <div class="transBlack" id="transBlack1" style="display: none;">
    <form method="post" class="form" style="top: -2em">
        <p class="desc2">Add New Student</p>
        <p class="text-center" style="font-size:.8em">To delete, please fill out the student number.</p>
        <div class="row">
            <!-- <p>Last Name</p> -->
            <input type="text" class="lastName" id="lastName" name="lastName" placeholder="Last Name">
            <!-- <p>First Name</p> -->
            <input type="text" class="firstName" id="firstName" name="firstName" placeholder="First Name">
            <!-- <p>Middle Name</p> -->
            <input type="text" class="middleName" id="middleName" name="middleName" placeholder="Middle Name">
            <!-- <p>Student Number</p> -->
            <input type="text" class="studNo" id="studNo" name="studNo" placeholder="Student No">
        </div>
        
        <p>Email Address</p>
        <input type="text" class="emailAdd" id="emailAdd" name="emailAdd" placeholder="Email Address">
        <p>phone Number</p>
        <input type="text" class="phoneNo" id="phoneNo" name="phoneNo" placeholder="Phone Number">
        <!-- Section dropdown -->
    <p>Section</p>
    <select name="sectionName" id="sectionName">
        <?php
        // Populate section options
        if ($sectionResult->num_rows > 0) {
            while ($row = $sectionResult->fetch_assoc()) {
                echo '<option value="' . $row['sectionID'] . '">' . $row['sectionName'] . '</option>';
            }
        } else {
            echo '<option value="">No sections available</option>';
        }
        ?>
    </select>

    <!-- Year level dropdown -->
    <p>Year Level</p>
    <select name="yearLevel" id="yearLevel">
        <?php
        // Populate year level options
        if ($yearResult->num_rows > 0) {
            while ($row = $yearResult->fetch_assoc()) {
                echo '<option value="' . $row['yearID'] . '">' . $row['yearLevel'] . '</option>';
            }
        } else {
            echo '<option value="">No year levels available</option>';
        }
        ?>
    </select>
    <div class="buttons">
        <button type="submit" class="change" style="width: 8em; right:2.5em;" value="Add Student">Add Student</button>
        <button type="submit" class="delete" value="Delete Student">Delete Student</button>
    </div>
        
    </form>
    <p class="close" data-target="transBlack1" style="top:-12em">close</p>
</div>

<div class="transBlack" id="transBlack2" style="display: none;">
    <form  method="post" class="form" style="top: -2em">
        <p class="desc2">Add New Professor</p>
        <p class="text-center" style="font-size:.8em">To delete, please fill out all fields.</p>
        <div class="row">
            <!-- <p>Last Name</p> -->
            <input type="text" class="lastName" id="lastName" name="lastName" placeholder="Last Name">
            <!-- <p>First Name</p> -->
            <input type="text" class="firstName" id="firstName" name="firstName" placeholder="First Name">
            <!-- <p>Middle Name</p> -->
            <input type="text" class="middleName" id="middleName" name="middleName" placeholder="Last Name">       
        </div>
        
        <p>Email Address</p>
        <input type="text" class="emailAdd" id="emailAdd" name="emailAdd" placeholder="Email Address">
        <p>phone Number</p>
        <input type="text" class="phoneNo" id="phoneNo" name="phoneNo" placeholder="Phone Number">
        <!-- Section dropdown -->
        <!-- <p>Subject Assigned</p>
        <select name="subName" id="subName">
            <?php
            // // Populate subject options
            // if ($subjectResult->num_rows > 0) {
            //     while ($row = $subjectResult->fetch_assoc()) {
            //         echo '<option value="' . $row['subjectID'] . '">' . $row['subName'] . '</option>';
            //     }
            // } else {
            //     echo '<option value="">No sections available</option>';
            // }
            ?>
        </select> -->
        <div class="buttons">
            <button type="submit" class="change" style="width: 9em; right:3em;" value="Add Professor">Add Professor</button>
            <button type="submit" class="delete" value="Delete Professor">Delete Professor</button>
        </div>
        
    </form>
    <p class="close" data-target="transBlack2" style="top: -15em;">close</p>
</div>

<div class="transBlack" id="transBlack5" style="display: none;">
    <form  method="post" class="form">
        <p class="desc2">Add Professor Account</p>
        <p class="text-center" style="font-size:.8em">To delete, please select professor name using the dropdown option.</p>
        <div class="row">
            <!-- <p>Last Name</p> -->
            <input type="text" class="profUser" id="profUser" name="profUser" placeholder="User Name">
            <!-- <p>First Name</p> -->
            <input type="text" class="profPass" id="profPass" name="profPass" placeholder="Password">
        </div>
        
        <p class="desc2">Professor Assigned</p>
        <select name="fullName" id="fullName">
            <?php
            // Populate subject options
            if ($profAccResult->num_rows > 0) {
                while ($row = $profAccResult->fetch_assoc()) {
                    echo '<option value="' . $row['profID'] . '">' . $row['fullName'] . '</option>';
                }
            } else {
                echo '<option value="">No sections available</option>';
            }
            ?>
        </select>
        <div class="buttons">
            <button type="submit" class="change" style="width: 9em; right:3em;" value="Add Prof Account">Add Account</button>
            <button type="submit" class="delete" value="Delete Prof Account">Delete Account</button>
        </div>
        
    </form>
    <p class="close" data-target="transBlack5" style="top: -15em;">close</p>
</div>

<div class="transBlack" id="transBlack3" style="display: none;">
<form method="post" class="form" >
    <div class="subName" style="display:flex; flex-direction:column; position:relative; justify-content: center; align-items: center;">
        <p class="desc2">Subject Name</p>
        <p class="text-center" style="font-size:.8em">To delete, please fill out the subject name.</p>
        <input type="text" class="subName" id="subName" name="subName" placeholder="Subject Name">
        <p>Number of Units</p>
        <input type="number" class="units" id="units" name="units" placeholder="Number of Units">
    </div>

    <p>Professor Assigned</p>
    <select name="profName" id="profName">
        <?php
        // Populate prof options
        if ($professorResult->num_rows > 0) {
            while ($row = $professorResult->fetch_assoc()) {
                echo '<option value="' . $row['profID'] . '">' . $row['fullName'] . '</option>';
            }
        } else {
            echo '<option value="">No professors available</option>';
        }
        ?>
    </select>
    <p>Section Assigned</p>
    <select name="sectionName" id="sectionName">
        <?php
        // Populate section options
        if ($sectionResult2->num_rows > 0) {
            while ($row = $sectionResult2->fetch_assoc()) {
                echo '<option value="' . $row['sectionID'] . '">' . $row['sectionName'] . '</option>';
            }
        } else {
            echo '<option value="">No sections available</option>';
        }
        ?>
    </select>
    <div class="buttons">
    <button type="submit" class="change" style="right: 1em; width: 3.5em;" value="Add Subject">Add</button>
        <button type="submit" class="delete" style="right: 1em;" value="Delete Subject">Delete</button>
    </div>
    
</form>
<p class="close" data-target="transBlack3" style="top: -15em;">close</p>
</div>

<div class="transBlack" id="transBlack4" style="display: none;">
    <form  method="post" class="form" style="top: -2em">
        <p class="desc2">Add New Section</p>
        <p class="text-center" style="font-size:.8em">To delete, please fill out the section name.</p>
        <div class="row">
            <!-- <p>Last Name</p> -->
            <input type="text" class="sectName" id="sectName" name="sectName" placeholder="Section Name">
        </div>
        <p>Semester Assigned</p>
        <select name="semesterName" id="semesterName">
            <?php
            // Populate semester options
            if ($semesterResult->num_rows > 0) {
                while ($row = $semesterResult->fetch_assoc()) {
                    echo '<option value="' . $row['semesterID'] . '">' . $row['semesterName'] . '</option>';
                }
            } else {
                echo '<option value="">No semester available</option>';
            }
            ?>
        </select>
        <div class="buttons">
            <button type="submit" class="change" style="width: 9em; right:3em;" value="Add Section">Add Section</button>
            <button type="submit" class="delete" value="Delete Section">Delete Section</button>
        </div>
        
    </form>
    <p class="close" data-target="transBlack4" style="top: -15em;">close</p>
</div>

<div class="transBlack" id="transBlack6" style="display: none;">
    <form  method="post" class="form">
        <p class="desc2">Add Student Account</p>
        <p class="text-center" style="font-size:.8em">To delete, please select student name using the dropdown option.</p>
        <div class="row">
            <!-- <p>Last Name</p> -->
            <input type="text" class="studUser" id="studUser" name="studUser" placeholder="User Name">
            <!-- <p>First Name</p> -->
            <input type="text" class="studPass" id="studPass" name="studPass" placeholder="Password">
        </div>
        
        <p class="desc2">Student Assigned</p>

        <label for="studentName">Choose student:</label>
        <input id="studentName" name="studentName" placeholder="Type here..." list="students">
        <datalist id="students">
        <?php
            // Check if there are rows returned
            if ($studAccResult->num_rows > 0) {
                // Loop through each row to generate options
                while ($row = $studAccResult->fetch_assoc()) {
                    // Output an option element for each student
                    echo '<option value="' . $row['fullName'] . '">' . $row['studentID'] . '</option>';
                }
            } else {
                // If no rows returned, display a default option
                echo '<option value="">No students available</option>';
            }
            ?>
        </datalist>
        <div class="buttons">
            <button type="submit" class="change" style="width: 9em; right:3em;" value="Add Stud Account">Add Account</button>
            <button type="submit" class="delete" value="Delete Stud Account">Delete Account</button>
        </div>
        
    </form>
    <p class="close" data-target="transBlack6" style="top: -15em;">close</p>
</div>

<div class="transBlack" id="transBlack7" style="display: none;">
    <form method="post" class="form" style="top:2em">
    <div class="subName" style="display:flex; flex-direction:column; position:relative; justify-content: center; align-items: center;">
        <p class="desc2">Choose Subject</p>
        <p>To delete, please fill out both fields.</p>
        <select name="subName" id="subName">
            <?php
            // Populate sub options
            if ($subjectResult->num_rows > 0) {
                while ($row = $subjectResult->fetch_assoc()) {
                    echo '<option value="' . $row['subjectID'] . '">' . $row['subName'] . '</option>';
                }
            } else {
                echo '<option value="">No subjects available</option>';
            }
            ?>
        </select>
        <p>Section Assigned</p>
        <select name="sectionName" id="sectionName">
            <?php
            // Populate section options
            if ($sectionResult3->num_rows > 0) {
                while ($row = $sectionResult3->fetch_assoc()) {
                    echo '<option value="' . $row['sectionID'] . $row['sectionName'] .'">' . $row['sectionName'] . '</option>';
                }
            } else {
                echo '<option value="">No sections available</option>';
            }
            ?>
        </select>
        <div class="buttons">
        <button type="submit" class="change" style="right: 1em; width: 9em;" value="Assign">Assign</button>
        <button type="submit" class="delete" value="Unassign">Unassign</button>
        </div>
    </div>
</form>
<p class="close" data-target="transBlack7" >close</p>
</div>

<div class="transBlack" id="transBlack8" style="display: none;">
    <form method="post" class="form changeSem" id="changeSem" style="top:7em">
    <div class="subName" style="display:flex; flex-direction:column; position:relative; justify-content: center; align-items: center;">
        <p class="desc2">Change Semester for all Sections</p>
        <select name="semesterName" id="semesterName">
            <?php
            // Populate semester options
            if ($semesterResult2->num_rows > 0) {
                while ($row = $semesterResult2->fetch_assoc()) {
                    echo '<option value="' . $row['semesterID'] . '">' . $row['semesterName'] . '</option>';
                }
            } else {
                echo '<option value="">No semester available</option>';
            }
            ?>
        </select>
        <div class="buttons">
            <button type="submit" class="change" style="right: 1em; width: 9em;" value="Change Semester">Change Semester</button>
        </div>
    </div>
    </form>
    <p class="close changeClose"  id ="changeClose" data-target="transBlack8" style="top: -10em">close</p>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get references to the blocks and forms
        var block1 = document.querySelector('.block1');
        var block2 = document.querySelector('.block2');
        var block3 = document.querySelector('.block3');
        var block4 = document.querySelector('.block4');
        var block5 = document.querySelector('.block5');
        var block6 = document.querySelector('.block6');
        var block7 = document.querySelector('.block7');
        var block8 = document.querySelector('.block8');
        var addToDatabase1 = document.getElementById('transBlack1');
        var addToDatabase2 = document.getElementById('transBlack2');
        var addToDatabase3 = document.getElementById('transBlack3');
        var addToDatabase4 = document.getElementById('transBlack4');
        var addToDatabase5 = document.getElementById('transBlack5');
        var addToDatabase6 = document.getElementById('transBlack6');
        var addToDatabase7 = document.getElementById('transBlack7');
        var addToDatabase8 = document.getElementById('transBlack8');

        // Hide the forms initially
        addToDatabase1.style.display = 'none';
        addToDatabase2.style.display = 'none';
        addToDatabase3.style.display = 'none';
        addToDatabase4.style.display = 'none';
        addToDatabase5.style.display = 'none';
        addToDatabase6.style.display = 'none';
        addToDatabase7.style.display = 'none';
        addToDatabase8.style.display = 'none';

        // Function to toggle body overflow
        function toggleBodyOverflow() {
            // Check if any transBlack is shown
            var isTransBlackShown = [addToDatabase1, addToDatabase2, addToDatabase3,  addToDatabase4, addToDatabase5, addToDatabase6, addToDatabase7, addToDatabase8].some(function(transBlack) {
                return transBlack.style.display === 'grid';
            });

            // Set body overflow based on transBlack visibility
            document.body.style.overflow = isTransBlackShown ? 'hidden' : 'auto';
        }

        // Function to toggle transBlack display
        function toggleTransBlack(transBlack) {
            if (transBlack) {
                transBlack.style.display = transBlack.style.display === 'grid' ? 'none' : 'grid';
                toggleBodyOverflow(); // Toggle body overflow when transBlack is shown/hidden
            }
        }

        // Add click event listeners to blocks
        block1.addEventListener('click', function() {
            // Show form for block1
            toggleTransBlack(addToDatabase1);
        });

        block2.addEventListener('click', function() {
            // Show form for block2
            toggleTransBlack(addToDatabase2);
        });

        block3.addEventListener('click', function() {
            // Show form for block3
            toggleTransBlack(addToDatabase3);
        });
        block4.addEventListener('click', function() {
            toggleTransBlack(addToDatabase4);
        })

        block5.addEventListener('click', function() {
            toggleTransBlack(addToDatabase5);
        })

        block6.addEventListener('click', function() {
            toggleTransBlack(addToDatabase6);
        })

        block7.addEventListener('click', function() {
            toggleTransBlack(addToDatabase7);
        })

        block8.addEventListener('click', function() {
            toggleTransBlack(addToDatabase8);
        })

        // Add click event listeners to close buttons
        document.querySelectorAll('.close').forEach(function(closeDiv) {
            closeDiv.addEventListener('click', function() {
                // Hide the corresponding form when close button is clicked
                var targetId = this.getAttribute('data-target');
                var transBlack = document.getElementById(targetId);
                toggleTransBlack(transBlack);
            });
        });

        // Add submit event listener to the form
        document.querySelectorAll('.form').forEach(function(form) {
            form.addEventListener('submit', function(event) {
                event.preventDefault(); // Prevent default form submission

                // Get the clicked button value
                var action = event.submitter.value;

                // Perform action based on the clicked button value
                switch (action) {
                    case 'Add Student':
                        fetch('addStudent.php', {
                            method: 'POST',
                            body: new FormData(form)
                        })
                        .then(response => response.text())
                        .then(data => {
                            console.log(data);
                            alert(data);
                            window.location.reload(); 
                        })
                        .catch(error => console.error('Error:', error));
                        break;
                    case 'Add Professor':
                        fetch('addProfessor.php', {
                            method: 'POST',
                            body: new FormData(form)
                        })
                        .then(response => response.text())
                        .then(data => {
                            console.log(data);
                            alert(data);
                            window.location.reload(); 
                        })
                        .catch(error => console.error('Error:', error));
                        break;
                    case 'Add Subject':
                        fetch('addSubject.php', {
                            method: 'POST',
                            body: new FormData(form)
                        })
                        .then(response => response.text())
                        .then(data => {
                            console.log(data);
                            alert(data);
                            window.location.reload(); 
                        })
                        .catch(error => console.error('Error:', error));
                        break;
                    case 'Add Section':
                        fetch('addSection.php', {
                            method: 'POST',
                            body: new FormData(form)
                        })
                        .then(response => response.text())
                        .then(data => {
                            console.log(data);
                            alert(data);
                            window.location.reload(); 
                        })
                        .catch(error => console.error('Error:', error));
                        break;
                    case 'Add Prof Account':
                        fetch('addProfAcc.php', {
                            method: 'POST',
                            body: new FormData(form)
                        })
                        .then(response => response.text())
                        .then(data => {
                            console.log(data);
                            alert(data);
                            window.location.reload(); 
                        })
                        .catch(error => console.error('Error:', error));
                        break;
                    case 'Add Stud Account':
                        fetch('addStudAcc.php', {
                            method: 'POST',
                            body: new FormData(form)
                        })
                        .then(response => response.text())
                        .then(data => {
                            console.log(data);
                            alert(data);
                            window.location.reload(); 
                        })
                        .catch(error => console.error('Error:', error));
                        break;
                    case 'Assign':
                        fetch('assignSub.php', {
                            method: 'POST',
                            body: new FormData(form)
                        })
                        .then(response => response.text())
                        .then(data => {
                            console.log(data);
                            alert(data);
                            window.location.reload(); 
                        })
                        .catch(error => console.error('Error:', error));
                        break;
                    case 'Change Semester':
                        fetch('changeSem.php', {
                            method: 'POST',
                            body: new FormData(form)
                        })
                        .then(response => response.text())
                        .then(data => {
                            console.log(data);
                            alert(data);
                            window.location.reload(); 
                        })
                        .catch(error => console.error('Error:', error));
                        break;
                    case 'Delete Subject':
                        // Retrieve the professor data from the form
                        var subName = form.querySelector('#subName').value;

                        // Display confirmation alert
                        if (confirm('Are you sure you want to delete this subject?')) {
                            // Proceed with deletion
                            fetch('deleteSubject.php', {
                                method: 'POST',
                                body: new FormData(form)
                            })
                            .then(response => response.text())
                            .then(data => {
                                console.log(data);
                                alert(data);
                                window.location.reload();
                            })
                            .catch(error => console.error('Error:', error));
                        }
                        break;
                    case 'Delete Student':
                        // Retrieve the student number from the form
                        var studNo = form.querySelector('#studNo').value;

                        // Display confirmation alert
                        if (confirm('Are you sure you want to delete this student?')) {
                            // Proceed with deletion
                            fetch('deleteStudent.php', {
                                method: 'POST',
                                body: new FormData(form)
                            })
                            .then(response => response.text())
                            .then(data => {
                                console.log(data);
                                alert(data);
                                window.location.reload();
                            })
                            .catch(error => console.error('Error:', error));
                        }
                        break;
                    case 'Delete Professor':
                        // Retrieve the professor data from the form
                        var lastName = form.querySelector('#lastName').value;
                        var firstName = form.querySelector('#firstName').value;
                        var emailAdd = form.querySelector('#emailAdd').value;
                        var phoneNo = form.querySelector('#phoneNo').value;

                        // Display confirmation alert
                        if (confirm('Are you sure you want to delete this professor?')) {
                            // Proceed with deletion
                            fetch('deleteProfessor.php', {
                                method: 'POST',
                                body: new FormData(form)
                            })
                            .then(response => response.text())
                            .then(data => {
                                console.log(data);
                                alert(data);
                                window.location.reload();
                            })
                            .catch(error => console.error('Error:', error));
                        }
                        break;
                    case 'Delete Section':
                        // Retrieve the student number from the form
                        var sectName = form.querySelector('#sectName').value;

                        // Display confirmation alert
                        if (confirm('Are you sure you want to delete this section?')) {
                            // Proceed with deletion
                            fetch('deleteSection.php', {
                                method: 'POST',
                                body: new FormData(form)
                            })
                            .then(response => response.text())
                            .then(data => {
                                console.log(data);
                                alert(data);
                                window.location.reload();
                            })
                            .catch(error => console.error('Error:', error));
                        }
                        break;
                    case 'Delete Prof Account':
                        // Retrieve the student number from the form
                        var fullName = form.querySelector('#fullName').value;

                        // Display confirmation alert
                        if (confirm('Are you sure you want to delete this account?')) {
                            // Proceed with deletion
                            fetch('deleteProfAcc.php', {
                                method: 'POST',
                                body: new FormData(form)
                            })
                            .then(response => response.text())
                            .then(data => {
                                console.log(data);
                                alert(data);
                                window.location.reload();
                            })
                            .catch(error => console.error('Error:', error));
                        }
                        break;
                    case 'Delete Stud Account':
                        // Retrieve the student number from the form
                        var studentName = form.querySelector('#studentName').value;

                        // Display confirmation alert
                        if (confirm('Are you sure you want to delete this account?')) {
                            // Proceed with deletion
                            fetch('deleteStudAcc.php', {
                                method: 'POST',
                                body: new FormData(form)
                            })
                            .then(response => response.text())
                            .then(data => {
                                console.log(data);
                                alert(data);
                                window.location.reload();
                            })
                            .catch(error => console.error('Error:', error));
                        }
                        break;
                    case 'Unassign':
                        // Display confirmation alert
                        if (confirm('Are you sure you want to unassign this subject?')) {
                            // Proceed with deletion
                            fetch('unassignSub.php', {
                                method: 'POST',
                                body: new FormData(form)
                            })
                            .then(response => response.text())
                            .then(data => {
                                console.log(data);
                                alert(data);
                                window.location.reload();
                            })
                            .catch(error => console.error('Error:', error));
                        }
                        break;
                    default:
                        break;
                }
            });
        });

    });
</script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script src="../studentAcc/jsFuncs.js"></script>
</body>
</html>