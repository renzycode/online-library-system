<?php
$active = 'borrower';
include_once 'includes/header.php';

include_once "../includes/conn.php";
include_once "../includes/functions.php";

    if(!isset($_GET['borrower'])){
        redirectURL('borrower.php?borrower=pending');
    }else{
        $borrower = $_GET['borrower'];
        if($_GET['borrower']=='pending'){
            $sql = 'SELECT * FROM borrower_table WHERE borrower_status="pending"; ';
            $statement = $pdo->prepare($sql);
            $statement->execute();
            $pending_borrowers = $statement->fetchAll();
        }
        if($_GET['borrower']=='accepted'){
            $sql = 'SELECT * FROM borrower_table WHERE borrower_status="accepted"; ';
            $statement = $pdo->prepare($sql);
            $statement->execute();
            $accepted_borrowers = $statement->fetchAll();
        }
        if($_GET['borrower']=='rejected'){
            $sql = 'SELECT * FROM borrower_table WHERE borrower_status="rejected"; ';
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
            <a href="borrower.php?borrower=pending" type="button" 
                <?php
                if($borrower == "pending")
                    echo 'class="btn text-light btn-dark ml-1"';
                else
                    echo 'class="btn text-light btn-secondary ml-1"';
                ?>
                >
                Pending
            </a>
            <a href="borrower.php?borrower=accepted" type="button" 
                <?php
                if($borrower == "accepted")
                    echo 'class="btn text-light btn-dark ml-1"';
                else
                    echo 'class="btn text-light btn-secondary ml-1"';
                ?>
                >
                Accepted
            </a>
            <a href="borrower.php?borrower=rejected" type="button" 
                <?php
                if($borrower == "rejected")
                    echo 'class="btn text-light btn-dark ml-1"';
                else
                    echo 'class="btn text-light btn-secondary ml-1"';
                ?>
                >
                Rejected
            </a>   
                <?php
                if($borrower == "accepted"){
                ?>

                    <!-- view button if accepted section -->
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="">
                        Download Report
                    </button>

                <?php
                }elseif($borrower == "rejected"){
                ?>

                    <!-- view button if rejected section -->
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete-all-rejected">
                        Delete All
                    </button>

                    <!-- delete all modal -->
                    <div class="modal fade" id="delete-all-rejected" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('delete.all.rejected.borrower') }}" method="post">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Delete All Data</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure you want to delete all data?
                                    </div>
                                    <div class="modal-footer">
                                    <button type="submit" class="btn btn-success">Yes</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- end delete all modal -->

                <?php
                }
                ?>
        </h2>
        
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
                    Error, Please try again later.
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
                    Error, Please try again later.
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
                    Error, Please try again later.
                </div>
                ';
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
                                <th scope="col">No.</th>
                                <th scope="col">Id Picture</th>
                                <th scope="col">Borrower Id</th>
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
                                    <td>
                                        <button type="button" class="btn p-0 rounded border border-secondary" data-bs-toggle="modal" data-bs-target="#modalView'.$number.'">
                                            <!--i class="bi-eye"></i--> 
                                            <img class="p-0 rounded" src="../assets/image/idpictures/'.$pending['borrower_id_image_name'].'" width="40" height="40">
                                        </button>
                                        <!-- view pic modal -->
                                        <div class="modal fade" id="modalView'.$number.'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">'.$pending['borrower_fname'].'\'s ID Picture</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="d-flex justify-content-center m-2">
                                                        <img src="../assets/image/idpictures/'.$pending['borrower_id_image_name'].'" width="300">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end view pic modal -->
                                    </td>
                                    <td>'.$pending['borrower_id'].'</td>
                                    <td>'.$pending['borrower_fname'].'</td>
                                    <td>'.$pending['borrower_lname'].'</td>
                                    <td>'.$pending['borrower_address'].'</td>
                                    <td>'.$pending['borrower_contact'].'</td>
                                    <td>'.$pending['borrower_email'].'</td>
                                    
                                    <td>
                                        <!-- accept modal button-->
                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAccept'.$number.'">
                                            <i class="bi-check-circle"></i>
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
                                            <i class="bi-x-circle"></i>
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
                                <th scope="col">No.</th>
                                <th scope="col">Id Picture</th>
                                <th scope="col">Borrower Id</th>
                                <th scope="col">First Name</th>
                                <th scope="col">Last Name</th>
                                <th scope="col">Address</th>
                                <th scope="col">Contact</th>
                                <th scope="col">Email</th>
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
                                    <td>
                                        <button type="button" class="btn p-0 rounded border border-secondary" data-bs-toggle="modal" data-bs-target="#modalView'.$number.'">
                                            <!--i class="bi-eye"></i--> 
                                            <img class="p-0 rounded" src="../assets/image/idpictures/'.$accepted['borrower_id_image_name'].'" width="40" height="40">
                                        </button>
                                        <!-- view pic modal -->
                                        <div class="modal fade" id="modalView'.$number.'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">'.$accepted['borrower_fname'].'\'s ID Picture</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="d-flex justify-content-center m-2">
                                                        <img src="../assets/image/idpictures/'.$accepted['borrower_id_image_name'].'" width="300">
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end view pic modal -->
                                    </td>
                                    <td>'.$accepted['borrower_id'].'</td>
                                    <td>'.$accepted['borrower_fname'].'</td>
                                    <td>'.$accepted['borrower_lname'].'</td>
                                    <td>'.$accepted['borrower_address'].'</td>
                                    <td>'.$accepted['borrower_contact'].'</td>
                                    <td>'.$accepted['borrower_email'].'</td>
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
                    No rejecetd borrowers to be displayed
                </div>
                ';
            }
            else{
                echo '
                <div class="table-responsive">
                    <table class="table table-bordered" id="example">
                        <thead class="table-bordered">
                            <tr>
                                <th scope="col">No.</th>
                                <th scope="col">Id Picture</th>
                                <th scope="col">Borrower Id</th>
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
                                    <td>
                                        <button type="button" class="btn p-0 rounded border border-secondary" data-bs-toggle="modal" data-bs-target="#modalView'.$number.'">
                                            <!--i class="bi-eye"></i--> 
                                            <img class="p-0 rounded" src="../assets/image/idpictures/'.$rejected['borrower_id_image_name'].'" width="40" height="40">
                                        </button>
                                        <!-- view pic modal -->
                                        <div class="modal fade" id="modalView'.$number.'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">'.$rejected['borrower_fname'].'\'s ID Picture</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="d-flex justify-content-center m-2">
                                                        <img src="../assets/image/idpictures/'.$rejected['borrower_id_image_name'].'" width="300">
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end view pic modal -->
                                    </td>
                                    <td>'.$rejected['borrower_id'].'</td>
                                    <td>'.$rejected['borrower_fname'].'</td>
                                    <td>'.$rejected['borrower_lname'].'</td>
                                    <td>'.$rejected['borrower_address'].'</td>
                                    <td>'.$rejected['borrower_contact'].'</td>
                                    <td>'.$rejected['borrower_email'].'</td>
                                    <td>
                                        <!-- reject modal button -->
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalReject'.$number.'">
                                            <i class="bi-trash"></i>
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