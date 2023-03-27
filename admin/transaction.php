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

                            if($_GET['error']=='book1'){
                                echo '
                                <div class="alert alert-danger">
                                    Error, Book ID 1 not found!
                                </div>
                                ';
                            }elseif($_GET['error']=='book2'){
                                echo '
                                <div class="alert alert-danger">
                                    Error, Book ID 2 not found!
                                </div>
                                ';
                            }elseif($_GET['error']=='book3'){
                                echo '
                                <div class="alert alert-danger">
                                    Error, Book ID 3 not found!
                                </div>
                                ';
                            }elseif($_GET['error']=='book4'){
                                echo '
                                <div class="alert alert-danger">
                                    Error, Book ID 4 not found!
                                </div>
                                ';
                            }elseif($_GET['error']=='book5'){
                                echo '
                                <div class="alert alert-danger">
                                    Error, Book ID 5 not found!
                                </div>
                                ';
                            }elseif($_GET['error']=='borrower'){
                                echo '
                                <div class="alert alert-danger">
                                    Error, Borrower ID not found!
                                </div>
                                ';
                            }
                            
                            elseif($_GET['error']=='book1unavailable'){
                                echo '
                                <div class="alert alert-danger">
                                    Error, one of the book you entered is unavailable!
                                </div>
                                ';
                            }
                            elseif($_GET['error']=='book2unavailable'){
                                echo '
                                <div class="alert alert-danger">
                                Error Add, one of the book you entered is unavailable!
                                </div>
                                ';
                            }
                            elseif($_GET['error']=='book3unavailable'){
                                echo '
                                <div class="alert alert-danger">
                                Error, one of the book you entered is unavailable!
                                </div>
                                ';
                            }
                            elseif($_GET['error']=='book4unavailable'){
                                echo '
                                <div class="alert alert-danger">
                                Error, one of the book you entered is unavailable!
                                </div>
                                ';
                            }
                            elseif($_GET['error']=='book5unavailable'){
                                echo '
                                <div class="alert alert-danger">
                                Error, one of the book you entered is unavailable!
                                </div>
                                ';
                            }
                            elseif($_GET['error']=='duplicatebook'){
                                echo '
                                <div class="alert alert-danger">
                                Error, duplicate Book ID!
                                </div>
                                ';
                            }
                            
                            else{
                                echo '
                                <div class="alert alert-danger">
                                    Error, Please try again later.
                                </div>
                                ';
                            }
                            
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
                                        Borrower ID <span class="text-danger">(required)</span></label>
                                    <input type="text" name="borrower_id" class="form-control" required />
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-2 mb-1">
                            <label for="bookNumber" class="col-form-label">
                                Book ID 1 <span class="text-danger">(required)</span></label>
                            <input type="text" name="book_id_1" class="form-control" id="book1" required />
                            <!-- triggers modal and refresh rfid code -->
                            <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal"
                                data-bs-target="#book1modal" onclick="clearRFID1()">Scan RFID</button>

                        </div>
                        <div class="form-group col-2 mb-1">
                            <label for="bookNumber" class="col-form-label">Book ID 2</label>
                            <input type="text" name="book_id_2" class="form-control" id="book2"/>
                            <!-- triggers modal and refresh rfid code -->
                            <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal"
                                    data-bs-target="#book2modal" onclick="clearRFID2()">Scan RFID</button>

                        </div>
                        <div class="form-group col-2 mb-1">
                            <label for="bookNumber" class="col-form-label">Book ID 3</label>
                            <input type="text" name="book_id_3" class="form-control" id="book3"/>
                            <!-- triggers modal and refresh rfid code -->
                            <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal"
                                    data-bs-target="#book3modal" onclick="clearRFID3()">Scan RFID</button>
                        </div>
                        <div class="form-group col-2 mb-1">
                            <label for="bookNumber" class="col-form-label">Book ID 4</label>
                            <input type="text" name="book_id_4" class="form-control" id="book4"/>
                            <!-- triggers modal and refresh rfid code -->
                            <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal"
                                    data-bs-target="#book4modal" onclick="clearRFID4()">Scan RFID</button>
                        </div>
                        <div class="form-group col-2 mb-1">
                            <label for="bookNumber" class="col-form-label">Book ID 5</label>
                            <input type="text" name="book_id_5" class="form-control" id="book5"/>
                            <!-- triggers modal and refresh rfid code -->
                            <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal"
                                    data-bs-target="#book5modal" onclick="clearRFID5()">Scan RFID</button>
                        </div>
                        <div class="form-group col-12 mb-1">
                            <label for="author" class="col-form-label">Borrow Date & Time <span
                                    class="text-danger">(required)</span></label>
                            <div class="row">
                                <div class="col-2">
                                    <input type="date" name="borrow_date" class="form-control" required />
                                </div>
                                <div class="col-2">
                                    <input type="time" name="borrow_time" class="form-control" required />
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-12 mb-1">
                            <label for="author" class="col-form-label">Return Date & Time <span
                                    class="text-danger">(required)</span></label>
                            <div class="row">
                                <div class="col-2">
                                    <input type="date" name="return_date" class="form-control" required />
                                </div>
                                <div class="col-2">
                                    <input type="time" name="return_time" class="form-control" required />
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
                        <input type="hidden" name="librarian_id" class="form-control"
                            value="<?php echo $librarian_id ?>" />
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
                                    function(data, status){
                                        console.log("rfid cleared");
                                    });
                                });
                            }
                            function submitBookID1() {
                                console.log("boom id submitted");
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
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" onclick="submitBookID1()">Submit</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal 2-->
        <div class="modal fade" id="book2modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Scan Book 2</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- for refreshing rfid code -->
                        <div id="refresh-rfid-code"></div>
                        <script>
                            function clearRFID2() {
                                $(document).ready(function() {
                                    $.post("rfid/refresh.php",
                                    function(data, status){
                                        console.log("rfid cleared");
                                    });
                                });
                            }
                            function submitBookID2() {
                                console.log("boom id submitted");
                                $(document).ready(function() {
                                    var bookid = $('#bookid').val();
                                    $('#book2').val(bookid);
                                });
                            }
                        </script>
                        <div class="render"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" onclick="submitBookID2()">Submit</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal 3-->
        <div class="modal fade" id="book3modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Scan Book 3</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- for refreshing rfid code -->
                        <div id="refresh-rfid-code"></div>
                        <script>
                            function clearRFID3() {
                                $(document).ready(function() {
                                    $.post("rfid/refresh.php",
                                    function(data, status){
                                        console.log("rfid cleared");
                                    });
                                });
                            }
                            function submitBookID3() {
                                console.log("boom id submitted");
                                $(document).ready(function() {
                                    var bookid = $('#bookid').val();
                                    $('#book3').val(bookid);
                                });
                            }
                        </script>
                        <div class="render"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" onclick="submitBookID3()">Submit</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal 4-->
        <div class="modal fade" id="book4modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Scan Book 4</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- for refreshing rfid code -->
                        <div id="refresh-rfid-code"></div>
                        <script>
                            function clearRFID4() {
                                $(document).ready(function() {
                                    $.post("rfid/refresh.php",
                                    function(data, status){
                                        console.log("rfid cleared");
                                    });
                                });
                            }
                            function submitBookID4() {
                                console.log("boom id submitted");
                                $(document).ready(function() {
                                    var bookid = $('#bookid').val();
                                    $('#book4').val(bookid);
                                });
                            }
                        </script>
                        <div class="render"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" onclick="submitBookID4()">Submit</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal 5-->
        <div class="modal fade" id="book5modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Scan Book 5</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- for refreshing rfid code -->
                        <div id="refresh-rfid-code"></div>
                        <script>
                            function clearRFID5() {
                                $(document).ready(function() {
                                    $.post("rfid/refresh.php",
                                    function(data, status){
                                        console.log("rfid cleared");
                                    });
                                });
                            }
                            function submitBookID5() {
                                console.log("boom id submitted");
                                $(document).ready(function() {
                                    var bookid = $('#bookid').val();
                                    $('#book5').val(bookid);
                                });
                            }
                        </script>
                        <div class="render"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" onclick="submitBookID5()">Submit</button>
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

        <div class="tables col-12">
            <div class="row">

                <div class="borrower-table col-6">
                    <div
                        class="table-responsive p-3 border-left-primary border-top border-right border-bottom p-3 shadow rounded">
                        <h5 class="modal-title" id="exampleModalLabel">List of Borrowers </h5>
                        <hr>
                        <table class="table table-bordered myDataTable">
                            <thead>
                                <tr>
                                    <th scope="col">Borrower ID</th>
                                    <th scope="col">Borrower Email</th>
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
                        <h5 class="modal-title" id="exampleModalLabel">List of Books </h5>
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
                                            <td>'.$catalog['book_id'].'</td>
                                            <td>'.$catalog['catalog_number'].'</td>
                                            <td>'.$catalog['catalog_book_title'].'</td>
                                            <td>
                                            ';
                                            if($catalog['catalog_status']=='Available'){
                                                echo '
                                                    <button type="button" class="btn btn-primary" onclick="copyCatalogId('.$catalog['book_id'].')">
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