<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="subjStyles.css">
    <link rel="stylesheet" href="studentStyles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Subjects</title>
</head>
<body>
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
    ?>
    <div class="transBg"></div>
    <div class="abs">
        <img src="../tcuBg.jpeg" alt="TCU" srcset="">
    </div>
    <div class="header align-items-center justify-content-center">
            <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling" aria-controls="offcanvasScrolling">
                <div class="menu">
                    <div class="bar"></div>
                    <div class="bar"></div>
                    <div class="bar"></div>
                </div>
            </button>    
            <p class="display-6 title mt-3">Student's Account</p>
    </div>
    <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">
        <div class="menu">
            <div class="bar"></div>
            <div class="bar"></div>
            <div class="bar"></div>
        </div>
    </button>

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
    <div class="sub text-center">
        <p class="subTitle display-4">SUBJECT LIST</p>
    </div>
    
    <div class="gray">
        <table class = "subjTable table-striped" id ="subjTable">
            <thead>
                <tr>
                    <th>Subject</th>
                    <th>Professor</th>
                    <th>Units</th>
                </tr>
            </thead>
            <tbody>
                <?php include('fetchSubject.php'); ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="jsFuncs.js"></script>
</body>
</html>