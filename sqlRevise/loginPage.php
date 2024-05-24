<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="loginStyles.css">
    <title>Log-in Page</title>
</head>
<body>
    <div class="container-fluid h-100">
        <div class="row h-100 align-items-center justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card bg-white">
                    <div class="card-body text-center">
                    <div class="circle mb-4">
                            <img src="tcuLogo.png" alt="TCU" class="img-fluid">
                        </div>
                        <h2 class="mb-4">BSIS A2023<br>Student's Grading System</h2>
                        <form action="storeAndVerify.php" method="post" class="forms">
                            <div class="mb-3">
                                <label for="name" class="form-label">User Name</label>
                                <input type="text" name="name" id="name" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" id="password" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-primary">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
