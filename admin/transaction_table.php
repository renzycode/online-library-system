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

        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#modalreturn">
                                    Return Book
                                </button>
                                <!-- delete modal -->
                                <div class="modal fade" id="modalreturn" tabindex="-1"
                                    aria-labelledby="" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="api/edit_transaction.php" method="post">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="">Return Book</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group col-12 mb-1">
                                                        <div class="row">

                                                            <div class="form-group col-12 mb-1 border pb-3">
                                                                <div class="row">
                                                                    <div class="col-6">
                                                                        <label for="bookNumber" class="col-form-label">
                                                                            Book ID </label>
                                                                        <input type="text" name="book_id" class="form-control" id="book1"/>
                                                                        <!-- triggers modal and refresh rfid code -->
                                                                        <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal"
                                                                            data-bs-target="#book1modal" onclick="clearRFID1()">Scan RFID</button>
                                                                        
                                                                            <br>
                                                                        <button type="button" class="btn btn-success mt-2" data-bs-toggle="modal"
                                                                            data-bs-target="#book1modal" onclick="clearRFID1()">Submit</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            
                                                            <div class="col-6">
                                                                <label for="bookNumber" class="col-form-label">
                                                                    Transaction ID </label>
                                                                <input type="text" name="transaction_id" class="form-control"/>
                                                            </div>

                                                            <div class="col-6">
                                                                <label class="col-form-label"> Borrower ID </label>
                                                                <input type="text" class="form-control" value="">
                                                            </div>

                                                            <div class="col-12">
                                                                <label class="col-form-label"> Borrower Email </label>
                                                                <input type="text" class="form-control" value="">
                                                            </div>
                                                            
                                                            

                                                            <div class="col-12">
                                                                <label class="col-form-label"> Borrowed Book Info </label>
                                                                <div class="form-group col-12 mb-1 border pb-3">
                                                                    <div class="row">

                                                                        <div class="col-6">
                                                                            <label for="bookNumber" class="col-form-label">
                                                                                Book ID</label>
                                                                            <input type="text" name="book_id" class="form-control"/>
                                                                        </div>

                                                                        <div class="col-6">
                                                                            <label for="bookNumber" class="col-form-label">
                                                                                Catalog Number</label>
                                                                            <input type="text" name="book_id" class="form-control"/>
                                                                        </div>

                                                                        <div class="col-6">
                                                                            <label for="bookNumber" class="col-form-label">
                                                                                Book Title</label>
                                                                            <input type="text" name="book_id" class="form-control"/>
                                                                        </div>

                                                                        <div class="col-6">
                                                                            <label for="bookNumber" class="col-form-label">
                                                                                Publisher</label>
                                                                            <input type="text" name="book_id" class="form-control"/>
                                                                        </div>

                                                                        <div class="col-6">
                                                                            <label for="bookNumber" class="col-form-label">
                                                                                Author</label>
                                                                            <input type="text" name="book_id" class="form-control"/>
                                                                        </div>

                                                                        <div class="col-6">
                                                                            <label for="bookNumber" class="col-form-label">
                                                                                Year</label>
                                                                            <input type="text" name="book_id" class="form-control"/>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            


                                                            <div class="col-6">
                                                                <label class="col-form-label"> Borrow Date&Time</label>
                                                                <input type="text" class="form-control" value="">
                                                            </div>

                                                            <div class="col-6">
                                                                <label class="col-form-label"> Return Date&Time</label>
                                                                <input type="text" class="form-control" value="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-success" name="edit_transaction">Return Book</button>
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Cancel</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- end delete modal -->
                            </td>

        <a type="button" class="btn btn-success" href="download_reports/transaction.php">
            Download Report
        </a>
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
                Error Add, Please try again later.
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
                Error Edit, Please try again later.
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
                Error Delete, Please try again later.
            </div>
            ';
        }
    }
    ?>
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
                        <th scope="col">#</th>
                        <th scope="col">Transaction ID</th>
                        <th scope="col">Borrower ID</th>
                        <!--th scope="col">Borrower Full Name</th-->
                        <th scope="col">Borrower Email</th>

                        <th scope="col">Borrowed Book</th>

                        <th scope="col">Borrow Date&Time</th>
                        <th scope="col">Return Date&Time</th>
                        
                        
                        
                        <th scope="col">Date&Time Returned</th>
                        <th scope="col">Days&Hours Lapse</th>
                        
                        <th scope="col">Status</th>
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
                            <!--td>'.$transaction['borrower_fname'].' '.$transaction['borrower_lname'].'</td-->
                            <td>'.$transaction['borrower_email'].'</td>
                            
                            <td>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#modalView'.$number.'">
                                    View Book Info
                                </button>
                                <!-- delete modal -->
                                <div class="modal fade" id="modalView'.$number.'" tabindex="-1"
                                    aria-labelledby="" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="api/delete_transaction.php" method="post">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="">Book Info</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">';

                                                $sql = 'SELECT * FROM catalog_table WHERE book_id = ?';
                                                $statement = $pdo->prepare($sql);
                                                $statement->execute(array($transaction['book_id']));
                                                $book = $statement->fetch();

                                                    echo '
                                                    <div class="form-group col-12 mb-1">
                                                        <div class="row">

                                                            <div class="col-6">
                                                                <label class="col-form-label"> Book ID </label>
                                                                <input type="text" class="form-control" value="'.$book['book_id'].'">
                                                            </div>

                                                            <div class="col-6">
                                                                <label class="col-form-label"> Catalog Number </label>
                                                                <input type="text" class="form-control" value="'.$book['catalog_number'].'">
                                                            </div>

                                                            <div class="col-6">
                                                                <label class="col-form-label"> Book Title </label>
                                                                <input type="text" class="form-control" value="'.$book['catalog_book_title'].'">
                                                            </div>

                                                            <div class="col-6">
                                                                <label class="col-form-label"> Author </label>
                                                                <input type="text" class="form-control" value="'.$book['catalog_author'].'">
                                                            </div>

                                                            <div class="col-6">
                                                                <label class="col-form-label"> Publisher </label>
                                                                <input type="text" class="form-control" value="'.$book['catalog_publisher'].'">
                                                            </div>

                                                            <div class="col-6">
                                                                <label class="col-form-label"> Year </label>
                                                                <input type="text" class="form-control" value="'.$book['catalog_year'].'">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="id" value="'.$transaction['transaction_id'].'">
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- end delete modal -->
                            </td>
                            
                            
                            <td>'.$transaction['transaction_borrow_datetime'].'</td>
                            <td>'.$transaction['transaction_return_datetime'].'</td>

                            <td>'.$transaction['transaction_datetime_return'].'</td>
                            <td>'.$transaction['transaction_datetime_lapse'].'</td>

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