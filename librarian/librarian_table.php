<?php

session_start();

$active = 'librarian-table';
include_once 'includes/header.php';

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
    


?>

<!---------------->
<!-- START BODY -->
<!---------------->

<div class="m-4">
    <h2 class="mb-4 text-dark">
        <span class="page-title">Librarian Table</span>
        <br>
        <hr>
        <button type="button" class="btn btn-success mx-1 my-2" data-bs-toggle="modal" data-bs-target="#modalRegister">
            Add
        </button>
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
                                    <label class="col-form-label">User Name</label>
                                    <input type="text" name="uname" class="form-control border-dark border" required>
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
                                <div class="col-6">
                                    <label class="col-form-label">Address</label>
                                    <input type="text" name="address" class="form-control border-dark border" required>
                                </div>
                                <div class="col-6">
                                    <label class="col-form-label">Contact</label>
                                    <input type="text" name="contact" class="form-control border-dark border" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">Email</label>
                                <input type="email" name="email" class="form-control border-dark border" required>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">Password</label>
                                <input type="password" name="password" class="form-control border-dark border" required>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">ID Picture</label>
                                <input type="file" name="idpicture" accept=".png, .jpg, .jpeg"
                                    class="form-control border-dark border" required>
                            </div>
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
        <!-- view button if accepted section -->
        <a href="download_reports/accepted_borrower.php" type="button" class="btn btn-success">
            Download Report
        </a>
    </h2>

    <?php

    if(isset($_GET['delete'])){
        if($_GET['delete']=='success'){
            echo '
            <div class="alert alert-success">
                Transaction has been successfully deleted.
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
                                <td>'.$librarian['librarian_image_name'].'</td>
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
                                <td><button class="btn btn-danger"> Delete </button></td>
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