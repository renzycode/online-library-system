<?php

session_start();

$active = 'librarian-table';
include_once "../includes/conn.php";
include_once "../includes/functions.php";
include_once 'includes/header.php';


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

        $sql = 'SELECT * FROM catalog_table ORDER BY catalog_book_title ASC';
        $statement = $pdo->prepare($sql);
        $statement->execute();
        $catalogs = $statement->fetchAll();

        $sql2 = 'SELECT * FROM borrower_table WHERE borrower_status = "accepted" ORDER BY borrower_fname ASC';
        $statement2 = $pdo->prepare($sql2);
        $statement2->execute();
        $borrowers = $statement2->fetchAll();
    


?>

<!---------------->
<!-- START BODY -->
<!---------------->

<div class="m-4">
    <div class="row">

        <div class="form col-12 col-lg-6 mb-4">
            <div class="border-left-primary border-top border-right border-bottom p-3 shadow rounded">

                    <h5 class="modal-title" id="exampleModalLabel">Update Account Profile</h5>
                    <hr>

                    <?php

                    if(isset($_GET['add'])){
                        echo '
                        <div class="alert alert-success">
                            Transaction has been successfully added.
                        </div>
                        ';
                    }

                    ?>

                    <div class="row">

                        <div class="form-group col-12 mb-1">
                            <div class="row">
                                <div class="col-6 col-lg-3">
                                    <label for="bookNumber" class="col-form-label">
                                        Profile Image</label>
                                    <img src="../assets/image/idpictures/pic2.jpg" class="border border-secondary rounded" alt="" width="100" height="100">
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-12 mb-1">
                            <div class="row">
                                <div class="col-6 col-lg-2">
                                    <input class="mt-3" type="file" name="borrower_id" class="form-control"/>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="librarian_id" class="form-control"
                            value="<?php echo $librarian_id ?>" />
                        <div class="form-group col-12">
                            <div class="mt-3">
                                <button type="submit" class="btn btn-success" name="add_transaction">Upload</button>
                                <a href="transaction.php" type="button" class="btn btn-secondary">Cancel</a>
                            </div>
                        </div>

                        <div class="form-group col-12 mb-1">
                            <div class="row">
                                <div class="col-6 col-lg-6">
                                    <label for="bookNumber" class="col-form-label">
                                        Username <span class="text-danger">*</span></label>
                                    <input type="text" name="borrower_id" class="form-control" required />
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-12 mb-1">
                            <div class="row">
                                <div class="col-6 col-lg-6">
                                    <label for="bookNumber" class="col-form-label">
                                        First Name</label>
                                    <input type="text" name="borrower_id" class="form-control"/>
                                </div>
                                <div class="col-6 col-lg-6">
                                    <label for="bookNumber" class="col-form-label">
                                        Last Name</label>
                                    <input type="text" name="book_id" class="form-control" id="book1"/>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-12 mb-1">
                            <div class="row">
                                <div class="col-6 col-lg-6">
                                    <label for="bookNumber" class="col-form-label">
                                        Contact</label>
                                    <input type="text" name="borrower_id" class="form-control"/>
                                </div>
                                <div class="col-6 col-lg-6">
                                    <label for="bookNumber" class="col-form-label">
                                        Email <span class="text-danger">*</span></label>
                                    <input type="text" name="book_id" class="form-control" id="book1" required />
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="librarian_id" class="form-control"
                            value="<?php echo $librarian_id ?>" />
                        <div class="form-group col-12">
                            <div class="mt-3">
                                <button type="submit" class="btn btn-success" name="add_transaction">Update</button>
                                <a href="transaction.php" type="button" class="btn btn-secondary">Cancel</a>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <h5 class="modal-title" id="exampleModalLabel">Update Password</h5>
                    <hr>

                    <?php

                    if(isset($_GET['add'])){
                        echo '
                        <div class="alert alert-success">
                            Transaction has been successfully added.
                        </div>
                        ';
                    }

                    ?>

                    <div class="row">

                        <div class="form-group col-12 mb-1">
                            <div class="row">
                                <div class="col-6 col-lg-6">
                                    <label for="bookNumber" class="col-form-label">
                                        New Password<span class="text-danger">*</span></label>
                                    <input type="text" name="borrower_id" class="form-control" required />
                                </div>
                                <div class="col-6 col-lg-6">
                                    <label for="bookNumber" class="col-form-label">
                                        Confirm New Password<span class="text-danger">*</span></label>
                                    <input type="text" name="book_id" class="form-control" id="book1" required />
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="librarian_id" class="form-control"
                            value="<?php echo $librarian_id ?>" />
                        <div class="form-group col-12">
                            <div class="mt-3">
                                <button type="submit" class="btn btn-success" name="add_transaction">Update</button>
                                <a href="transaction.php" type="button" class="btn btn-secondary">Cancel</a>
                            </div>
                        </div>
                    </div>

            </div>
        </div>
        
        

    </div>
</div>

<!---------------->
<!---- END BODY -->
<!---------------->

<?php
include_once 'includes/footer.php';
?>