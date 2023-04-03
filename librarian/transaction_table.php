<?php

session_start();

$active = 'transaction-table';
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

        $sql = 'SELECT * FROM transaction_table AS tt, borrower_table AS bt 
        WHERE tt.borrower_id = bt.borrower_id AND tt.transaction_status = "On Borrow" ';
        $statement = $pdo->prepare($sql);
        $statement->execute();
        $onborrowtransactions = $statement->fetchAll();

        $sql = 'SELECT * FROM transaction_table AS tt, borrower_table AS bt 
        WHERE tt.borrower_id = bt.borrower_id AND tt.transaction_status = "Returned" ';
        $statement = $pdo->prepare($sql);
        $statement->execute();
        $returnedtransactions = $statement->fetchAll();
    
    $transaction = '';
    if(isset($_GET['transaction'])){
        if($_GET['transaction']=='on borrow'){
            $transaction = 'on borrow';
        }else{
            $transaction ='returned';
        }
    }else{
        redirectURL('transaction_table.php?transaction=on borrow');
    }

?>

<!---------------->
<!-- START BODY -->
<!---------------->

<div class="m-4">
    <h2 class="mb-4 text-dark">
        <span class="page-title">Transaction Table</span>
        <hr>

        <a href="transaction_table.php?transaction=on borrow" type="button" <?php
                if($transaction == "on borrow")
                    echo 'class="btn text-light btn-dark ml-1"';
                else
                    echo 'class="btn text-light btn-secondary ml-1"';
                ?>>
            On Borrow
        </a>
        <a href="transaction_table.php?transaction=returned" type="button" <?php
                if($transaction == "returned")
                    echo 'class="btn text-light btn-dark ml-1"';
                else
                    echo 'class="btn text-light btn-secondary ml-1"';
                ?>>
            Returned
        </a>
        <?php
            if($transaction == "on borrow"){
                echo '
                <a type="button" class="btn btn-success" href="download_reports/on_borrow_transaction.php">
                    Download Report
                </a>';
            }else{
                echo '
                <a type="button" class="btn btn-success" href="download_reports/returned_transaction.php">
                    Download Report
                </a>';
            }
        ?>

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

    <?php
        if($transaction=='on borrow'){
            if ( count($onborrowtransactions)<=0 ) {
                echo '
                <div class="alert alert-warning">
                    No on borrow transactions to be displayed
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
                                <th scope="col">Due Date&Time</th>
                                
                                
                                
                                <th scope="col">Date&Time Returned</th>
                                <th scope="col">Days&Hours Lapse</th>
                                
                                <th scope="col">Status</th>

                                <th scope="col">Penalty</th>
                                <th scope="col">Paid</th>

                                <th scope="col">Delete</th>
                            </tr>
                        </thead>
                        <tbody class="border">
                        ';
                            $number = 0;
                            foreach ($onborrowtransactions as $transaction){
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
                                    <td>'.$transaction['transaction_due_datetime'].'</td>

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

                                    <td>'.$transaction['transaction_penalty'].'</td>

                                    <td>'.$transaction['transaction_paid'].'</td>

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
                                                    <form action="api/delete_on_borrow_transaction.php" method="post">
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
        }
    ?>

    <?php
        if($transaction=='returned'){
            if ( count($returnedtransactions)<=0 ) {
                echo '
                <div class="alert alert-warning">
                    No returned transactions to be displayed
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

                                <th scope="col">Penalty</th>
                                <th scope="col">Paid</th>

                                <th scope="col">Delete</th>
                            </tr>
                        </thead>
                        <tbody class="border">
                        ';
                            $number = 0;
                            foreach ($returnedtransactions as $transaction){
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
                                    <td>'.$transaction['transaction_due_datetime'].'</td>

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


                                    <td>'.$transaction['transaction_penalty'].'</td>
                                    <td>';
                                    
                                    if($transaction['transaction_paid']=='----'){
                                        echo $transaction['transaction_paid'];
                                    }elseif($transaction['transaction_paid']=='Yes'){
                                        echo '
                                        <div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                Yes
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a href="api/edit_transaction_paid.php?transaction_id='.$transaction['transaction_id'].'&paid=no" class="dropdown-item" href="#">No</a></li>
                                            </ul>
                                        </div>
                                        ';
                                    }else{
                                        echo '
                                        <div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                No
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a href="api/edit_transaction_paid.php?transaction_id='.$transaction['transaction_id'].'&paid=yes" class="dropdown-item" href="#">Yes</a></li>
                                            </ul>
                                        </div>
                                        ';
                                    }

                                    echo '</td>

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
                                                    <form action="api/delete_returned_transaction.php" method="post">
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
        }
    ?>
</div>

<!---------------->
<!---- END BODY -->
<!---------------->

<?php
include_once 'includes/footer.php';
?>