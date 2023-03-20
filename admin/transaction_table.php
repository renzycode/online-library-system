<?php

session_start();

$active = 'transaction-table';
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

        $sql = 'SELECT * FROM transaction_table AS tt, borrower_table AS bt 
        WHERE tt.borrower_id = bt.borrower_id';
        $statement = $pdo->prepare($sql);
        $statement->execute();
        $transactions = $statement->fetchAll();
    


?>

<!---------------->
<!-- START BODY -->
<!---------------->

<div class="m-4">
    <h2 class="mb-4 text-dark">
        <span class="page-title">Transaction Table</span>
        <hr>
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="">
            Download Report
        </button>
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="">
            Clear transaction
        </button>
    </h2>

    <?php

    if(isset($_GET['add'])){
        if($_GET['add']=='success'){
            echo '
            <div class="alert alert-success">
                Transaction has been successfully accepted.
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

    if(isset($_GET['edit'])){
        if($_GET['edit']=='success'){
            echo '
            <div class="alert alert-success">
                Transaction has been successfully updated.
            </div>
            ';
        }
        if($_GET['edit']=='error'){
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
                Transaction has been successfully deleted.
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
    <!-- add modal -->
    <div class="modal fade" id="modalAdd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="api/add_transaction.php" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add transaction</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body row">
                        <input type="hidden" name="librarian_id" value="<?php echo $librarian_id ?>">
                        <div class="form-group col-6 mb-0">
                            <label class="col-form-label">transaction Number
                                <span class="text-danger">(required)</span>
                            </label>
                            <input type="text" name="transaction_number" class="form-control border-dark border" required/>
                        </div>
                        <div class="form-group col-6 mb-0">
                            <label class="col-form-label">Book Title
                                <span class="text-danger">(required)</span>
                            </label>
                            <input type="text" name="transaction_book_title" class="form-control border-dark border" required/>
                        </div>
                        <div class="form-group col-6 mb-0">
                            <label class="col-form-label">Author
                                <span class="text-danger">(required)</span>
                            </label>
                            <input type="text" name="transaction_author" class="form-control border-dark border" required/>
                        </div>
                        <div class="form-group col-6 mb-0">
                            <label class="col-form-label">Publisher
                                <span class="text-danger">(required)</span>
                            </label>
                            <input type="text" name="transaction_publisher" class="form-control border-dark border" required/>
                        </div>
                        <div class="form-group col-6 mb-0">
                            <label class="col-form-label">Year
                                <span class="text-danger">(required)</span>
                            </label>
                            <input type="text" name="transaction_year" class="form-control border-dark border" required/>
                        </div>
                        <div class="form-group col-6 mb-0">
                            <label class="col-form-label">Date Received</label>
                            <input type="text" name="transaction_date_received" class="form-control border-dark border" />
                        </div>
                        <div class="form-group col-6 mb-0">
                            <label class="col-form-label">Class</label>
                            <input type="text" name="transaction_class" class="form-control border-dark border" />
                        </div>
                        <div class="form-group col-6 mb-0">
                            <label class="col-form-label">Edition</label>
                            <input type="text" name="transaction_edition" class="form-control border-dark border" />
                        </div>
                        <div class="form-group col-6 mb-0">
                            <label class="col-form-label">Volumes</label>
                            <input type="text" name="transaction_volumes" class="form-control border-dark border" />
                        </div>
                        <div class="form-group col-6 mb-0">
                            <label class="col-form-label">Pages</label>
                            <input type="text" name="transaction_pages" class="form-control border-dark border" />
                        </div>
                        <div class="form-group col-6 mb-0">
                            <label class="col-form-label">Source of Fund</label>
                            <input type="text" name="transaction_source_of_fund" class="form-control border-dark border" />
                        </div>
                        <div class="form-group col-6 mb-0">
                            <label class="col-form-label">Cost Price</label>
                            <input type="text" name="transaction_cost_price" class="form-control border-dark border" />
                        </div>
                        <div class="form-group col-6 mb-0">
                            <label class="col-form-label">Location Symbol</label>
                            <input type="text" name="transaction_location_symbol" class="form-control border-dark border" />
                        </div>
                        <div class="form-group col-6 mb-0">
                            <label class="col-form-label">Class Number</label>
                            <input type="text" name="transaction_class_number" class="form-control border-dark border" />
                        </div>
                        <div class="form-group col-6 mb-0">
                            <label class="col-form-label">Author Number</label>
                            <input type="text" name="transaction_author_number" class="form-control border-dark border" />
                        </div>
                        <div class="form-group col-6 mb-0">
                            <label class="col-form-label">Copyright Date</label>
                            <input type="text" name="transaction_copyright_date" class="form-control border-dark border" />
                        </div>
                        <div class="form-group col-6 mb-0">
                            <label class="col-form-label">Status</label>
                            <select class="form-select" aria-label="" name="transaction_status">
                                <option selected value="Available">Available</option>
                                <option value="Unavailable">Unavailable</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="add_transaction" class="btn btn-success">Submit</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
            </div>
            </form>
        </div>
    </div>
    <!-- end add modal -->
    <?php
    if ( count($transactions)<=0 ) {
        echo '
        <div class="alert alert-warning">
            No transactions to be displayed
        </div>
        ';
    }
    else{
        echo '
        <div class="table-responsive">
            <table class="table table-bordered border-secondary">
                <thead class="border">
                    <tr>
                        <th scope="col">No.</th>
                        <th scope="col">Transaction ID</th>
                        <th scope="col">Borrower ID</th>
                        <th scope="col">Borrower Full Name</th>
                        <th scope="col">Borrower Email</th>
                        <th scope="col">Borrow Date & Time</th>
                        <th scope="col">Return Date & Time</th>
                        <th scope="col">Status</th>
                        <th scope="col">View Borrowed Books</th>
                        <th scope="col">Edit</th>
                        <th scope="col">Delete</th>
                    </tr>
                </thead>
                <tbody class="border">
                ';
                    $number = 0;
                    foreach ($transactions as $transaction){
                        $number++;
                        echo '
                        <tr>
                            <td>'.$number.'</td>
                            <td>'.$transaction['transaction_id'].'</td>
                            <td>'.$transaction['borrower_id'].'</td>
                            <td>'.$transaction['borrower_fname'].' '.$transaction['borrower_lname'].'</td>
                            <td>'.$transaction['borrower_email'].'</td>
                            <td>'.$transaction['transaction_borrow_datetime'].'</td>
                            <td>'.$transaction['transaction_return_datetime'].'</td>
                            
                            
                            ';
                            if($transaction["transaction_status"]=="On Borrow"){
                                echo '
                                <td>
                                    <span class="text-danger">
                                        <i class="bi bi-exclamation-circle-fill"></i>
                                    </span>
                                    '.$transaction["transaction_status"].' 
                                </td>';
                            }else{
                                echo '
                                <td>
                                    <span class="text-success">
                                        <i class="bi bi-check-circle-fill"></i>
                                    </span>
                                    '.$transaction["transaction_status"].' 
                                </td>';
                            }
                            echo '
                            </td>
                            <td>
                                <button type="button" class="btn btn-secondary" data-bs-toggle="modal"
                                    data-bs-target="#modalView'.$number.'">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <!-- edit modal -->
                                <div class="modal fade" id="modalView'.$number.'" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="api/edit_transaction.php" method="post">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Borrowed Books</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body row">
                                                    
                                                    <div class="table-responsive">';

                                                        $sql2 = 'SELECT * FROM catalog_table
                                                        WHERE catalog_id = '.$transaction['catalog_id_1'];
                                                        $statement2 = $pdo->prepare($sql2);
                                                        $statement2->execute();
                                                        $catalog1 = $statement2->fetchAll();

                                                        $sql2 = 'SELECT * FROM catalog_table
                                                        WHERE catalog_id = '.$transaction['catalog_id_2'];
                                                        $statement2 = $pdo->prepare($sql2);
                                                        $statement2->execute();
                                                        $catalog2 = $statement2->fetchAll();

                                                        $sql2 = 'SELECT * FROM catalog_table
                                                        WHERE catalog_id = '.$transaction['catalog_id_3'];
                                                        $statement2 = $pdo->prepare($sql2);
                                                        $statement2->execute();
                                                        $catalog3 = $statement2->fetchAll();

                                                        $sql2 = 'SELECT * FROM catalog_table
                                                        WHERE catalog_id = '.$transaction['catalog_id_4'];
                                                        $statement2 = $pdo->prepare($sql2);
                                                        $statement2->execute();
                                                        $catalog4 = $statement2->fetchAll();

                                                        $sql2 = 'SELECT * FROM catalog_table
                                                        WHERE catalog_id = '.$transaction['catalog_id_5'];
                                                        $statement2 = $pdo->prepare($sql2);
                                                        $statement2->execute();
                                                        $catalog5 = $statement2->fetchAll();

                                                        echo '
                                                        <table class="table table-bordered border-secondary">
                                                            <thead class="border">
                                                                <tr>
                                                                    <th scope="col">No.</th>
                                                                    <th scope="col">Catalog ID</th>
                                                                    <th scope="col">Catalog Number</th>
                                                                    <th scope="col">Book Title</th>
                                                                    <th scope="col">Author</th>
                                                                    <th scope="col">Publisher</th>
                                                                    <th scope="col">Year</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="border">
                                                            ';
                                                                foreach ($catalog1 as $c){
                                                                    echo '
                                                                    <tr>
                                                                        <td>1</td>
                                                                        <td>'.$c['catalog_id'].'</td>
                                                                        <td>'.$c['catalog_number'].'</td>
                                                                        <td>'.$c['catalog_book_title'].'</td>
                                                                        <td>'.$c['catalog_author'].'</td>
                                                                        <td>'.$c['catalog_publisher'].'</td>
                                                                        <td>'.$c['catalog_year'].'</td>
                                                                    </tr>
                                                                    ';
                                                                }
                                                                foreach ($catalog2 as $c){
                                                                    echo '
                                                                    <tr>
                                                                        <td>2</td>
                                                                        <td>'.$c['catalog_id'].'</td>
                                                                        <td>'.$c['catalog_number'].'</td>
                                                                        <td>'.$c['catalog_book_title'].'</td>
                                                                        <td>'.$c['catalog_author'].'</td>
                                                                        <td>'.$c['catalog_publisher'].'</td>
                                                                        <td>'.$c['catalog_year'].'</td>
                                                                    </tr>
                                                                    ';
                                                                }
                                                                foreach ($catalog3 as $c){
                                                                    echo '
                                                                    <tr>
                                                                        <td>3</td>
                                                                        <td>'.$c['catalog_id'].'</td>
                                                                        <td>'.$c['catalog_number'].'</td>
                                                                        <td>'.$c['catalog_book_title'].'</td>
                                                                        <td>'.$c['catalog_author'].'</td>
                                                                        <td>'.$c['catalog_publisher'].'</td>
                                                                        <td>'.$c['catalog_year'].'</td>
                                                                    </tr>
                                                                    ';
                                                                }
                                                                foreach ($catalog4 as $c){
                                                                    echo '
                                                                    <tr>
                                                                        <td>4</td>
                                                                        <td>'.$c['catalog_id'].'</td>
                                                                        <td>'.$c['catalog_number'].'</td>
                                                                        <td>'.$c['catalog_book_title'].'</td>
                                                                        <td>'.$c['catalog_author'].'</td>
                                                                        <td>'.$c['catalog_publisher'].'</td>
                                                                        <td>'.$c['catalog_year'].'</td>
                                                                    </tr>
                                                                    ';
                                                                }
                                                                foreach ($catalog5 as $c){
                                                                    echo '
                                                                    <tr>
                                                                        <td>5</td>
                                                                        <td>'.$c['catalog_id'].'</td>
                                                                        <td>'.$c['catalog_number'].'</td>
                                                                        <td>'.$c['catalog_book_title'].'</td>
                                                                        <td>'.$c['catalog_author'].'</td>
                                                                        <td>'.$c['catalog_publisher'].'</td>
                                                                        <td>'.$c['catalog_year'].'</td>
                                                                    </tr>
                                                                    ';
                                                                }
                                                            echo '
                                                            </tbody>
                                                        </table>
                                                    </div>';

                                                echo '
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- end edit modal -->
                            </td>
                            <td>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#modalEdit'.$number.'">
                                    <i class="bi-pencil-square"></i>
                                </button>
                                <!-- edit modal -->
                                <div class="modal fade" id="modalEdit'.$number.'" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="api/edit_transaction.php" method="post">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Edit transaction</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body row">
                                                    <input type="hidden" name="transaction_id" value="'.$transaction['transaction_id'].'">
                                                    
                                                    <div class="form-group col-6 mb-0">
                                                        <label class="col-form-label">Status</label>
                                                        ';
                                                        if($transaction['transaction_status'] == "Returned"){
                                                            echo '
                                                            <select class="form-select" aria-label="" name="transaction_status">
                                                                <option selected value="Returned">Returned</option>
                                                                <option value="On Borrow">On Borrow</option>
                                                            </select>
                                                            ';
                                                        }else{
                                                            echo '
                                                            <select class="form-select" aria-label="" name="transaction_status">
                                                                <option selected value="On Borrow">On Borrow</option>
                                                                <option value="Returned">Returned</option>
                                                            </select>
                                                            ';
                                                        }
                                                    echo '
                                                    </div>

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" name="edit_transaction" class="btn btn-success">Submit</button>
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
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#modalDelete'.$number.'">
                                    <i class="bi-trash"></i>
                                </button>
                                <!-- delete modal -->
                                <div class="modal fade" id="modalDelete'.$number.'" tabindex="-1"
                                    aria-labelledby="" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="api/delete_transaction.php" method="post">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="">Delete transaction</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure you want to delete this transaction?
                                                </div>
                                                <input type="hidden" name="id" value="'.$transaction['transaction_id'].'">
                                                <div class="modal-footer">
                                                    <button type="submit" name="delete_transaction" class="btn btn-success">Yes</button>
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

    <!---------------->
    <!---- END BODY -->
    <!---------------->

<?php
include_once 'includes/footer.php';
?>