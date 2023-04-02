<?php

session_start();

$active = 'librarian-table';
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

    $sql = 'SELECT * FROM librarian_table';
    $statement = $pdo->prepare($sql);
    $statement->execute();
    $librarians = $statement->fetchAll();


    include_once 'includes/header.php';
?>

<!---------------->
<!-- START BODY -->
<!---------------->

<div class="m-4">
    <h2 class="mb-4 text-dark">
        <span class="page-title">Librarian Table</span>
        <br>
        <hr>
        <!-- add librarian modal button -->
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalRegister">
            Add
        </button>
        <!-- add librarian modal -->
        <div class="modal fade" id="modalRegister" tabindex="-1" aria-labelledby="registerModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="api/add_librarian.php" method="POST" enctype="multipart/form-data">
                        <div class="modal-header">
                            <h5 class="modal-title" id="registerModal">Add Accepted Borrower</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row">
                                <div class="col-6">
                                    <label class="col-form-label">User Name</label>
                                    <input type="text" name="uname" class="form-control border-dark border" required>
                                </div>
                                <div class="col-6">
                                    <label class="col-form-label">Password</label>
                                    <input type="password" name="password" class="form-control border-dark border" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-6">
                                    <label class="col-form-label">First Name</label>
                                    <input type="text" name="fname" class="form-control border-dark border" required>
                                </div>
                                <div class="col-6">
                                    <label class="col-form-label">Last Name</label>
                                    <input type="text" name="lname" class="form-control border-dark border" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <label class="col-form-label">Address</label>
                                    <input type="text" name="address" class="form-control border-dark border" required>
                                </div>

                            </div>
                            <div class="form-group row">
                                <div class="col-6">
                                    <label class="col-form-label">Contact</label>
                                    <input type="text" name="contact" class="form-control border-dark border" required>
                                </div>
                                <div class="col-6">
                                    <label class="col-form-label">Email</label>
                                    <input type="email" name="email" class="form-control border-dark border" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">ID Picture</label>
                                <input type="file" name="idpicture" accept=".png, .jpg, .jpeg"
                                    class="form-control border-dark border" value="logo.png" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" name="add_librarian" class="btn btn-success">Submit</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- end add librarian modal -->
    </h2>

    <?php

    if(isset($_GET['add'])){
        if($_GET['add']=='error'){
            if($_GET['error']=='unameexisting'){
                echo '
                    <div class="alert alert-danger">
                        Username already exist.
                    </div>
                ';
            }elseif($_GET['error']=='emailexisting'){
                echo '
                    <div class="alert alert-danger">
                        Email already exist.
                    </div>
                ';
            }else{
                echo '
                <div class="alert alert-danger">
                    Error Delete, Please try again later.
                </div>
                ';
            }
            
        }
        if($_GET['add']=='success'){
            echo '
            <div class="alert alert-success">
                Librarian has been successfuly added.
            </div>
            ';
        }
    }
    if(isset($_GET['delete'])){
        if($_GET['delete']=='error'){
            if($_GET['account']=='you'){
                echo '
                    <div class="alert alert-danger">
                        Error, your own account cannot be deleted.
                    </div>
                ';
            }else{
                echo '
                    <div class="alert alert-danger">
                        Error Delete, Please try again later.
                    </div>
                ';
            }
        }
        if($_GET['delete']=='success'){
            echo '
                <div class="alert alert-success">
                    Librarian has been successfuly deleted.
                </div>
            ';
        }
    }

    ?>
    <div class="table-responsive">
        <table class="table table-bordered border-secondary">
            <thead class="border">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Profile Image</th>
                    <th scope="col">Librarian ID</th>
                    <th scope="col">Username</th>
                    <th scope="col">First Name</th>
                    <th scope="col">last Name</th>
                    <th scope="col">Address</th>
                    <th scope="col">Contact</th>
                    <th scope="col">Email</th>
                    <th scope="col">Password</th>
                    <th scope="col">Edit</th>
                    <th scope="col">Update Password</th>
                    <th scope="col">Delete</th>
                </tr>
            </thead>
            <tbody class="border">
                <?php
                    $number = 0;
                    foreach ($librarians as $librarian){
                        $number++;
                        echo '
                            <tr>
                                <td>'.$number.'</td>
                                <td>
                                    <button type="button" class="btn p-0 rounded border border-secondary" data-bs-toggle="modal" data-bs-target="#modalView'.$number.'">
                                        <!--i class="bi-eye"></i--> 
                                        <img class="p-0 rounded" src="../assets/image/idpictures/'.$librarian['librarian_image_name'].'" width="40" height="40">
                                    </button>
                                    <!-- view pic modal -->
                                    <div class="modal fade" id="modalView'.$number.'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">'.$librarian['librarian_fname'].'\'s Profile Image</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="d-flex justify-content-center m-2">
                                                    <img src="../assets/image/idpictures/'.$librarian['librarian_image_name'].'" width="300">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end view pic modal -->
                                </td>
                                <td>'.$librarian['librarian_id'].'</td>
                                <td>'.$librarian['librarian_uname'].'</td>
                                <td>'.$librarian['librarian_fname'].'</td>
                                <td>'.$librarian['librarian_lname'].'</td>
                                <td>'.$librarian['librarian_address'].'</td>
                                <td>'.$librarian['librarian_contact'].'</td>
                                <td>'.$librarian['librarian_email'].'</td>
                                <td>********</td>
                                <td><button class="btn btn-primary"> Edit </button></td>
                                <td><button class="btn btn-primary"> Update Password </button></td>
                                <td>
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#modalDelete'.$number.'">
                                        Delete
                                    </button>
                                <!-- delete modal -->
                                    <div class="modal fade" id="modalDelete'.$number.'" tabindex="-1"
                                        aria-labelledby="" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="api/delete_librarian.php" method="post">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="">Delete Librarian</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        The transactions with this librarian will also be deleted.
                                                        Are you sure you want to delete this librarian?
                                                    </div>
                                                    <input type="hidden" name="id" value="'.$librarian['librarian_id'].'">
                                                    <input type="hidden" name="my_id" value="'.$librarian_id.'">
                                                    <div class="modal-footer">
                                                        <button type="submit" name="delete_librarian" class="btn btn-success">Yes</button>
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
                ?>
            </tbody>
        </table>
    </div>

</div>

<!---------------->
<!---- END BODY -->
<!---------------->

<?php
include_once 'includes/footer.php';
?>