<?php

session_start();

$active = 'return-book';
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

$string = '';
date_default_timezone_set("Asia/Hong_Kong");

$returnDateTime = strtotime('2023-03-29 01:01 am');

$returnDateTimeConverted = date("Y-m-d H:i", $returnDateTime);
$currentDateTimeConverted = date("Y-m-d H:i");

$return_date_time=strtotime($returnDateTimeConverted);
$current_date_time=strtotime($currentDateTimeConverted);

$difference=$current_date_time-$return_date_time;

$hours=($difference / 3600);
$minutes=($difference / 60 % 60);
$seconds=($difference % 60);
$days=($hours/24);
$hours=($hours % 24);
if($hours<0){
    $string = 'No penalty';
}else{
    if($days<0){
        $string = ceil($days). " days & ";
    }else{
        $string = floor($days). " days & ";
    }

    $hour = sprintf("%02d",$hours);
    if($hour==1){
        $string = $string.$hour." hour";
    }else{
        $string = $string.$hour." hours";
    }
}

//echo  $string;


?>

<!------------------------------->
<!-- START BODY -->
<!------------------------------->


<div class="m-4">

    <?php

    if(isset($_GET['return'])){
        if($_GET['return']=='success'){
            echo '
            <div class="alert alert-success">
                Transaction has been successfully updated.
            </div>
            ';
        }
        if($_GET['return']=='error'){
            if($_GET['id']=='empty'){
                echo '
                <div class="alert alert-danger">
                    Error, There is no book to be returned.
                </div>
                ';
            }else{
                echo '
                <div class="alert alert-danger">
                    Error Add, Please try again later.
                </div>
                ';
            }
        }
    }

    ?>
    <div class="col-12">
        <div class="row">
            <div class=" col-lg-6 col-12 col-md-8">
                <div class=" p-3 border-left-primary border-top border-right border-bottom shadow rounded">
                    <h5 id="exampleModalLabel">Return Book</h5>
                    <hr>
                    <div class="form-group col-12 mb-1">
                        <div class="row">

                            <form action="">
                                <div class="form-group col-12 mb-1 border pb-3">
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="bookNumber" class="col-form-label">
                                                Book ID </label>
                                            <input type="text" name="book_id" class="form-control" id="book1"
                                                required />
                                            <!-- triggers modal and refresh rfid code -->
                                            <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal"
                                                data-bs-target="#book1modal" onclick="clearRFID1()">Scan RFID</button>

                                            <br>
                                            <button type="submit" class="btn btn-success mt-2">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <form action="api/edit_transaction.php" method="post">
                                <?php
                                $data = array(
                                    'transaction_id'=>'----------',
                                    'borrower_id'=>'----------',
                                    'borrower_email'=>'----------',
                                    'book_id'=>'----------',
                                    'catalog_number'=>'----------',
                                    'book_title'=>'----------',
                                    'author'=>'----------',
                                    'publisher'=>'----------',
                                    'year'=>'----------',
                                    'borrow_datetime'=>'----------',
                                    'return_datetime'=>'----------'
                                );



                                if(isset($_GET['book_id'])){
                                    $sql = 'SELECT * FROM transaction_table as tt, catalog_table as ct, borrower_table as bt
                                    WHERE tt.book_id = ? AND ct.book_id = ? AND bt.borrower_id = tt.borrower_id AND transaction_status = "On Borrow"';
                                    $statement = $pdo->prepare($sql);
                                    $statement->execute(array($_GET['book_id'],$_GET['book_id']));
                                    $transaction = $statement->fetch();
                                    if(!empty($transaction)){
                                        if($transaction['book_id']==$_GET['book_id']){

                                            $sql = 'SELECT * FROM author_book_bridge_table WHERE book_id = ?';
                                            $statement = $pdo->prepare($sql);
                                            $statement->execute(array($_GET['book_id']));
                                            $book_ids = $statement->fetchAll();
                                            
                                            $author_names = '';

                                            foreach($book_ids as $book_id){
                                                if(empty($author_names)){
                                                    $sql = 'SELECT * FROM author_table WHERE author_id = ?';
                                                    $statement = $pdo->prepare($sql);
                                                    $statement->execute(array($book_id['author_id']));
                                                    $author = $statement->fetch();
                                                    $author_names = $author_names.$author['author_fullname'];
                                                }else{
                                                    $sql = 'SELECT * FROM author_table WHERE author_id = ?';
                                                    $statement = $pdo->prepare($sql);
                                                    $statement->execute(array($book_id['author_id']));
                                                    $author = $statement->fetch();
                                                    $author_names = $author_names.', '.$author['author_fullname'];
                                                }
                                            }


                                            $data = array();
                                            $data = array(
                                                'transaction_id'=>$transaction['transaction_id'],
                                                'borrower_id'=>$transaction['borrower_id'],
                                                'borrower_email'=>$transaction['borrower_email'],
                                                'book_id'=>$transaction['book_id'],
                                                'catalog_number'=>$transaction['catalog_number'],
                                                'book_title'=>$transaction['catalog_book_title'],
                                                'author'=>$author_names,
                                                'publisher'=>$transaction['catalog_publisher'],
                                                'year'=>$transaction['catalog_year'],
                                                'borrow_datetime'=>$transaction['transaction_borrow_datetime'],
                                                'return_datetime'=>$transaction['transaction_due_datetime']
                                            );
                                        }
                                    }else{
                                        echo '
                                        <div class="row mx-1">
                                            <div class="col-12 mb-0 mt-3">
                                                <div class="alert alert-danger py-2 mb-2">There is no pending transaction for this book.</div>
                                            </div>
                                        </div>
                                        ';
                                    }
                                    
                                }

                            ?>


                                <div class="row mx-1">
                                    <div class="col-6">
                                        <label for="bookNumber" class="col-form-label">
                                            Transaction ID </label>
                                        <input type="text" name="transaction_id" class="form-control"
                                            value="<?php echo $data['transaction_id'] ?>" readonly required />
                                    </div>

                                    <div class="col-6">
                                        <label class="col-form-label"> Borrower ID </label>
                                        <input type="text" class="form-control"
                                            value="<?php echo $data['borrower_id'] ?>" readonly disabled>
                                    </div>
                                </div>
                                <div class="row mx-1">
                                    <div class="col-12">
                                        <label class="col-form-label"> Borrower Email </label>
                                        <input type="text" class="form-control"
                                            value="<?php echo $data['borrower_email'] ?>" readonly disabled>
                                    </div>
                                </div>



                                <div class="col-12">
                                    <label class="col-form-label"> Borrowed Book Info </label>
                                    <div class="form-group col-12 mb-1 border pb-3">
                                        <div class="row">

                                            <div class="col-6">
                                                <label class="col-form-label">
                                                    Book ID</label>
                                                <input type="text" class="form-control"
                                                    value="<?php echo $data['book_id'] ?>" readonly disabled />
                                            </div>

                                            <div class="col-6">
                                                <label class="col-form-label">
                                                    Catalog Number</label>
                                                <input type="text" class="form-control"
                                                    value="<?php echo $data['catalog_number'] ?>" readonly disabled />
                                            </div>

                                            <div class="col-6">
                                                <label class="col-form-label">
                                                    Book Title</label>
                                                <input type="text" class="form-control"
                                                    value="<?php echo $data['book_title'] ?>" readonly disabled />
                                            </div>

                                            <div class="col-12">
                                                <label class="col-form-label">
                                                    Author</label>
                                                <input type="text" class="form-control"
                                                    value="<?php echo $data['author'] ?>" readonly disabled />
                                            </div>



                                            <div class="col-6">
                                                <label class="col-form-label">
                                                    Publisher</label>
                                                <input type="text" class="form-control"
                                                    value="<?php echo $data['publisher'] ?>" readonly disabled />
                                            </div>

                                            <div class="col-6">
                                                <label class="col-form-label">
                                                    Year</label>
                                                <input type="text" class="form-control"
                                                    value="<?php echo $data['book_id'] ?>" readonly disabled />
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row mx-1">
                                    <div class="col-6">
                                        <label class="col-form-label"> Borrow Date</label>
                                        <input type="text" class="form-control"
                                            value="<?php echo $data['borrow_datetime'] ?>" readonly disabled>
                                    </div>

                                    <div class="col-6">
                                        <label class="col-form-label"> Due Date</label>
                                        <input type="text" class="form-control"
                                            value="<?php echo $data['return_datetime'] ?>" readonly disabled>
                                    </div>
                                </div>


                                <div class="mt-4 text-right">
                                    <button type="submit" class="btn btn-success" name="edit_transaction">Return
                                        Book</button>
                                    <a href="#" type="button" class="btn btn-secondary">Cancel</a>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal 1-->
<div class="modal fade" id="book1modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Scan Book 1</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- for refreshing rfid code -->
                <div id="refresh-rfid-code"></div>
                <script>
                function clearRFID1() {
                    $(document).ready(function() {
                        $.post("rfid/refresh.php",
                            function(data, status) {
                                console.log("rfid cleared");
                            });
                    });
                }

                function submitBookID1() {
                    console.log("book id submitted");
                    $(document).ready(function() {
                        var bookid = $('#bookid').val();
                        $('#book1').val(bookid);
                    });
                }
                </script>
                <div class="render"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal"
                    onclick="submitBookID1()">Submit</button>
            </div>
        </div>
    </div>
</div>


<script>
$(document).ready(function() {
    setInterval(() => {
        $('.render').load('rfid/codeForScan.php').fadeIn("fast");
    }, 500);
});
</script>
<!------------------------------->
<!---- END BODY -->
<!------------------------------->

<?php
include_once 'includes/footer.php';
?>