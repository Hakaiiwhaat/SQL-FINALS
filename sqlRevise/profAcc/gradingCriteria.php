<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="profStyles.css">
    <link rel="stylesheet" href="gradingCriteriaStyles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Criteria</title>
</head>
<body>
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
    ?>
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
    <div class="sub">
        <p class="subTitle display-4">GRADING CRITERIA</p>
    </div>
    
    <div class="gray">
        <table class = "gradesTable" id ="gradesTable">
            <thead>
                <tr>
                    <th class="display-6">Score</th>
                    <th class="display-6">Grade Equivalent</th>
                </tr>
            </thead>
            <tbody>
               <tr>
                <td style="color:#A2FF86;">98 - 100</td>
                <td style="color:#A2FF86;">1.00</td>
               </tr>
               <tr>
                <td style="color:#A2FF86;">95 - 97</td>
                <td style="color:#A2FF86;">1.25</td>
               </tr>
               <tr>
                <td style="color:#A2FF86;">92 - 94</td>
                <td style="color:#A2FF86;">1.50</td>
               </tr>
               <tr>
                <td style="color:#FFF455;">89 - 91</td>
                <td style="color:#FFF455;">1.75</td>
               </tr>
               <tr>
                <td style="color:#FFF455;">86 - 88</td>
                <td style="color:#FFF455;">2.00</td>
               </tr>
               <tr>
                <td style="color:#FFC700;">83 - 85</td>
                <td style="color:#FFC700;">2.25</td>
               </tr>
               <tr>
                <td style="color:#DC6B19;">80 - 82</td>
                <td style="color:#DC6B19;">2.50</td>
               </tr>
               <tr>
                <td style="color:#DC6B19;">77 - 79</td>
                <td style="color:#DC6B19;">2.75</td>
               </tr>
               <tr>
                <td style="color:#E72929;">75 - 76</td>
                <td style="color:#E72929;">3.00</td>
               </tr>
               <tr>
                <td style="color:#E72929;">74 below</td>
                <td style="color:#E72929;">5.00</td>
               </tr>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="jsFuncs.js"></script>
</body>
</html>