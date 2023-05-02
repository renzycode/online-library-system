<?php

session_start();

$active = 'author';
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

include_once 'includes/header.php';

        $sql = 'SELECT * FROM author_table ORDER BY author_fname';
        $statement = $pdo->prepare($sql);
        $statement->execute();
        $authors = $statement->fetchAll();
    


?>

<!---------------->
<!-- START BODY -->
<!---------------->

<div class="m-4">
    <h2 class="mb-4 text-dark">
        <span class="page-title">Catalog Table</span>
        <hr>
        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modalAdd"
            onclick="clearRFID()">
            Add
        </button>
        <a type="button" class="btn btn-success" href="download_reports/catalog.php">
            Download Report
        </a>
    </h2>

    <?php

    if(isset($_GET['add'])){
        if($_GET['add']=='success'){
            echo '
            <div class="alert alert-success">
                Catalog has been successfully added.
            </div>
            ';
        }
        if($_GET['add']=='error'){
            if($_GET['error']=='rfidexisting'){
                echo '
                <div class="alert alert-danger">
                    Error Add, RFID already used.
                </div>
                ';
            }elseif($_GET['error']=='catalognumberexisting'){
                echo '
                <div class="alert alert-danger">
                    Error Add, Catalog number already used.
                </div>
                ';
            }else{
                echo '
                <div class="alert alert-danger">
                    Error Add, Please try again later.
                </div>
                ';
            }
        }
    }

    if(isset($_GET['edit'])){
        if($_GET['edit']=='success'){
            echo '
            <div class="alert alert-success">
                Catalog has been successfully updated.
            </div>
            ';
        }
        if($_GET['edit']=='error'){
            if($_GET['rfid']=='existing'){
                echo '
                <div class="alert alert-danger">
                    Error Edit, RFID already used.
                </div>
                ';
            }else{
                echo '
                <div class="alert alert-danger">
                    Error Edit, Please try again later.
                </div>
                ';
            }
        }
    }

    if(isset($_GET['delete'])){
        if($_GET['delete']=='success'){
            echo '
            <div class="alert alert-success">
                Catalog has been successfully deleted.
            </div>
            ';
        }
        if($_GET['delete']=='error'){
            echo '
            <div class="alert alert-danger">
                Error Delete, Please try again later.
            </div>
            ';
        }
    }
    ?>
    <!-- add modal -->
    <div class="modal fade" id="modalAdd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="api/add_author.php" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Author</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body row">

                        <div class="form-group col-6 mb-0">
                            <label class="col-form-label">First Name
                                <span class="text-danger"><em>(required)</em></span>
                            </label>
                            <input type="text" name="author_fname" class="form-control border-dark border" required />
                        </div>
                        <div class="form-group col-6 mb-0">
                            <label class="col-form-label">Last name
                                <span class="text-danger"><em>(required)</em></span>
                            </label>
                            <input type="text" name="author_lname" class="form-control border-dark border" required />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="add_author" class="btn btn-success">Submit</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- end add modal -->

    <?php
    if ( count($authors)<=0 ) {
        echo '
        <div class="alert alert-warning">
            No authors to be displayed
        </div>
        ';
    }
    else{
        echo '
        <div class="table-responsive">
            <table class="table table-bordered border-secondary">
                <thead class="border">
                    <tr>
                        <th scope="col">Author ID</th>
                        <th scope="col">First Name</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Books Written</th>
                        <th scope="col">Edit All Copies</th>
                        <th scope="col">Delete</th>
                    </tr>
                </thead>
                <tbody class="border">
                ';
                    foreach ($authors as $author){
                        echo '
                        <tr>
                            <td class="border-tr">'.$author['author_id'].'</td>
                            <td class="border-tr">'.$author['author_fname'].'</td>
                            <td class="border-tr">'.$author['author_lname'].'</td>';
                            $sql = 'SELECT * FROM catalog_table WHERE catalog_author LIKE \'%'.$author['author_id'].'%\' ORDER BY catalog_author';
                            $statement = $pdo->prepare($sql);
                            $statement->execute();
                            $catalogs= $statement->fetchAll();

                            $catalogs_written = '';
                            foreach($catalogs as $catalog){
                                if(empty($catalogs_written)){
                                    $catalogs_written = $catalogs_written.$catalog['catalog_book_title'];
                                }
                                else{
                                    $catalogs_written = $catalogs_written.','.$catalog['catalog_book_title'];
                                }
                                
                            }
                            $catalogs_written_list = preg_split("/\,/", $catalogs_written);
                            echo '
                            <td class="border-tr">
                            <button type="button" class="btn btn-info" data-bs-toggle="modal"
                            data-bs-target="#modalViewBooks'.$author['author_id'].'">
                            View Books Written
                            </button>
                            <!-- view modal -->
                            <div class="modal fade" id="modalViewBooks'.$author['author_id'].'" tabindex="-1"
                                aria-labelledby="" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="">Books Written</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Catalog Book Title</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                ';
                                                $num = 1;
                                                foreach($catalogs_written_list as $data){
                                                    echo '
                                                    <tr>
                                                        <th scope="row">'.$num.'</th>
                                                        <td>'.$data.'</td>
                                                    </tr>
                                                    ';
                                                    $num++;
                                                }
                                                
                                                echo '
                                                </tbody>
                                            </table>
                                            
                                        </div>
                                        <input type="hidden" name="author_id" value="'.$author['author_id'].'">
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end view modal -->
                            </td>
                            <td class="border-tr">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#modalEdit'.$author['author_id'].'"> Edit
                                </button>
                                <!-- edit modal -->
                                <div class="modal fade" id="modalEdit'.$author['author_id'].'" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="api/edit_author.php" method="post" enctype="multipart/form-data">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Edit Author</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                <input type="hidden" name="author_id" value="'.$author['author_id'].'" required>
                                                    <div class="form-group row">
                                                        <div class="col-12">
                                                            <label class="col-form-label">First Name
                                                                <span class="text-danger"><em>(required)</em></span>
                                                            </label>
                                                            <input type="text" name="author_fname" class="form-control border-dark border" value="'.$author['author_fname'].'" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-12">
                                                            <label class="col-form-label">First Name
                                                                <span class="text-danger"><em>(required)</em></span>
                                                            </label>
                                                            <input type="text" name="author_lname" class="form-control border-dark border" value="'.$author['author_lname'].'" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" name="edit_author" class="btn btn-success">Submit</button>
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- end edit modal -->
                            </td>
                            <td class="border-tr">
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                data-bs-target="#modalDelete'.$author['author_id'].'">
                                Delete
                                </button>
                                <!-- delete modal -->
                                <div class="modal fade" id="modalDelete'.$author['author_id'].'" tabindex="-1"
                                    aria-labelledby="" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="api/delete_author.php" method="post">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="">Delete Author</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure you want to delete this author?
                                                </div>
                                                <input type="hidden" name="author_id" value="'.$author['author_id'].'">
                                                <div class="modal-footer">
                                                    <button type="submit" name="delete_author" class="btn btn-success">Yes</button>
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Cancel</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- end delete modal -->
                            </td>
                        </tr>
                        ';
                    }
                echo '
                </tbody>
            </table>
        </div>
        ';
    }
    ?>
</div>
<script>
$(document).ready(function() {
    setInterval(() => {
        $('.renderrfidcode').load('rfid/codeForRegister.php').fadeIn("fast");
    }, 500);
});
</script>
<script>
$(document).ready(function() {
    $('.myDataTable').DataTable({
        "order": [
            [2, 'asc']
        ]
    });
});
</script>

<!---------------->
<!---- END BODY -->
<!---------------->

<?php
include_once 'includes/footer.php';
?>