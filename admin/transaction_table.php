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
                        <th scope="col">Borrow Date&Time</th>
                        <th scope="col">Return Date&Time</th>
                        <th scope="col">View Borrowed Books</th>
                        
                        
                        <th scope="col">Date&Time Returned</th>
                        <th scope="col">Days&Hours Lapse</th>
                        
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
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
                            <td>'.$transaction['transaction_borrow_datetime'].'</td>
                            <td>'.$transaction['transaction_return_datetime'].'</td>
                            
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
                                                        WHERE book_id = '.$transaction['book_id_1'];
                                                        $statement2 = $pdo->prepare($sql2);
                                                        $statement2->execute();
                                                        $catalog1 = $statement2->fetchAll();

                                                        $sql2 = 'SELECT * FROM catalog_table
                                                        WHERE book_id = '.$transaction['book_id_2'];
                                                        $statement2 = $pdo->prepare($sql2);
                                                        $statement2->execute();
                                                        $catalog2 = $statement2->fetchAll();

                                                        $sql2 = 'SELECT * FROM catalog_table
                                                        WHERE book_id = '.$transaction['book_id_3'];
                                                        $statement2 = $pdo->prepare($sql2);
                                                        $statement2->execute();
                                                        $catalog3 = $statement2->fetchAll();

                                                        $sql2 = 'SELECT * FROM catalog_table
                                                        WHERE book_id = '.$transaction['book_id_4'];
                                                        $statement2 = $pdo->prepare($sql2);
                                                        $statement2->execute();
                                                        $catalog4 = $statement2->fetchAll();

                                                        $sql2 = 'SELECT * FROM catalog_table
                                                        WHERE book_id = '.$transaction['book_id_5'];
                                                        $statement2 = $pdo->prepare($sql2);
                                                        $statement2->execute();
                                                        $catalog5 = $statement2->fetchAll();

                                                        echo '
                                                        <table class="table table-bordered border-secondary">
                                                            <thead class="border">
                                                                <tr>
                                                                    <th scope="col">#</th>
                                                                    <th scope="col">Book ID</th>
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
                                                                        <td>'.$c['book_id'].'</td>
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
                                                                        <td>'.$c['book_id'].'</td>
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
                                                                        <td>'.$c['book_id'].'</td>
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
                                                                        <td>'.$c['book_id'].'</td>
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
                                                                        <td>'.$c['book_id'].'</td>
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
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#modalEdit'.$number.'"
                                    '; 
                                    if($transaction["transaction_status"]=="Returned"){
                                        echo 'disabled';
                                    }
                                    echo ' 
                                    >
                                    Return Books
                                </button>
                                <!-- edit modal -->
                                <div class="modal fade" id="modalEdit'.$number.'" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="api/edit_transaction.php" method="post">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Return Books</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="hidden" name="transaction_id" value="'.$transaction['transaction_id'].'">
                                                    
                                                    Are you sure that the books are returned?

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" name="edit_transaction" class="btn btn-success">Continue</button>
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