<?php

session_start();

$active = 'borrower';
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

    if(!isset($_GET['borrower'])){
        //redirectURL('borrower.php?borrower=pending');
        redirectURL('borrower.php?borrower=accepted');
    }else{
        $borrower = $_GET['borrower'];
        if($_GET['borrower']=='pending'){
            $sql = 'SELECT * FROM borrower_table WHERE borrower_status="pending" ORDER BY borrower_fname; ';
            $statement = $pdo->prepare($sql);
            $statement->execute();
            $pending_borrowers = $statement->fetchAll();
        }
        if($_GET['borrower']=='accepted'){
            $sql = 'SELECT * FROM borrower_table WHERE borrower_status="accepted" ORDER BY borrower_fname; ';
            $statement = $pdo->prepare($sql);
            $statement->execute();
            $accepted_borrowers = $statement->fetchAll();
        }
        if($_GET['borrower']=='rejected'){
            $sql = 'SELECT * FROM borrower_table WHERE borrower_status="rejected" ORDER BY borrower_fname; ';
            $statement = $pdo->prepare($sql);
            $statement->execute();
            $rejected_borrowers = $statement->fetchAll();
        }
    }
    


?>



<div class="m-4">
    <h2 class="mb-4 text-dark">
        <span class="page-title">
            <?php 
                if($borrower=="pending")
                    echo "Pending";
                if($borrower=="accepted")
                    echo "Accepted";
                if($borrower=="rejected")
                    echo "Rejected";
            ?>
            Borrowers
        </span>
        <br>
        <hr>
        <?php
                if($borrower == "accepted"){
                ?>
        <button type="button" class="btn btn-success mx-1 my-2" data-bs-toggle="modal" data-bs-target="#modalRegister">
            Add
        </button>

        <!-- view button if accepted section -->
        <a href="download_reports/accepted_borrower.php" type="button" class="btn btn-success">
            Download Report
        </a>

        <?php
                }elseif($borrower == "rejected"){
                ?>

        <!-- view button if rejected section -->
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete-all-rejected">
            Delete All
        </button>


        <?php
                }
                ?>
    </h2>

    <!-- register modal -->
    <div class="modal fade" id="modalRegister" tabindex="-1" aria-labelledby="registerModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="api/add_accepted_borrower.php" method="POST" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title" id="registerModal">Add Accepted Borrower</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
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
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- end edit modal -->

    <!-- delete all modal -->
    <div class="modal fade" id="delete-all-rejected" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="api/delete_all_rejected_borrowers.php" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Delete All Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete all rejected borrowers?
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="delete_all_rejected_borrowers" class="btn btn-success">Yes</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- end delete all modal -->

    <?php

        if(isset($_GET['accept'])){
            if($_GET['accept']=='success'){
                echo '
                <div class="alert alert-success">
                    Borrower has been successfully accepted.
                </div>
                ';
            }
            if($_GET['accept']=='error'){
                echo '
                <div class="alert alert-danger">
                    Error Accept, Please try again later.
                </div>
                ';
            }
        }


        
        if(isset($_GET['edit'])){
            if($_GET['edit']=='success'){
                echo '
                <div class="alert alert-success">
                    Borrower has been successfully edited.
                </div>
                ';
            }
            if($_GET['edit']=='error'){
                echo '
                <div class="alert alert-danger">
                    Error Accept, Please try again later.
                </div>
                ';
            }
        }

        if(isset($_GET['reject'])){
            if($_GET['reject']=='success'){
                echo '
                <div class="alert alert-success">
                    Borrower has been successfully rejected.
                </div>
                ';
            }
            if($_GET['reject']=='error'){
                echo '
                <div class="alert alert-danger">
                    Error Reject, Please try again later.
                </div>
                ';
            }
        }

        if(isset($_GET['deleteall'])){
            if($_GET['deleteall']=='success'){
                echo '
                <div class="alert alert-success">
                    All rejected Borrowers has been successfully deleted.
                </div>
                ';
            }
            if($_GET['deleteall']=='error'){
                echo '
                <div class="alert alert-danger">
                    Error Delete All, Please try again later.
                </div>
                ';
            }
        }

        if(isset($_GET['delete'])){
            if($_GET['delete']=='success'){
                echo '
                <div class="alert alert-success">
                    Borrower has been successfully deleted.
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

        if(isset($_GET['add'])){
            if($_GET['add']=='success'){
                echo '
                <div class="alert alert-success">
                    Borrower has been successfully deleted.
                </div>
                ';
            }
            if($_GET['add']=='error'){
                if(isset($_GET['error'])){
                    if($_GET['error']=='emailalreadyused'){
                        echo '
                        <div class="alert alert-danger">
                            Error, Email already used.
                        </div>
                        ';
                    }
                }else{
                    echo '
                    <div class="alert alert-danger">
                        Error, Please try again later.
                    </div>
                    ';
                }
                
            }
        }

        ?>

    <!-- pending borrowers -->
    <?php
        if($borrower=='pending'){
            if ( count($pending_borrowers)<=0 ){
                echo'
                <div class="alert alert-warning">
                    No pending borrowers to be displayed
                </div>
                ';
            }
            else{
                echo'
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="border">
                            <tr>
                                <th scope="col">#</th>
                                <!--th scope="col">Id Picture</th-->
                                <!--th scope="col">Borrower Id</th-->
                                <th scope="col">First Name</th>
                                <th scope="col">Last Name</th>
                                <th scope="col">Address</th>
                                <th scope="col">Contact</th>
                                <th scope="col">Email</th>
                                <th scope="col">Accept</th>
                                <th scope="col">Reject</th>
                            </tr>
                        </thead>
                        <tbody class="border">
                        ';
                        $number = 0;
                            foreach ($pending_borrowers as $pending){
                                $number++;
                                echo '
                                <tr>
                                    <td>'.$number.'</td>
                                    <!--td>'.$pending['borrower_id'].'</td-->
                                    <td>'.$pending['borrower_fname'].'</td>
                                    <td>'.$pending['borrower_lname'].'</td>
                                    <td>'.$pending['borrower_address'].'</td>
                                    <td>'.$pending['borrower_contact'].'</td>
                                    <td>'.$pending['borrower_email'].'</td>
                                    
                                    <td>
                                        <!-- accept modal button-->
                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAccept'.$number.'">
                                            Accept
                                        </button>
                                        <!-- accept modal -->
                                        <div class="modal fade" id="modalAccept'.$number.'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="api/accept_borrower.php" method="POST">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Accept Borrower</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Are you sure you want to accept this borrower?
                                                            <input type="hidden" name="id" value="'.$pending['borrower_id'].'">
                                                        </div>
                                                        <div class="modal-footer">
                                                        <button type="submit" name="accept_borrower" class="btn btn-success">Yes</button>
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end accept modal -->
                                    </td>
                                    <td>
                                        <!-- reject modal button -->
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalReject'.$number.'">
                                            Reject
                                        </button>
                                        <!-- reject modal -->
                                        <div class="modal fade" id="modalReject'.$number.'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="api/reject_borrower.php" method="post">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Reject Borrower</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Are you sure you want to reject this borrower?
                                                            <input type="hidden" name="id" value="'.$pending['borrower_id'].'">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" name="reject_borrower" class="btn btn-success">Yes</button>
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end reject modal -->
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
        }
        ?>
    <!-- end pending borrowers -->

    <!-- accepted borrowers -->
    <?php
        if($borrower=='accepted'){
            if ( count($accepted_borrowers)<=0 ){
                echo '
                <div class="alert alert-warning">
                    No accepted borrowers to be displayed
                </div>
                ';
            }
            else{
                echo '
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="border">
                            <tr>
                                <th scope="col">#</th>
                                <!--th scope="col">Borrower Id</th-->
                                <th scope="col">First Name</th>
                                <th scope="col">Last Name</th>
                                <th scope="col">Address</th>
                                <th scope="col">Contact</th>
                                <th scope="col">Email</th>
                                <th scope="col">Borrow</th>
                                <th scope="col">Edit</th>
                                <th scope="col">Delete</th>
                            </tr>
                        </thead>
                        <tbody class="border">
                        ';
                        $number = 0;
                            foreach ($accepted_borrowers as $accepted){
                                $number++;
                                echo '
                                <tr>
                                    <td>'.$number.'</td>
                                    <!--td>'.$accepted['borrower_id'].'</td-->
                                    <td>'.$accepted['borrower_fname'].'</td>
                                    <td>'.$accepted['borrower_lname'].'</td>
                                    <td>'.$accepted['borrower_address'].'</td>
                                    <td>'.$accepted['borrower_contact'].'</td>
                                    <td>'.$accepted['borrower_email'].'</td>
                                    <td><a href="transaction.php?borrower='.$accepted['borrower_id'].'" class="btn btn-success"> Borrow </a></td>
                                    <td>
                                        <!-- reject modal button -->
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalEdit'.$number.'">
                                            Edit
                                        </button>
                                        

                                        <div class="modal fade" id="modalEdit'.$number.'" tabindex="-1" aria-labelledby="registerModal"
                                            aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="api/edit_accepted_borrower.php" method="POST" enctype="multipart/form-data">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="registerModal">Edit Accepted Borrower</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <input type="hidden" name="id" value="'.$accepted['borrower_id'].'">
                                                            <div class="form-group row">
                                                                <div class="col-6">
                                                                    <label class="col-form-label">First Name
                                                                        <span class="text-danger"><em>(required)</em></span>
                                                                    </label>
                                                                    <input type="text" name="fname" class="form-control border-dark border"  value="'.$accepted['borrower_fname'].'" required>
                                                                </div>
                                                                <div class="col-6">
                                                                    <label class="col-form-label">Last Name
                                                                        <span class="text-danger"><em>(required)</em></span>
                                                                    </label>
                                                                    <input type="text" name="lname" class="form-control border-dark border" value="'.$accepted['borrower_lname'].'" required>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-12">
                                                                    <label class="col-form-label">Address
                                                                        <span class="text-danger"><em>(required)</em></span>
                                                                    </label>
                                                                    <input type="text" name="address" class="form-control border-dark border" value="'.$accepted['borrower_address'].'" required>
                                                                </div>

                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-6">
                                                                    <label class="col-form-label">Contact
                                                                        <span class="text-danger"><em>(required)</em></span>
                                                                    </label>
                                                                    <input type="text" name="contact" class="form-control border-dark border" value="'.$accepted['borrower_contact'].'" required>
                                                                </div>
                                                                <div class="col-6">
                                                                    <label class="col-form-label">Email
                                                                        <span class="text-danger"><em>(required)</em></span>
                                                                    </label>
                                                                    <input type="email" name="email" class="form-control border-dark border" value="'.$accepted['borrower_email'].'" required>
                                                                </div>
                                                            </div>
                                                            <!--div class="form-group">
                                                                <label class="col-form-label">Profile Image
                                                                    <span class="text-danger"><em>(required)</em></span>
                                                                </label>
                                                                <input type="file" name="idpicture" accept=".png, .jpg, .jpeg"
                                                                    class="form-control border-dark border" value="logo.png">
                                                            </div-->
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" name="edit_accepted_borrower" class="btn btn-success">Submit</button>
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Cancel</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>


                                        <!-- end edit modal -->
                                    </td>

                                    <td>
                                        <!-- reject modal button -->
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalDelete'.$number.'">
                                            Delete
                                        </button>
                                        <!-- delete modal -->
                                        <div class="modal fade" id="modalDelete'.$number.'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="api/delete_accepted_borrower.php" method="post">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Delete Borrower</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Are you sure you want to delete this borrower?
                                                            <input type="hidden" name="id" value="'.$accepted['borrower_id'].'">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" name="delete_accepted_borrower" class="btn btn-success">Yes</button>
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
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
        }
        ?>
    <!-- end accepted borrowers -->

    <!-- rejected borrowers -->
    <?php
        if($borrower=='rejected'){
            if ( count($rejected_borrowers)<=0 ){
                echo'
                <div class="alert alert-warning">
                    No rejected borrowers to be displayed
                </div>
                ';
            }
            else{
                echo '
                <div class="table-responsive">
                    <table class="table table-bordered" id="example">
                        <thead class="table-bordered">
                            <tr>
                                <th scope="col">#</th>
                                <!--th scope="col">Borrower Id</th-->
                                <th scope="col">First Name</th>
                                <th scope="col">Last Name</th>
                                <th scope="col">Address</th>
                                <th scope="col">Contact</th>
                                <th scope="col">Email</th>
                                <th scope="col">Delete</th>
                            </tr>
                        </thead>
                        <tbody class="table-bordered">
                        ';
                        $number = 0;
                            foreach ($rejected_borrowers as $rejected){
                                $number++;
                                echo'
                                <tr>
                                    <td>'.$number.'</td>
                                    <!--td>'.$rejected['borrower_id'].'</td-->
                                    <td>'.$rejected['borrower_fname'].'</td>
                                    <td>'.$rejected['borrower_lname'].'</td>
                                    <td>'.$rejected['borrower_address'].'</td>
                                    <td>'.$rejected['borrower_contact'].'</td>
                                    <td>'.$rejected['borrower_email'].'</td>
                                    <td>
                                        <!-- reject modal button -->
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalReject'.$number.'">
                                            Delete
                                        </button>
                                        <!-- delete modal -->
                                        <div class="modal fade" id="modalReject'.$number.'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="api/delete_rejected_borrower.php" method="post">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Delete Data</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Are you sure you want to delete this data?
                                                            <input type="hidden" name="id" value="'.$rejected['borrower_id'].'">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" name="delete_rejected_borrower" class="btn btn-success">Yes</button>
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
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
        }
        ?>
    <!-- end rejected borrowers -->

</div>


<?php
include_once 'includes/footer.php';
?>