<?php

session_start();

$active = 'transaction';
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

        $sql = 'SELECT * FROM catalog_table ORDER BY catalog_book_title ASC';
        $statement = $pdo->prepare($sql);
        $statement->execute();
        $catalogs = $statement->fetchAll();

        $sql2 = 'SELECT * FROM borrower_table ORDER BY borrower_fname ASC';
        $statement2 = $pdo->prepare($sql2);
        $statement2->execute();
        $borrowers = $statement2->fetchAll();
    


?>

<!---------------->
<!-- START BODY -->
<!---------------->

<div class="m-4">
    <div class="row">
        <div class="form col-12 mb-4">
            <div class="border-left-primary border-top border-right border-bottom p-3 shadow rounded">
                <form action="api/add_transaction.php" method="POST">
                    <h5 class="modal-title" id="exampleModalLabel">Add Transaction</h5>
                    <hr>

                    <?php

                    if(isset($_GET['add'])){
                        if($_GET['add']=='success'){
                            echo '
                            <div class="alert alert-success">
                                Transaction has been successfully added.
                            </div>
                            ';
                        }
                        if($_GET['add']=='error'){
                            echo '
                            <div class="alert alert-danger">
                                Error, Please try again later.
                            </div>
                            ';
                        }
                    }

                    ?>

                    <div class="row">
                        <?php
                            echo '<input type="hidden" name="librarian_id" value="'.$librarian_id.'">';
                        ?>
                        <div class="form-group col-12 mb-1">
                            <div class="row">
                                <div class="col-2">
                                    <label for="bookNumber" class="col-form-label">
                                        <span><i class="bi bi-person-fill"></i></span>
                                        Borrower ID <span class="text-danger">(required)</span></label>
                                    <input type="text" name="borrower_id" class="form-control" required/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-2 mb-1">
                            <label for="bookNumber" class="col-form-label">
                                <span><i class="bi bi-book-half"></i></span>
                                Catalog ID 1 <span class="text-danger">(required)</span></label>
                            <input type="text" name="catalog_id_1" class="form-control" required/>
                        </div>
                        <div class="form-group col-2 mb-1">
                            <label for="bookNumber" class="col-form-label">
                                <span><i class="bi bi-book-half"></i></span>
                                Catalog ID 2</label>
                            <input type="text" name="catalog_id_2" class="form-control" />
                        </div>
                        <div class="form-group col-2 mb-1">
                            <label for="bookNumber" class="col-form-label">
                                <span><i class="bi bi-book-half"></i></span>
                                Catalog ID 3</label>
                            <input type="text" name="catalog_id_3" class="form-control" />
                        </div>
                        <div class="form-group col-2 mb-1">
                            <label for="bookNumber" class="col-form-label">
                                <span><i class="bi bi-book-half"></i></span>
                                Catalog ID 4</label>
                            <input type="text" name="catalog_id_4" class="form-control" />
                        </div>
                        <div class="form-group col-2 mb-1">
                            <label for="bookNumber" class="col-form-label">
                                <span><i class="bi bi-book-half"></i></span>
                                Catalog ID 5</label>
                            <input type="text" name="catalog_id_5" class="form-control" />
                        </div>
                        <div class="form-group col-12 mb-1">
                            <label for="author" class="col-form-label">Borrow Date & Time <span class="text-danger">(required)</span></label>
                            <div class="row">
                                <div class="col-2">
                                    <input type="date" name="borrow_date" class="form-control" required/>
                                </div>
                                <div class="col-2">
                                    <input type="time" name="borrow_time" class="form-control" required/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-12 mb-1">
                            <label for="author" class="col-form-label">Return Date & Time <span class="text-danger">(required)</span></label>
                            <div class="row">
                                <div class="col-2">
                                    <input type="date" name="return_date" class="form-control" required/>
                                </div>
                                <div class="col-2">
                                    <input type="time" name="return_time" class="form-control" required/>
                                </div>
                            </div>
                        </div>
                        <!-- div class="form-group">
                    <label for="author" class="col-form-label">Return Date Time</label>
                        <div class="row">
                            <div class="col-6">
                                <input type="date" name="book_author" class="form-control border-secondary border" />
                            </div>
                            <div class="col-6">
                                <input type="time" name="book_author" class="form-control border-secondary border" />
                            </div>
                        </div>
                    </div-->
                        <input type="hidden" name="librarian_id" class="form-control" value="<?php echo $librarian_id ?>"/>
                        <div class="form-group col-12">
                            <div class="mt-3">
                                <button type="submit" class="btn btn-success" name="add_transaction">Submit</button>
                                <a href="transaction.php" type="button" class="btn btn-secondary">Cancel</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="tables col-12">
            <div class="row">
                
                <div class="borrower-table col-6">
                    <div
                        class="table-responsive p-3 border-left-primary border-top border-right border-bottom p-3 shadow rounded">
                        <h5 class="modal-title" id="exampleModalLabel">List of Borrowers  <span><i class="bi bi-person-fill"></i></span></h5>
                        <hr>
                        <table class="table table-bordered myDataTable">
                            <thead>
                                <tr>
                                    <th scope="col">Borrower ID</th>
                                    <th scope="col">Last Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $number = 0;
                                foreach ($borrowers as $borrower){
                                    $number++;
                                    echo '
                                        <tr>
                                            <td class="">'.$borrower['borrower_id'].'</td>
                                            <td>'.$borrower['borrower_lname'].'</td>
                                            <td>'.$borrower['borrower_email'].'</td>
                                            <td>
                                                <button type="button" class="btn btn-primary" onclick="copyBorrowerId('.$borrower['borrower_id'].')">
                                                    <i class="bi bi-clipboard"></i>
                                                    Copy ID
                                                </button>
                                            </td>
                                        </tr>

                                    ';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="book-table col-6 ">
                    <div
                        class="table-responsive p-3 border-left-primary border-top border-right border-bottom p-3 shadow rounded">
                        <h5 class="modal-title" id="exampleModalLabel">List of Books <span><i class="bi bi-book-half"></i></span></h5>
                        <hr>
                        <table class="table table-bordered myDataTable">
                            <thead>
                                <tr>
                                    <th scope="col">Book ID</th>
                                    <th scope="col">Catalog Number</th>
                                    <th scope="col">Book Title</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $number = 0;
                                foreach ($catalogs as $catalog){
                                    $number++;
                                    echo '
                                        <tr>
                                            <td>'.$catalog['catalog_id'].'</td>
                                            <td>'.$catalog['catalog_number'].'</td>
                                            <td>'.$catalog['catalog_book_title'].'</td>
                                            <td>
                                            ';
                                            if($catalog['catalog_status']=='Available'){
                                                echo '
                                                    <button type="button" class="btn btn-primary" onclick="copyCatalogId('.$catalog['catalog_id'].')">
                                                        <i class="bi bi-clipboard"></i>
                                                        Copy ID
                                                    </button>
                                                ';
                                            }else{
                                                echo '
                                                    
                                                    <button type="button" class="btn btn-danger" disabled>
                                                        Unavailable
                                                    </button>
                                                ';
                                            }
                                            echo'
                                            </td>
                                        </tr>
                                    ';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<!---------------->
<!---- END BODY -->
<!---------------->

<?php
include_once 'includes/footer.php';
?>