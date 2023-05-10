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

        $sql = 'SELECT * FROM author_table ORDER BY author_fullname';
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
            }elseif($_GET['error']=='authoralready'){
                echo '
                <div class="alert alert-danger">
                    Error Add, Author already exist.
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
                        <input type="hidden" name="librarian_id" value="<?php echo $librarian_id ?>">
                        <div class="form-group row">
                            <div class="col-12">
                                <label class="col-form-label">Full Name
                                    <span class="text-danger"><em>(required)</em></span>
                                </label>
                                <input type="text" name="author_fullname" class="form-control border-dark border" required>
                            </div>
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
                        <th scope="col">Full Name</th>
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
                            <td class="border-tr">'.$author['author_fullname'].'</td>
                            ';

                            //fetch author ids in author book bridge table
                            $sql = 'SELECT * FROM author_book_bridge_table WHERE author_id = ? ';
                            $statement = $pdo->prepare($sql);
                            $statement->execute(array($author['author_id']));
                            $author_book_ids= $statement->fetchAll();

                            //create array with catalog titles
                            $catalogs_written = '';
                            foreach($author_book_ids as $author_book_id){
                                $sql = 'SELECT * FROM catalog_table WHERE book_id = ? ';
                                $statement = $pdo->prepare($sql);
                                $statement->execute(array($author_book_id['book_id']));
                                $catalog = $statement->fetch();
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
                                                

                                                $myArrays = array();
                                                $num = 0;
                                                $tempSelectedTitle = '';
                                                foreach($catalogs_written_list as $data){
                                                    if($tempSelectedTitle!=$data){
                                                        $myArrays[$num] = [
                                                            'catalog_book_title'=>$data,
                                                            ];
                                                    }
                                                    $tempSelectedTitle=$data;
                                                    $num++;
                                                }


                                                $num = 1;
                                                foreach($myArrays as $array){
                                                    echo '
                                                    <tr>
                                                        <th scope="row">'.$num.'</th>
                                                        <td>'.$array['catalog_book_title'].'</td>
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
                                                            <label class="col-form-label">Full Name
                                                                <span class="text-danger"><em>(required)</em></span>
                                                            </label>
                                                            <input type="text" name="author_fullname" class="form-control border-dark border" value="'.$author['author_fullname'].'" required>
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