<?php
session_start();

include_once '../includes/functions.php';

if(isset($_SESSION["authen"]) && isset($_SESSION["uname"])){
    redirectURL('index.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel = "icon" href="../assets/image/logo.png" type = "image/x-icon">
    <title>Online Library System</title>

    <!-- Custom fonts for this template-->
    <link href="../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../assets/vendor/sb-admin-2/sb-admin-2.min.css" rel="stylesheet">
    <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/custom.css" rel="stylesheet">
    <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">

    <link href="../assets/vendor/dataTables/dataTables.bootstrap5.min.css" rel="stylesheet">

</head>

<body>
    <div class="d-flex justify-content-center mt-5">
        <form action="api/authenticate_user.php" class="row mt-5 shadow col-6 p-0" method="post">
            <div class="col-6 border bg-dark border-1 border-dark pb-5">
                <h4 class="text-light mt-2 text-center mt-5" style="font-size: 1.5rem !important;">Online Library System
                </h4>
                <p class="text-light mt-2 text-center">Librarian Login</p>
                <div class="d-flex justify-content-center mb-5">
                    <img src="../assets/image/logo.png" width="150" height="150" alt="logo">
                </div>
            </div>
            <div class="col-6 border border-1 border-dark">
                <div class="my-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" name="uname" class="form-control border border-dark" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="pass" class="form-control border border-dark" required>
                </div>
                <div class="mb-3">
                    <button name="login" class="btn btn-dark" type="submit">Log in</button>
                </div>
                    <?php

                    if(isset($_GET['error'])){
                        if($_GET['error']=='wrongpassword'){
                            echo '
                            <div class="mb-3">
                                <p class="alert alert-danger m-0 p-2">Wrong Password</p>
                            </div>
                            ';
                        }elseif($_GET['error']=='nouserfound'){
                            echo '
                            <div class="mb-3">
                                <p class="alert alert-danger m-0 p-2">Wrong Username</p>
                            </div>
                            ';
                        }elseif($_GET['error']=='accountdeactivated'){
                            echo '
                            <div class="mb-3">
                                <p class="alert alert-danger m-0 p-2">That account is deactivated</p>
                            </div>
                            ';
                        }else{
                            echo '
                            <div class="mb-3">
                                <p class="alert alert-danger m-0 p-2">Error, Please try again later.</p>
                            </div>
                            ';
                        }
                        
                    }
                    ?>
            </div>
        </form>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="../assets/vendor/jquery/jquery.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../assets/vendor/sb-admin-2/sb-admin-2.min.js"></script>

</body>

</html>