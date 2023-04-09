<?php

    session_start();

    $active = 'transaction';
    include_once "../includes/conn.php";
    include_once "../includes/functions.php";


    if(isset($_SESSION["authen"])){
        if($_SESSION["authen"]!=TRUE){
            redirectURL('../login.php');
        }else{
            $uname = $_SESSION["uname"];
            $librarian_id = $_SESSION["librarian_id"];
        }
    }else{
        redirectURL('login.php');
    }

    $sql = 'SELECT * FROM catalog_table ORDER BY catalog_book_title ASC';
    $statement = $pdo->prepare($sql);
    $statement->execute();
    $catalogs = $statement->fetchAll();

    $sql2 = 'SELECT * FROM borrower_table WHERE borrower_status = "accepted" ORDER BY borrower_fname ASC';
    $statement2 = $pdo->prepare($sql2);
    $statement2->execute();
    $borrowers = $statement2->fetchAll();
    


?>







<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../assets/image/logo.png" type="image/x-icon">
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

    <script src="../assets/vendor/jquery/jquery.min.js"></script>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-dark sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
                <div class="sidebar-brand-text mx-3">
                    <h6>Online Library System</h6>
                </div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li <?php
                    if($active == 'dashboard'){ 
                        echo 'class="nav-item active"';
                    }else{
                        echo 'class="nav-item"';
                    }
                ?>>
                <a class="nav-link" href="index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- nav item borrower -->
            <li <?php
                    if($active == 'borrower'){ 
                        echo 'class="nav-item active"';
                    }else{
                        echo 'class="nav-item"';
                    }
                ?>>
                <a class="nav-link" href="borrower.php">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Borrower</span>
                </a>
            </li>

            <!-- nav item transaction -->
            <li <?php
                    if($active == 'transaction'){ 
                        echo 'class="nav-item active"';
                    }else{
                        echo 'class="nav-item"';
                    }
                ?>>
                <a class="nav-link" href="transaction.php">
                    <i class="fas fa-fw fa-plus"></i>
                    <span>Add Transaction</span>
                </a>
            </li>

            <li <?php
                    if($active == 'return-book'){ 
                        echo 'class="nav-item active"';
                    }else{
                        echo 'class="nav-item"';
                    }
                ?>>
                <a class="nav-link" href="return_book.php">
                    <i class="fas fa-fw fa-book"></i>
                    <span>Return Book</span>
                </a>
            </li>

            <!-- nav item catalog -->
            <li <?php
                    if($active == 'transaction-table'){ 
                        echo 'class="nav-item active"';
                    }else{
                        echo 'class="nav-item"';
                    }
                ?>>
                <a class="nav-link" href="transaction_table.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Transaction Table</span>
                </a>
            </li>



            <!-- nav item catalog -->
            <li <?php
                    if($active == 'catalog'){ 
                        echo 'class="nav-item active"';
                    }else{
                        echo 'class="nav-item"';
                    }
                ?>>
                <a class="nav-link" href="catalog.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Catalog Table</span>
                </a>
            </li>

            <!-- nav item catalog -->
            <li <?php
                    if($active == 'librarian-table'){ 
                        echo 'class="nav-item active"';
                    }else{
                        echo 'class="nav-item"';
                    }
                ?>>
                <a class="nav-link" href="librarian_table.php">
                    <i class="fas fa-fw fa-user"></i>
                    <span>Librarian Table</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-light d-md-none mx-2 ">
                        <i class="fa fa-bars"></i>
                    </button>



                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <?php
                            if(isset($librarian_id)){
                                //fetch librarian information
                                $sql = 'SELECT * FROM librarian_table WHERE librarian_id = ?';
                                $statement = $pdo->prepare($sql);
                                $statement->execute(array($librarian_id));
                                $librarian_data = $statement->fetch();
                            }else{
                                $librarian_data = array(
                                    'librarian_image_name'=>'admin',
                                    'librarian_uname'=>'admin'
                                );
                            }

                        ?>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <span class="nav-link dropdown-toggle">
                                <span
                                    class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $librarian_data['librarian_uname'] ?></span>
                                <img class="img-profile rounded-circle"
                                    src="../assets/image/idpictures/<?php echo $librarian_data['librarian_image_name'] ?>">
                            </span>
                        </li>
                        <div class="topbar-divider d-none d-sm-block"></div>
                        <li class="nav-item">
                            <button type="button" class="nav-link btn mr-4" data-bs-toggle="modal"
                                data-bs-target="#modalLogout">
                                <strong><i class="bi-box-arrow-right text-dark"></i></strong>
                            </button>
                            <!-- logout modal -->
                            <div class="modal fade" id="modalLogout" tabindex="-1" aria-labelledby="exampleModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Logout</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure you want to logout?
                                        </div>
                                        <div class="modal-footer">
                                            <form action="logout.php" method="post">
                                                <button type="submit" class="btn btn-success">Yes</button>
                                            </form>
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end logout modal -->
                        </li>


                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">














                    <!---------------->
                    <!-- START BODY -->
                    <!---------------->

                    <div class="m-4">
                        <div class="row">
                            <div class="form col-12 mb-4">
                                <div
                                    class="border-left-primary border-top border-right border-bottom p-3 shadow rounded">
                                    <form action="api/add_transaction.php" method="POST">
                                        <h5 class="modal-title" id="exampleModalLabel">Add Transaction</h5>
                                        <hr>

                                        <?php

                    if(isset($_GET['add'])){
                        if($_GET['add']=='success'){
                            echo '
                            <div class="alert alert-success">
                                Transaction has been successfully added.
                            </div>
                            ';
                        }
                        if($_GET['add']=='error'){

                            if(isset($_GET['borrower'])){
                                if($_GET['borrower']=="rejected"){
                                    echo '
                                    <div class="alert alert-danger">
                                        Error, borrower is rejected!
                                    </div>
                                    ';
                                }
                                    
                            }
                            if(isset($_GET['mailer'])){
                                echo '
                                    <div class="alert alert-danger">
                                        Transaction added, but we were unable to send an email at this time; please check your internet connection.
                                    </div>
                                    ';
                            }
                            if(isset($_GET['error'])){
                                if($_GET['error']=='book1'){
                                    echo '
                                    <div class="alert alert-danger">
                                        Error, Book ID not found!
                                    </div>
                                    ';
                                }elseif($_GET['error']=='borrower'){
                                    echo '
                                    <div class="alert alert-danger">
                                        Error, Borrower ID not found!
                                    </div>
                                    ';
                                }
                                
                                elseif($_GET['error']=='book1unavailable'){
                                    echo '
                                    <div class="alert alert-danger">
                                        Error, book is unavailable!
                                    </div>
                                    ';
                                }
                                elseif($_GET['error']=='duplicatebook'){
                                    echo '
                                    <div class="alert alert-danger">
                                    Error, duplicate Book ID!
                                    </div>
                                    ';
                                }
                                else{
                                    echo '
                                    <div class="alert alert-danger">
                                        Error, Please try again later.
                                    </div>
                                    ';
                                
                                }
                            }
                        }
                        
                    }

                    ?>

                                        <div class="row">
                                            <?php
                            echo '<input type="hidden" name="librarian_id" value="'.$librarian_id.'">';
                        ?>

                                            <div class="form-group col-12 mb-1">
                                                <div class="row">
                                                    <div class="col-6 col-lg-2">
                                                        <label for="bookNumber" class="col-form-label">
                                                            Borrower ID <span
                                                                class="text-danger">(required)</span></label>
                                                        <input type="text" name="borrower_id" class="form-control"
                                                            required />
                                                    </div>
                                                    <div class="col-6 col-lg-2">
                                                        <label for="bookNumber" class="col-form-label">
                                                            Book ID <span class="text-danger">(required)</span></label>
                                                        <input type="text" name="book_id" class="form-control"
                                                            id="book1" required />
                                                        <!-- triggers modal and refresh rfid code -->
                                                        <button type="button" class="btn btn-primary mt-2"
                                                            data-bs-toggle="modal" data-bs-target="#book1modal"
                                                            onclick="clearRFID1()">Scan RFID</button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group col-12 mb-1">
                                                <label for="author" class="col-form-label">Borrow Date & Time <span
                                                        class="text-danger">(required)</span></label>
                                                <div class="row">
                                                    <div class="col-6 col-lg-2">
                                                        <input type="date" name="borrow_date" class="form-control"
                                                            required />
                                                    </div>
                                                    <div class="col-6 col-lg-2">
                                                        <input type="time" name="borrow_time" class="form-control"
                                                            required />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group col-12 mb-1">
                                                <label for="author" class="col-form-label">Due Date & Time <span
                                                        class="text-danger">(required)</span></label>
                                                <div class="row">
                                                    <div class="col-6 col-lg-2">
                                                        <input type="date" name="due_date" class="form-control"
                                                            required />
                                                    </div>
                                                    <div class="col-6 col-lg-2">
                                                        <input type="time" name="due_time" class="form-control"
                                                            required />
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- div class="form-group">
                    <label for="author" class="col-form-label">Return Date Time</label>
                        <div class="row">
                            <div class="col-6">
                                <input type="date" name="book_author" class="form-control border-secondary border" />
                            </div>
                            <div class="col-6">
                                <input type="time" name="book_author" class="form-control border-secondary border" />
                            </div>
                        </div>
                    </div-->
                                            <input type="hidden" name="librarian_id" class="form-control"
                                                value="<?php echo $librarian_id ?>" />
                                            <div class="form-group col-12">
                                                <div class="mt-3">
                                                    <button type="submit" class="btn btn-success"
                                                        name="add_transaction">Submit</button>
                                                    <a href="transaction.php" type="button"
                                                        class="btn btn-secondary">Cancel</a>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>


                            <!-- Modal 1-->
                            <div class="modal fade" id="book1modal" tabindex="-1" aria-labelledby="exampleModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Scan Book 1</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- for refreshing rfid code -->
                                            <div id="refresh-rfid-code"></div>
                                            <script>
                                            function clearRFID1() {
                                                $(document).ready(function() {
                                                    $.post("rfid/refresh.php",
                                                        function(data, status) {
                                                            console.log("rfid cleared");
                                                        });
                                                });
                                            }

                                            function submitBookID1() {
                                                console.log("boom id submitted");
                                                $(document).ready(function() {
                                                    var bookid = $('#bookid').val();
                                                    $('#book1').val(bookid);
                                                });
                                            }
                                            </script>
                                            <div class="render"></div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Cancel</button>
                                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal"
                                                onclick="submitBookID1()">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <script>
                            $(document).ready(function() {
                                setInterval(() => {
                                    $('.render').load('rfid/codeForScan.php').fadeIn("fast");
                                }, 500);
                            });
                            </script>

                            <div class="tables col-12">
                                <div class="row">

                                    <div class="borrower-table col-6">
                                        <div
                                            class="table-responsive p-3 border-left-primary border-top border-right border-bottom p-3 shadow rounded">
                                            <h5 class="modal-title" id="exampleModalLabel">List of Borrowers </h5>
                                            <hr>
                                            <table class="table table-bordered myDataTable">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Borrower ID</th>
                                                        <th scope="col">Borrower Name</th>
                                                        <th scope="col">Borrower Email</th>
                                                        <!--th scope="col">Action</th-->
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                $number = 0;
                                foreach ($borrowers as $borrower){
                                    $number++;
                                    echo '
                                        <tr>
                                            <td class="">'.$borrower['borrower_id'].'</td>
                                            <td class="">'.$borrower['borrower_fname'].' '.$borrower['borrower_lname'].'</td>
                                            <td>'.$borrower['borrower_email'].'</td>
                                            <!--td>
                                                <button type="button" class="btn btn-primary" onclick="copyBorrowerId('.$borrower['borrower_id'].')">
                                                    Copy ID
                                                </button>
                                            </td-->
                                        </tr>

                                    ';
                                }
                                ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="book-table col-6 ">
                                        <div
                                            class="table-responsive p-3 border-left-primary border-top border-right border-bottom p-3 shadow rounded">
                                            <h5 class="modal-title" id="exampleModalLabel">List of Books </h5>
                                            <hr>
                                            <table class="table table-bordered myDataTable">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Book ID</th>
                                                        <th scope="col">Catalog Number</th>
                                                        <th scope="col">Book Title</th>
                                                        <th scope="col">Book Status</th>
                                                        <!--th scope="col">Action</th-->
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                $number = 0;
                                foreach ($catalogs as $catalog){
                                    $number++;
                                    echo '
                                        <tr>
                                            <td>'.$catalog['book_id'].'</td>
                                            <td>'.$catalog['catalog_number'].'</td>
                                            <td>'.$catalog['catalog_book_title'].'</td>
                                            <td>
                                            ';
                                            if($catalog['catalog_status']=='Available'){
                                                echo '
                                                    <!--button type="button" class="btn btn-primary" onclick="copyCatalogId('.$catalog['book_id'].')">
                                                        Copy ID
                                                    </button-->
                                                    <button type="button" class="btn btn-success p-1 " disabled>
                                                        Available
                                                    </button>
                                                ';
                                            }else{
                                                echo '
                                                    
                                                    <button type="button" class="btn btn-danger p-1" disabled>
                                                        Unavailable
                                                    </button>
                                                ';
                                            }
                                            echo'
                                            </td>
                                        </tr>
                                    ';
                                }
                                ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <!---------------->
                    <!---- END BODY -->
                    <!---------------->






                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Online Library System</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    <script src="../assets/vendor/jquery/jquery.min.js"></script>
    <script src="../assets/vendor/dataTables/jquery.dataTables.min.js"></script>
    <script src="../assets/vendor/dataTables/dataTables.bootstrap5.min.js"></script>

    <script src="../assets/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../assets/vendor/sb-admin-2/sb-admin-2.min.js"></script>

    <script>
    $(document).ready(function() {
        $('.myDataTable').DataTable();
    });

    function copyCatalogId(value) {
        var tempInput = document.createElement("input");
        tempInput.style = "position: absolute; left: -1000px; top: -1000px";
        tempInput.value = value;
        document.body.appendChild(tempInput);
        tempInput.select();
        document.execCommand("copy");
        document.body.removeChild(tempInput);
        alert('Catalog ID Copied')
    }

    function copyBorrowerId(value) {
        var tempInput = document.createElement("input");
        tempInput.style = "position: absolute; left: -1000px; top: -1000px";
        tempInput.value = value;
        document.body.appendChild(tempInput);
        tempInput.select();
        document.execCommand("copy");
        document.body.removeChild(tempInput);
        alert('Borrower ID Copied')
    }
    </script>

</body>

</html>