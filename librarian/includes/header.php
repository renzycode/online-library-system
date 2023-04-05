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

    <script src="../assets/vendor/jquery/jquery.min.js"></script>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-dark sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
                <div class="sidebar-brand-text mx-3"><h6>Online Library System</h6></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li 
                <?php
                    if($active == 'dashboard'){ 
                        echo 'class="nav-item active"';
                    }else{
                        echo 'class="nav-item"';
                    }
                ?>
            >
                <a class="nav-link" href="index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- nav item borrower -->
            <li
                <?php
                    if($active == 'borrower'){ 
                        echo 'class="nav-item active"';
                    }else{
                        echo 'class="nav-item"';
                    }
                ?>
            >
                <a class="nav-link" href="borrower.php">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Borrower</span>
                </a>
            </li>

            <!-- nav item transaction -->
            <li
                <?php
                    if($active == 'transaction'){ 
                        echo 'class="nav-item active"';
                    }else{
                        echo 'class="nav-item"';
                    }
                ?>
            >
                <a class="nav-link" href="transaction.php">
                    <i class="fas fa-fw fa-plus"></i>
                    <span>Add Transaction</span>
                </a>
            </li>
            
            <li
                <?php
                    if($active == 'return-book'){ 
                        echo 'class="nav-item active"';
                    }else{
                        echo 'class="nav-item"';
                    }
                ?>
            >
                <a class="nav-link" href="return_book.php">
                    <i class="fas fa-fw fa-book"></i>
                    <span>Return Book</span>
                </a>
            </li>

            <!-- nav item catalog -->
            <li
                <?php
                    if($active == 'transaction-table'){ 
                        echo 'class="nav-item active"';
                    }else{
                        echo 'class="nav-item"';
                    }
                ?>
            >
                <a class="nav-link" href="transaction_table.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Transaction Table</span>
                </a>
            </li>

            

            <!-- nav item catalog -->
            <li
                <?php
                    if($active == 'catalog'){ 
                        echo 'class="nav-item active"';
                    }else{
                        echo 'class="nav-item"';
                    }
                ?>
            >
                <a class="nav-link" href="catalog.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Catalog Table</span>
                </a>
            </li>

            <!-- nav item catalog -->
            <li
                <?php
                    if($active == 'librarian-table'){ 
                        echo 'class="nav-item active"';
                    }else{
                        echo 'class="nav-item"';
                    }
                ?>
            >
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
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $librarian_data['librarian_uname'] ?></span>
                                <img class="img-profile rounded-circle"
                                    src="../assets/image/idpictures/<?php echo $librarian_data['librarian_image_name'] ?>">
                            </span>
                        </li>
                        <div class="topbar-divider d-none d-sm-block"></div>
                        <li class="nav-item">
                            <button type="button" class="nav-link btn mr-4" data-bs-toggle="modal"
                                data-bs-target="#modalLogout">
                                Logout</strong>
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