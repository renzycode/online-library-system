<?php

include_once "includes/conn.php";
include_once "includes/functions.php";

//redirectURL('librarian/');

//search for book title
if(isset( $_GET['search'])){
    $search = $_GET['search'];
    $sql1 = 'SELECT * FROM catalog_table WHERE catalog_book_title LIKE \'%'.$search.'%\' ORDER BY catalog_book_title';
    $echo_search_by = 'Book Title';

    $statement = $pdo->prepare($sql1);
    $statement->execute();
    $search_catalogs = $statement->fetchAll();
    

    $myArrays = array();
    $num = 0;
    $tempSelectedTitle = '';
    foreach($search_catalogs as $catalog){
        if($tempSelectedTitle!=$catalog['catalog_book_title']){

            $sql = "SELECT * FROM author_book_bridge_table WHERE book_id = ?";
            $statement = $pdo->prepare($sql);
            $statement->execute(array($catalog['book_id']));
            $bridge_catalogs = $statement->fetchAll();

            $authors = '';
            foreach($bridge_catalogs as $bridge_catalog){
                $sql = "SELECT * FROM author_table WHERE author_id = ?";
                $statement = $pdo->prepare($sql);
                $statement->execute(array($bridge_catalog['author_id']));
                $author_fetched = $statement->fetch();

                if(empty($authors)){
                    
                    $authors = $authors.$author_fetched['author_fullname'];
                }else{
                    $authors = $authors.', '.$author_fetched['author_fullname'];
                }
                
            }


            $myArrays[$num] = [
                'catalog_book_title'=>$catalog['catalog_book_title'],
                'catalog_edition'=>$catalog['catalog_edition'],
                'catalog_author'=>$authors,
                'catalog_publisher'=>$catalog['catalog_publisher'],
                'catalog_year'=>$catalog['catalog_year']
                ];
        }
        $tempSelectedTitle=$catalog['catalog_book_title'];
        $num++;
    }

    //search for edition
    if(empty($myArrays)){
        $search = $_GET['search'];
        $sql1 = 'SELECT * FROM catalog_table WHERE catalog_edition LIKE \'%'.$search.'%\' ORDER BY catalog_book_title';
        $echo_search_by = 'Edition';

        $statement = $pdo->prepare($sql1);
        $statement->execute();
        $search_catalogs = $statement->fetchAll();
        

        $myArrays = array();
        $num = 0;
        $tempSelectedTitle = '';
        foreach($search_catalogs as $catalog){
            if($tempSelectedTitle!=$catalog['catalog_book_title']){

                $sql = "SELECT * FROM author_book_bridge_table WHERE book_id = ?";
                $statement = $pdo->prepare($sql);
                $statement->execute(array($catalog['book_id']));
                $bridge_catalogs = $statement->fetchAll();

                $authors = '';
                foreach($bridge_catalogs as $bridge_catalog){
                    $sql = "SELECT * FROM author_table WHERE author_id = ?";
                    $statement = $pdo->prepare($sql);
                    $statement->execute(array($bridge_catalog['author_id']));
                    $author_fetched = $statement->fetch();

                    if(empty($authors)){
                        
                        $authors = $authors.$author_fetched['author_fullname'];
                    }else{
                        $authors = $authors.', '.$author_fetched['author_fullname'];
                    }
                    
                }


                $myArrays[$num] = [
                    'catalog_book_title'=>$catalog['catalog_book_title'],
                    'catalog_edition'=>$catalog['catalog_edition'],
                    'catalog_author'=>$authors,
                    'catalog_publisher'=>$catalog['catalog_publisher'],
                    'catalog_year'=>$catalog['catalog_year']
                    ];
            }
            $tempSelectedTitle=$catalog['catalog_book_title'];
            $num++;
        }
    }

    //search for author
    if(empty($myArrays)){
        $search = $_GET['search'];
        $sql1 = 'SELECT * FROM author_table WHERE author_fullname LIKE \'%'.$search.'%\' ';
        $echo_search_by = 'Author';

        $statement = $pdo->prepare($sql1);
        $statement->execute();
        $authors = $statement->fetchAll();

        $myArrays = array();
        $num = 0;
        foreach($authors as $author){

            $sql = "SELECT * FROM author_book_bridge_table WHERE author_id = ?";
            $statement = $pdo->prepare($sql);
            $statement->execute(array($author['author_id']));
            $author_with_books = $statement->fetchAll();
            foreach($author_with_books as $author_with_book){
                
                $sql = "SELECT * FROM catalog_table WHERE book_id = ?";
                $statement = $pdo->prepare($sql);
                $statement->execute(array($author_with_book['book_id']));
                $search_catalogs = $statement->fetchAll();
                
                $tempSelectedTitle = '';
                foreach($search_catalogs as $catalog){
                    if($tempSelectedTitle!=$catalog['catalog_book_title']){

                        $sql = "SELECT * FROM author_book_bridge_table WHERE book_id = ?";
                        $statement = $pdo->prepare($sql);
                        $statement->execute(array($catalog['book_id']));
                        $bridge_catalogs = $statement->fetchAll();

                        $authors = '';
                        foreach($bridge_catalogs as $bridge_catalog){
                            $sql = "SELECT * FROM author_table WHERE author_id = ?";
                            $statement = $pdo->prepare($sql);
                            $statement->execute(array($bridge_catalog['author_id']));
                            $author_fetched = $statement->fetch();

                            if(empty($authors)){
                                
                                $authors = $authors.$author_fetched['author_fullname'];
                            }else{
                                $authors = $authors.', '.$author_fetched['author_fullname'];
                            }
                            
                        }


                        $myArrays[$num] = [
                            'catalog_book_title'=>$catalog['catalog_book_title'],
                            'catalog_edition'=>$catalog['catalog_edition'],
                            'catalog_author'=>$authors,
                            'catalog_publisher'=>$catalog['catalog_publisher'],
                            'catalog_year'=>$catalog['catalog_year']
                            ];
                    }
                    $tempSelectedTitle=$catalog['catalog_book_title'];
                    $num++;
                }
    
            }

        }
    }

    //search for publisher
    if(empty($myArrays)){
        $search = $_GET['search'];
        $sql1 = 'SELECT * FROM catalog_table WHERE catalog_publisher LIKE \'%'.$search.'%\' ORDER BY catalog_book_title';
        $echo_search_by = 'Edition';

        $statement = $pdo->prepare($sql1);
        $statement->execute();
        $search_catalogs = $statement->fetchAll();
        

        $myArrays = array();
        $num = 0;
        $tempSelectedTitle = '';
        foreach($search_catalogs as $catalog){
            if($tempSelectedTitle!=$catalog['catalog_book_title']){

                $sql = "SELECT * FROM author_book_bridge_table WHERE book_id = ?";
                $statement = $pdo->prepare($sql);
                $statement->execute(array($catalog['book_id']));
                $bridge_catalogs = $statement->fetchAll();

                $authors = '';
                foreach($bridge_catalogs as $bridge_catalog){
                    $sql = "SELECT * FROM author_table WHERE author_id = ?";
                    $statement = $pdo->prepare($sql);
                    $statement->execute(array($bridge_catalog['author_id']));
                    $author_fetched = $statement->fetch();

                    if(empty($authors)){
                        
                        $authors = $authors.$author_fetched['author_fullname'];
                    }else{
                        $authors = $authors.', '.$author_fetched['author_fullname'];
                    }
                    
                }


                $myArrays[$num] = [
                    'catalog_book_title'=>$catalog['catalog_book_title'],
                    'catalog_edition'=>$catalog['catalog_edition'],
                    'catalog_author'=>$authors,
                    'catalog_publisher'=>$catalog['catalog_publisher'],
                    'catalog_year'=>$catalog['catalog_year']
                    ];
            }
            $tempSelectedTitle=$catalog['catalog_book_title'];
            $num++;
        }
    }

    //search for date published
    if(empty($myArrays)){
        $search = $_GET['search'];
        $sql1 = 'SELECT * FROM catalog_table WHERE catalog_year LIKE \'%'.$search.'%\' ORDER BY catalog_book_title';
        $echo_search_by = 'Edition';

        $statement = $pdo->prepare($sql1);
        $statement->execute();
        $search_catalogs = $statement->fetchAll();
        

        $myArrays = array();
        $num = 0;
        $tempSelectedTitle = '';
        foreach($search_catalogs as $catalog){
            if($tempSelectedTitle!=$catalog['catalog_book_title']){

                $sql = "SELECT * FROM author_book_bridge_table WHERE book_id = ?";
                $statement = $pdo->prepare($sql);
                $statement->execute(array($catalog['book_id']));
                $bridge_catalogs = $statement->fetchAll();

                $authors = '';
                foreach($bridge_catalogs as $bridge_catalog){
                    $sql = "SELECT * FROM author_table WHERE author_id = ?";
                    $statement = $pdo->prepare($sql);
                    $statement->execute(array($bridge_catalog['author_id']));
                    $author_fetched = $statement->fetch();

                    if(empty($authors)){
                        
                        $authors = $authors.$author_fetched['author_fullname'];
                    }else{
                        $authors = $authors.', '.$author_fetched['author_fullname'];
                    }
                    
                }


                $myArrays[$num] = [
                    'catalog_book_title'=>$catalog['catalog_book_title'],
                    'catalog_edition'=>$catalog['catalog_edition'],
                    'catalog_author'=>$authors,
                    'catalog_publisher'=>$catalog['catalog_publisher'],
                    'catalog_year'=>$catalog['catalog_year']
                    ];
            }
            $tempSelectedTitle=$catalog['catalog_book_title'];
            $num++;
        }
    }

}else{
    $myArrays = array();
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
    <link href="assets/vendor/dataTables/dataTables.bootstrap5.min.css" rel="stylesheet">

    <script src="assets/vendor/jquery/jquery.min.js"></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <!--img src="assets/image/logo.png" width="50" height="50" alt="logo"-->
            </a>
            <div class="justify-content-end" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <!--button type="button" class="btn btn-light mx-1 my-2" data-bs-toggle="modal"
                        data-bs-target="#modalRegister">
                        Register
                    </button-->
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
                                        <!--div class="form-group">
                                            <label class="col-form-label">ID Picture
                                                <span class="text-danger"><em>(required)</em></span>
                                            </label>
                                            <input type="file" name="idpicture" accept=".png, .jpg, .jpeg"
                                                class="form-control border-dark border" required>
                                        </div-->
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

    
        echo '
        <div class="m-4">';
            
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
            <div class="col-12 row">
                <div class="col-lg-4 col-xl-4 col-md-4 col-sm-0">
                &nbsp;
                </div>
                <div class="col-lg-4 col-xl-4 col-md-4 col-sm-12">
                <form action="index.php" method="GET" class="" style="">
                    <div class="d-flex justify-content-center mt-2 mb-2">
                        <img src="assets/image/logo.png" width="200" height="200" alt="logo">
                    </div>
                    <input type="text" name="search" class="form-control" placeholder="Search Book Info" required>
                    <div class="d-flex justify-content-center mt-3 mb-3">
                        <button class="btn btn-success" type="submit"> Search </button>
                    </div>
                </form>
                </div>
                <div class="col-lg-4 col-xl-4 col-md-4 col-sm-0">
                &nbsp;
                </div>
                
            </div>';

            if(count($myArrays)>0){

                echo '

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="border">

                            <tr>
                                <th scope="col">Title</th>
                                <th scope="col">Edition</th>
                                <th scope="col">Author</th>
                                <th scope="col">Publisher</th>
                                <th scope="col">Date Published</th>
                                <th scope="col">Available</th>
                            </tr>
                        </thead>
                        <tbody class="border">';
                            $number = 1;

                            foreach($myArrays as $myArray){
                        
                                $sql = "SELECT * FROM catalog_table WHERE catalog_book_title = ?";
                                $statement = $pdo->prepare($sql);
                                $statement->execute(array($myArray['catalog_book_title']));
                                $catalogs = $statement->fetchAll();
                                $all = count($catalogs);

                                $sql = "SELECT * FROM catalog_table WHERE catalog_book_title = ? AND catalog_status = 'Available'";
                                $statement = $pdo->prepare($sql);
                                $statement->execute(array($myArray['catalog_book_title']));
                                $catalogs = $statement->fetchAll();
                                $available = count($catalogs);


                                $array_author_names = preg_split("/\,/", $myArray['catalog_author']);
                                $author_names_exploded = explode(',', $myArray['catalog_author'])[0];

                                echo '
                                <tr>
                                    <td class="border-tr"><strong>'.$myArray['catalog_book_title'].'</strong></td>
                                    <td class="border-tr">'.$myArray['catalog_edition'].'</td>
                                    ';
                                    if(count($array_author_names)==1){
                                        echo '<td class="border-tr">'.$myArray['catalog_author'].'</td>';
                                    }else{
                                        echo '<td class="border-tr">'.$myArray['catalog_author'].'</td>';
                                    }
                                    echo '
                                    <td class="border-tr">'.$myArray['catalog_publisher'].'</td>
                                    <td class="border-tr">'.$myArray['catalog_year'].'</td>
                                    <td>'.$available.'/'.$all.'</td>
                                </tr>
                                ';
                                $number++;


                            }
                        echo '
                        </tbody>
                    </table>
                </div>
            </div>';
        }elseif(isset($_GET['search']) && count($myArrays)<=0){
            echo ' <div class="alert alert-danger">No books found.</div>';
        }
    ?>


    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <!-- Bootstrap core JavaScript-->
    <script src="assets/vendor/dataTables/jquery.dataTables.min.js"></script>
    <script src="assets/vendor/dataTables/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.myDataTable').DataTable();
        });
    </script>
</body>


</html>