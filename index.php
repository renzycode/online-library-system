<?php

include_once "includes/conn.php";


if(isset( $_GET['search']) && isset($_GET['search_by'])){
    $search = $_GET['search'];
    $search_by = $_GET['search_by'];

    if($search_by=='book_title'){
        $sql1 = 'SELECT * FROM catalog_table WHERE catalog_book_title LIKE \'%'.$search.'%\' ORDER BY catalog_author';
        $echo_search_by = 'Book Title';
    }else{
        $sql1 = 'SELECT * FROM catalog_table WHERE catalog_author LIKE \'%'.$search.'%\' ORDER BY catalog_author';
        $echo_search_by = 'Author';
    }

    $statement = $pdo->prepare($sql1);
    $statement->execute();
    $search_catalogs = $statement->fetchAll();
    

}else{
    $search = '';

    if(!isset($_GET['sort_by'])){
        echo '<script> window.location.href = "index.php?sort_by=title"; </script>';
    }else{
        $sort_by=$_GET['sort_by'];
    }

    if($sort_by=='author'){
        $titleSortIconStatus = 'sort-btn';
        $authorSortIconStatus = 'sort-btn-active';
    
        $sql1 = "SELECT * FROM catalog_table ORDER BY catalog_author";
    
    }else{
        $titleSortIconStatus = 'sort-btn-active';
        $authorSortIconStatus = 'sort-btn';
    
        $sql1 = "SELECT * FROM catalog_table ORDER BY catalog_book_title";
    }


    $statement = $pdo->prepare($sql1);

    $statement->execute();

    $catalogs = $statement->fetchAll();
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="assets/image/logo.png" type="image/x-icon">
    <title>Online Library System</title>
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/vendor/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/custom.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="assets/image/logo.png" width="50" height="50" alt="logo">
            </a>
            <div class="justify-content-end" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <button type="button" class="btn btn-light mx-1 my-2" data-bs-toggle="modal"
                        data-bs-target="#modalRegister">
                        Register
                    </button>
                    <!-- register modal -->
                    <div class="modal fade" id="modalRegister" tabindex="-1" aria-labelledby="registerModal"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="api/register_borrower.php" method="POST" enctype="multipart/form-data">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="registerModal">Register</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">

                                        <div class="form-group row">
                                            <div class="col-6">
                                                <label class="col-form-label">First Name
                                                    <span class="text-danger"><em>(required)</em></span>
                                                </label>
                                                <input type="text" name="fname" class="form-control border-dark border"
                                                    required>
                                            </div>
                                            <div class="col-6">
                                                <label class="col-form-label">Last Name
                                                    <span class="text-danger"><em>(required)</em></span>
                                                </label>
                                                <input type="text" name="lname" class="form-control border-dark border"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-12">
                                                <label class="col-form-label">Address
                                                    <span class="text-danger"><em>(required)</em></span>
                                                </label>
                                                <input type="text" name="address"
                                                    class="form-control border-dark border" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-6">
                                                <label class="col-form-label">Contact
                                                    <span class="text-danger"><em>(required)</em></span>
                                                </label>
                                                <input type="text" name="contact"
                                                    class="form-control border-dark border" required>
                                            </div>
                                            <div class="col-6">
                                                <label class="col-form-label">Email
                                                    <span class="text-danger"><em>(required)</em></span>
                                                </label>
                                                <input type="email" name="email" class="form-control border-dark border"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">ID Picture
                                                <span class="text-danger"><em>(required)</em></span>
                                            </label>
                                            <input type="file" name="idpicture" accept=".png, .jpg, .jpeg"
                                                class="form-control border-dark border" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" name="register" class="btn btn-success">Submit</button>
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- end edit modal -->
                </ul>
            </div>
        </div>
    </nav>

    <?php

    if (!empty($search)){
        echo '
        <div class="m-4">
            <h2 class="mb-4 text-dark">Result for '.$echo_search_by.' \''.$search.'\'
                <a class="btn btn-secondary" href="index.php" role="button">Go back</a>
            </h2>';
            
            if(isset($_GET['register'])){
                if($_GET['register']=='success'){
                    echo '
                    <div class="alert alert-success">
                        Request successfully submited.
                    </div>
                    ';
                }
                if($_GET['register']=='error'){
                    if(isset($_GET['error'])){
                        if($_GET['error']=='emailalreadyused')
                        echo '
                            <div class="alert alert-danger">
                                Request error, email already used.
                            </div>
                        ';
                    }else{
                    echo '
                        <div class="alert alert-danger">
                            Request error.
                        </div>
                    ';
                    }
                }
            }

            if (!empty($search_catalogs)){
                echo '
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="border">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Book No.</th>
                                <th scope="col">Book Title</th>
                                <th scope="col">Author</th>
                                <th scope="col">Publisher</th>
                                <th scope="col">Date Published</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody class="border">';
                            $number = 1;
                            foreach ($search_catalogs as $search_catalog){
                                $book_status = "";
                                echo '
                                <tr>
                                    <td>'.$number.'</td>
                                    <td>'.$search_catalog["catalog_number"].'</td>
                                    <td>'.$search_catalog["catalog_book_title"].'</td>
                                    <td>'.$search_catalog["catalog_author"].'</td>
                                    <td>'.$search_catalog["catalog_publisher"].'</td>
                                    <td>'.$search_catalog["catalog_year"].'</td>';
                                    if($search_catalog["catalog_status"]=="Available"){
                                        echo '
                                        <td>'.$search_catalog["catalog_status"].' 
                                            <span class="text-success">
                                                <i class="bi bi-check-circle-fill"></i>
                                            </span>
                                        </td>';
                                    }else{
                                        echo '
                                        <td>'.$search_catalog["catalog_status"].' 
                                            <span class="text-danger">
                                                <i class="bi bi-check-circle-fill"></i>
                                            </span>
                                        </td>';
                                    }
                                echo '
                                </tr>
                                ';
                                $number++;
                            }
                        echo '
                        </tbody>
                    </table>
                </div>';
            }
            else{
                echo '
                <div class="alert alert-danger">
                    No result found
                </div>';
            }

        echo '</div>';
    }
    else{
        echo '
        <div class="m-4">
            <h2 class="mb-4 text-dark">
                <span class="page-title">List of Books</span>
                <hr>
            </h2>';
            
            if(isset($_GET['register'])){
                if($_GET['register']=='success'){
                    echo '
                    <div class="alert alert-success">
                        Request successfully submited.
                    </div>
                    ';
                }
                if($_GET['register']=='error'){
                    if(isset($_GET['error'])){
                        if($_GET['error']=='emailalreadyused')
                        echo '
                            <div class="alert alert-danger">
                                Request error, email already used.
                            </div>
                        ';
                    }else{
                    echo '
                        <div class="alert alert-danger">
                            Request error.
                        </div>
                    ';
                    }
                }
            }

            echo'
            <div class="col-xl-3 col-lg-3 col-md-6">
                <form action="index.php" method="GET">
                    <div class="input-group mb-3">
                        <input type="text" name="search" class="form-control" placeholder="Search Book" required>
                        <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Search by
                        </button>
                        <ul class="dropdown-menu">
                            <li><button class="dropdown-item" type="submit" name="search_by" value="book_title">Book Title</button></li>
                            <li><button class="dropdown-item" type="submit" name="search_by" value="author">Author</button></li>
                        </ul>
                    </div>
                </form>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="border">
                        <tr>
                            <th scope="col">
                                <div class="d-flex justify-content-between">
                                    <div class="text-dark">#</div>
                                </div>
                            </th>
                            <th scope="col">
                                <div class="d-flex justify-content-between">
                                    <div class="text-dark">Book No.</div>
                                </div>
                            </th>
                            <th scope="col">
                                <div class="d-flex justify-content-between">
                                    <div class="text-dark">Book Title</div>
                                    <a type="button" href="index.php?sort_by=title" class="float-right">
                                        <i class="'.$titleSortIconStatus.' bi bi-chevron-expand"></i>
                                    </a>
                                </div>
                            </th>
                            <th scope="col">
                                <div class="d-flex justify-content-between">
                                    <div class="text-dark">Author</div>
                                    <a type="button" href="index.php?sort_by=author" class="float-right">
                                        <i class="'.$authorSortIconStatus.' bi bi-chevron-expand"></i>
                                    </a>
                                </div>
                            </th>
                            <th scope="col">
                                <div class="d-flex justify-content-between">
                                    <div class="text-dark">Publisher</div>
                                </div>
                            </th>
                            <th scope="col">
                                <div class="d-flex justify-content-between">
                                    <div class="text-dark">Date Published</div>
                                </div>
                            </th>
                            <th scope="col">
                                <div class="d-flex justify-content-between">
                                    <div class="text-dark">Status</div>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="border">';
                        $number = 1;
                        foreach ($catalogs as $catalog){
                            $book_status = '';
                            echo '
                            <tr>
                                <td>'.$number.'</td>
                                <td>'.$catalog["catalog_number"].'</td>
                                <td>'.$catalog["catalog_book_title"].'</td>
                                <td>'.$catalog["catalog_author"].'</td>
                                <td>'.$catalog["catalog_publisher"].'</td>
                                <td>'.$catalog["catalog_year"].'</td>';
                                if($catalog["catalog_status"]=="Available"){
                                    echo '
                                    <td>
                                        <span class="text-success">
                                            <i class="bi bi-check-circle-fill"></i>
                                        </span>
                                        '.$catalog["catalog_status"].' 
                                    </td>';
                                }else{
                                    echo '
                                    <td>
                                        <span class="text-danger">
                                            <i class="bi bi-x-circle-fill"></i>
                                        </span>
                                        '.$catalog["catalog_status"].' 
                                    </td>';
                                }
                            echo '
                            </tr>
                            ';
                            $number++;
                        }
                    echo '
                    </tbody>
                </table>
            </div>
        </div>';
        }
    ?>

    <script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/jquery/jquery.min.js"></script>
</body>


</html>