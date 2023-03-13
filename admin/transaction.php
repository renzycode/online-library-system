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
    }
}else{
    redirectURL('login.php');
}

        $sql = 'SELECT * FROM catalog_table ORDER BY catalog_book_title ASC';
        $statement = $pdo->prepare($sql);
        $statement->execute();
        $catalogs = $statement->fetchAll();
    


?>

<!---------------->
<!-- START BODY -->
<!---------------->

<div class="m-4">
    <h2 class="mb-4 text-dark">
        <span class="page-title">Transactions</span>
        <hr>
        <!--button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#add">
            Add
        </button-->
    </h2>

    <div class="row">
        <div class="form col-12 mb-4">
            <div class="border-left-primary border-top border-right border-bottom p-3 shadow rounded">
                <form action="{{ route('add.book') }}" method="post">
                    <h5 class="modal-title" id="exampleModalLabel">Add Transaction</h5>
                    <hr>
                    <div class="row">
                        <div class="form-group col-2">
                            <label for="bookNumber" class="col-form-label">Book ID 1</label>
                            <input type="text" name="book_number" class="form-control" />
                        </div>
                        <div class="form-group col-2">
                            <label for="bookNumber" class="col-form-label">Book ID 2</label>
                            <input type="text" name="book_number" class="form-control" />
                        </div>
                        <div class="form-group col-2">
                            <label for="bookNumber" class="col-form-label">Book ID 3</label>
                            <input type="text" name="book_number" class="form-control" />
                        </div>
                        <div class="form-group col-2">
                            <label for="bookNumber" class="col-form-label">Book ID 4</label>
                            <input type="text" name="book_number" class="form-control" />
                        </div>
                        <div class="form-group col-2">
                            <label for="bookNumber" class="col-form-label">Book ID 5</label>
                            <input type="text" name="book_number" class="form-control" />
                        </div>
                        <div class="form-group col-4">
                            <label for="author" class="col-form-label">Borrow Date & Time</label>
                            <div class="row">
                                <div class="col-6">
                                    <input type="date" name="book_author" class="form-control" />
                                </div>
                                <div class="col-6">
                                    <input type="time" name="book_author" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-4">
                            <label for="author" class="col-form-label">Return Date & Time</label>
                            <div class="row">
                                <div class="col-6">
                                    <input type="date" name="book_author" class="form-control" />
                                </div>
                                <div class="col-6">
                                    <input type="time" name="book_author" class="form-control" />
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
                        <div class="form-group col-12">
                            <div class="mt-3">
                                <button type="submit" class="btn btn-success">Submit</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="tables col-12">
            <div class="row">
                <div class="book-table col-6 ">
                    <div class="table-responsive p-3 border-left-primary border-top border-right border-bottom p-3 shadow rounded">
                        <h5 class="modal-title" id="exampleModalLabel">List of Books</h5>
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
                                <tr>
                                    <td>1</td>
                                    <td>7163</td>
                                    <td>Hehe</td>
                                    <td><button type="button" class="btn btn-primary">Copy ID</button></td>
                                </tr>
                                <tr>
                                    <td>12</td>
                                    <td>716ewe3</td>
                                    <td>hello</td>
                                    <td><button type="button" class="btn btn-primary">Copy ID</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="borrower-table col-6">
                    <div class="table-responsive p-3 border-left-primary border-top border-right border-bottom p-3 shadow rounded">
                        <h5 class="modal-title" id="exampleModalLabel">List of Borrowers</h5>
                        <hr>
                        <table class="table table-bordered myDataTable">
                            <thead>
                                <tr>
                                    <th scope="col">Borrower ID</th>
                                    <th scope="col">Full Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>124</td>
                                    <td>Rwenzy</td>
                                    <td>asfffa</td>
                                    <td><button type="button" class="btn btn-primary">Copy ID</button></td>
                                </tr>
                                <tr>
                                    <td>12124</td>
                                    <td>Angez</td>
                                    <td>444224</td>
                                    <td><button type="button" class="btn btn-primary">Copy ID</button></td>
                                </tr>
                            </tbody>
                        </table>
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