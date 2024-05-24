<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="profileStyles.css">
    <link rel="stylesheet" href="profStyles.css">
    <title>Profile</title>
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
            <p class="display-6 title mt-3">Professor's Account</p>
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
    $sqlProfID = "SELECT profID, lastName, firstName, middleName, emailAdd, phoneNo FROM professors WHERE lastName = '$professorName'";
    $resultProfID = $conn->query($sqlProfID);
    $profInfo = $resultProfID->fetch_assoc();
    $profID = $profInfo['profID'];
    $profLastName = $profInfo['lastName'];
    $profFirstName = $profInfo['firstName'];
    $profMiddleName = $profInfo['middleName'];
    $profEmailAdd = $profInfo['emailAdd'];
    $profPhoneNo = $profInfo['phoneNo'];

    // Close the database connection
    $conn->close();
    ?>
    <div class="subHeader d-flex justify-content-center">
        <p class="subTit display-4">PROFILE</p>
    </div>

    <div class="container d-flex justify-content-center">
        <div class="col-md-3  d-flex justify-content-center" style="width:100%"> 
            <div class="circle"></div>
        </div>
            <form action="updateProfile.php" method="post" class="updateStudent">
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" class="form-control" id="lName" name="lName" placeholder="Last Name" value="<?php echo $profLastName ?>">
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" id="fName" name="fName" placeholder="First Name" value="<?php echo $profFirstName ?>">
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" id="mName" name="mName" placeholder="Middle Name" value="<?php echo $profMiddleName ?>">
                    </div>
                </div>
                <div class="row justify-content-md-center">
                    <div class="col-md-4 row2">
                        <input type="text" class="form-control" id="phoNo" name="phoNo" placeholder="Phone Number" value="<?php echo $profPhoneNo ?>">
                    </div>
                    <div class="col-md-4 row2">
                        <input type="text" class="form-control" id="eMail" name="eMail" placeholder="Email Address" value="<?php echo $profEmailAdd ?>">
                    </div>
                </div>
                <button type="submit" class="btn change">Save Changes</button>
            </form>
    </div>

    <div class="changePass">
        <p id="clickable">Change password</p>
        <div class="transBlack" id="transBlack">
            <form action="changePass.php" method=post class="form">
                <p class="desc">Create a New Password</p>
                <p>Current Password</p>
                <input type="password" class="currentPassword" id="currentPassword" name="currentPassword" placeholder="Current Password">
                <p>New Password</p>
                <input type="password" class="newPassword" id="newPassword" name="newPassword" placeholder="New Password">
                <p>Confirm Password</p>
                <input type="password" class="confirmPassword" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password">
                <button type="submit" class="change change2">Confirm</button>
            </form>
            <p class="close" id="close">close</p>
        </div>
    </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Get references to the paragraph, password input, and close button
                var paragraph = document.getElementById('clickable');
                var passwordInput = document.getElementById('transBlack');
                var closeDiv = document.getElementById('close');

                // Hide the password input initially
                passwordInput.style.display = 'none';

                // Add click event listener to the paragraph
                paragraph.addEventListener('click', function() {
                    // Show the password input when paragraph is clicked
                    passwordInput.style.display = 'flex';
                    toggleBodyOverflow();
                });

                // Add click event listener to the close button
                closeDiv.addEventListener('click', function() {
                    // Hide the password input when close button is clicked
                    passwordInput.style.display = 'none';
                    toggleBodyOverflow();
                });

                // Function to toggle body overflow
                function toggleBodyOverflow() {
                    // Get the transBlack element
                    var transBlack = document.getElementById('transBlack');

                    // Check if transBlack is shown
                    var isTransBlackShown = (function() {
                        return transBlack.style.display === 'flex';
                    })();

                    // Set body overflow based on transBlack visibility
                    document.body.style.overflow = isTransBlackShown ? 'hidden' : 'auto';
                }


            });
        </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script src="jsFuncs.js"></script>
</body>
</html>