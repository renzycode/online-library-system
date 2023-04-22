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
    
    </h2>

    <!-- add librarian modal -->
    <div class="modal fade" id="modalRegister" tabindex="-1" aria-labelledby="registerModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="api/add_librarian.php" method="POST" enctype="multipart/form-data">
                        <div class="modal-header">
                            <h5 class="modal-title" id="registerModal">Add Librarian</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row">
                                <div class="col-6">
                                    <label class="col-form-label">User Name
                                        <span class="text-danger"><em>(required)</em></span>
                                    </label>
                                    <input type="text" name="uname" class="form-control border-dark border" required>
                                </div>
                                <div class="col-6">
                                    <label class="col-form-label">Password</label>
                                        <span class="text-danger"><em>(required)</em></span>
                                    <input type="password" name="password" class="form-control border-dark border"
                                        required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-6">
                                    <label class="col-form-label">First Name
                                        <span class="text-danger"><em>(required)</em></span>
                                    </label>
                                    <input type="text" name="fname" class="form-control border-dark border" required>
                                </div>
                                <div class="col-6">
                                    <label class="col-form-label">Last Name
                                        <span class="text-danger"><em>(required)</em></span>
                                    </label>
                                    <input type="text" name="lname" class="form-control border-dark border" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <label class="col-form-label">Address
                                        <span class="text-danger"><em>(required)</em></span>
                                    </label>
                                    <input type="text" name="address" class="form-control border-dark border" required>
                                </div>

                            </div>
                            <div class="form-group row">
                                <div class="col-6">
                                    <label class="col-form-label">Contact
                                        <span class="text-danger"><em>(required)</em></span>
                                    </label>
                                    <input type="text" name="contact" class="form-control border-dark border" required>
                                </div>
                                <div class="col-6">
                                    <label class="col-form-label">Email
                                        <span class="text-danger"><em>(required)</em></span>
                                    </label>
                                    <input type="email" name="email" class="form-control border-dark border" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">Profile Image
                                    <span class="text-danger"><em>(required)</em></span>
                                </label>
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
            }
            else{
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
    if(isset($_GET['edit'])){
        if($_GET['edit']=='success'){
            echo '
                <div class="alert alert-success">
                    Librarian has been successfuly edited.
                </div>
            ';
        }
    }
    if(isset($_GET['editstatusactivate'])){
        if($_GET['editstatusactivate']=='success'){
            echo '
                <div class="alert alert-success">
                    Librarian has been successfuly Activated.
                </div>
            ';
        }
    }
    if(isset($_GET['editstatusdeactivate'])){
        if($_GET['editstatusdeactivate']=='success'){
            echo '
                <div class="alert alert-success">
                    Librarian has been successfuly Deactivated.
                </div>
            ';
        }if($_GET['editstatusdeactivate']=='ownaccount'){
            echo '
                <div class="alert alert-danger">
                There is at least one managing librarian panel, and you cannot deactivate your own account.
                </div>
            ';
        }
    }
    if(isset($_GET['updatepassword'])){
        if($_GET['updatepassword']=='success'){
            echo '
                <div class="alert alert-success">
                    Librarian password has been successfuly updated.
                </div>
            ';
        }elseif($_GET['updatepassword']=='notmatch'){
            echo '
                <div class="alert alert-danger">
                    Librarian password and confirm password didn\'t match.
                </div>
            ';
        }else{
            echo '
                <div class="alert alert-danger">
                    Error, please try again later.
                </div>
            ';
        }

    }
    if(isset($_GET['delete'])){
        if($_GET['delete']=='error'){
            if($_GET['account']=='you'){
                echo '
                    <div class="alert alert-danger">
                        Error, you cannot delete your own account.
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
                    <!--th scope="col">Update Password</th-->
                    <!--th scope="col">Delete</th-->
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
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
                                <!--td>********</td-->
                                <td>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#modalEdit'.$number.'"> Edit
                                    </button>
                                    <!-- edit modal -->
                                    <div class="modal fade" id="modalEdit'.$number.'" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="api/edit_librarian.php" method="post" enctype="multipart/form-data">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Edit Librarian</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                    <input type="hidden" name="librarian_id" value="'.$librarian['librarian_id'].'" required>
                                                        <div class="form-group row">
                                                            <div class="col-6">
                                                                <label class="col-form-label">User Name
                                                                    <span class="text-danger"><em>(required)</em></span>
                                                                </label>
                                                                <input type="text" name="uname" class="form-control border-dark border" value="'.$librarian['librarian_uname'].'" required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <div class="col-6">
                                                                <label class="col-form-label">First Name
                                                                    <span class="text-danger"><em>(required)</em></span>
                                                                </label>
                                                                <input type="text" name="fname" class="form-control border-dark border" value="'.$librarian['librarian_fname'].'" required>
                                                            </div>
                                                            <div class="col-6">
                                                                <label class="col-form-label">Last Name
                                                                    <span class="text-danger"><em>(required)</em></span>
                                                                </label>
                                                                <input type="text" name="lname" class="form-control border-dark border" value="'.$librarian['librarian_lname'].'" required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <div class="col-12">
                                                                <label class="col-form-label">Address
                                                                    <span class="text-danger"><em>(required)</em></span>
                                                                </label>
                                                                <input type="text" name="address" class="form-control border-dark border" value="'.$librarian['librarian_address'].'" required>
                                                            </div>

                                                        </div>
                                                        <div class="form-group row">
                                                            <div class="col-6">
                                                                <label class="col-form-label">Contact
                                                                    <span class="text-danger"><em>(required)</em></span>
                                                                </label>
                                                                <input type="text" name="contact" class="form-control border-dark border" value="'.$librarian['librarian_contact'].'" required>
                                                            </div>
                                                            <div class="col-6">
                                                                <label class="col-form-label">Email
                                                                    <span class="text-danger"><em>(required)</em></span>
                                                                </label>
                                                                <input type="email" name="email" class="form-control border-dark border" value="'.$librarian['librarian_email'].'" required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-form-label">ID Picture
                                                                <span class="text-danger">
                                                                    <em>
                                                                        (optional) (leave blank if you dont want to change the profile image)
                                                                    </em>
                                                                </span>
                                                            </label>
                                                            <input type="file" name="idpicture" accept=".png, .jpg, .jpeg"
                                                                class="form-control border-dark border">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" name="edit_librarian" class="btn btn-success">Submit</button>
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end edit modal -->
                                
                                </td>
                                <td>
                                
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#modalUpdatePassword'.$number.'"> Update Password
                                    </button>
                                    <!-- update password modal -->
                                    <div class="modal fade" id="modalUpdatePassword'.$number.'" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="api/edit_librarian.php" method="post" enctype="multipart/form-data">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Update Password</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <input type="hidden" name="librarian_id" value="'.$librarian['librarian_id'].'" required>
                                                        <div class="form-group row">
                                                            <div class="col-6">
                                                                <label class="col-form-label">New Password
                                                                    <span class="text-danger"><em>(required)</em></span>
                                                                </label>
                                                                <input type="password" name="new-password" class="form-control border-dark border" required>
                                                            </div>
                                                            <div class="col-6">
                                                                <label class="col-form-label">Confirm New Password
                                                                    <span class="text-danger"><em>(required)</em></span>
                                                                </label>
                                                                <input type="password" name="confirm-new-password" class="form-control border-dark border" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" name="edit_librarian_password" class="btn btn-success">Submit</button>
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end update password modal -->
                                
                                
                                </td>
                                <td>'.$librarian['librarian_status'].'</td>
                                <td>';
                                if($librarian['librarian_status']=='Activated'){
                                    echo    '<a type="button" class="btn btn-danger" href="api/edit_librarian_status.php?submit=yes&id='.$librarian['librarian_id'].'&status=deactivate&librarian_id='.$librarian_id.'">
                                                Deactivate
                                            </a>';
                                }else{
                                    echo    '<a type="button" class="btn btn-success" href="api/edit_librarian_status.php?submit=yes&id='.$librarian['librarian_id'].'&status=activate&librarian_id='.$librarian_id.'">
                                                Activate
                                            </a>';
                                }
                                echo '
                                </td>
                                <!--td>
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
                                </td-->
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