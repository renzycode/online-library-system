<?php

session_start();

$active = 'catalog';
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

        $sql = 'SELECT * FROM catalog_table';
        $statement = $pdo->prepare($sql);
        $statement->execute();
        $catalogs = $statement->fetchAll();
    


?>

<!---------------->
<!-- START BODY -->
<!---------------->

<div class="m-4">
    <h2 class="mb-4 text-dark">
        <span class="page-title">Catalog Table</span>
        <hr>    
        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modalAdd" onclick="clearRFID()">
            Add
        </button>
        <a type="button" href="add_book_copy.php" class="btn btn-secondary">
            Add Book Copy
        </a>
        <a type="button" class="btn btn-success" href="download_reports/catalog.php">
            Download Report
        </a>
    </h2>

    <?php

    if(isset($_GET['add'])){
        if($_GET['add']=='success'){
            echo '
            <div class="alert alert-success">
                Catalog has been successfully added.
            </div>
            ';
        }
        if($_GET['add']=='error'){
            if($_GET['rfid']=='existing'){
                echo '
                <div class="alert alert-danger">
                    Error Add, RFID already used.
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

    if(isset($_GET['edit'])){
        if($_GET['edit']=='success'){
            echo '
            <div class="alert alert-success">
                Catalog has been successfully updated.
            </div>
            ';
        }
        if($_GET['edit']=='error'){
            if($_GET['rfid']=='existing'){
                echo '
                <div class="alert alert-danger">
                    Error Edit, RFID already used.
                </div>
                ';
            }else{
                echo '
                <div class="alert alert-danger">
                    Error Edit, Please try again later.
                </div>
                ';
            }
        }
    }

    if(isset($_GET['delete'])){
        if($_GET['delete']=='success'){
            echo '
            <div class="alert alert-success">
                Catalog has been successfully deleted.
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
    <!-- add modal -->
    <div class="modal fade" id="modalAdd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="api/add_catalog.php" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Catalog</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body row">
                        <input type="hidden" name="librarian_id" value="<?php echo $librarian_id ?>">

                        <div class="form-group col-12 mb-1">
                            <label class="col-form-label">RFID Code</label>
                            
                            <span class="renderrfidcode">
                                
                            </span>
                            <!-- triggers modal and refresh rfid code -->
                            <button type="button"  class="btn btn-primary mt-2" onclick="clearRFID()">Scan New</button>

                            <script>
                                function clearRFID() {
                                    $(document).ready(function() {
                                        $.post("rfid/refreshreg.php",
                                        function(data, status){
                                            console.log("rfid cleared");
                                        });
                                    });
                                }
                            </script>

                        </div>

                        <div class="form-group col-6 mb-0">
                            <label class="col-form-label">Catalog Number
                            <span class="text-danger"><em>(required)</em></span>
                            </label>
                            <input type="text" name="catalog_number" class="form-control border-dark border" required/>
                        </div>
                        <div class="form-group col-6 mb-0">
                            <label class="col-form-label">Book Title
                            <span class="text-danger"><em>(required)</em></span>
                            </label>
                            <input type="text" name="catalog_book_title" class="form-control border-dark border" required/>
                        </div>
                        <div class="form-group col-6 mb-0">
                            <label class="col-form-label">Author
                            <span class="text-danger"><em>(required)</em></span>
                            </label>
                            <input type="text" name="catalog_author" class="form-control border-dark border" required/>
                        </div>
                        <div class="form-group col-6 mb-0">
                            <label class="col-form-label">Publisher
                            <span class="text-danger"><em>(required)</em></span>
                            </label>
                            <input type="text" name="catalog_publisher" class="form-control border-dark border" required/>
                        </div>
                        <div class="form-group col-6 mb-0">
                            <label class="col-form-label">Year
                            <span class="text-danger"><em>(required)</em></span>
                            </label>
                            <input type="text" name="catalog_year" class="form-control border-dark border" required/>
                        </div>
                        <div class="form-group col-6 mb-0">
                            <label class="col-form-label">Date Received</label>
                            <input type="text" name="catalog_date_received" class="form-control border-dark border" />
                        </div>
                        <div class="form-group col-6 mb-0">
                            <label class="col-form-label">Class</label>
                            <input type="text" name="catalog_class" class="form-control border-dark border" />
                        </div>
                        <div class="form-group col-6 mb-0">
                            <label class="col-form-label">Edition</label>
                            <input type="text" name="catalog_edition" class="form-control border-dark border" />
                        </div>
                        <div class="form-group col-6 mb-0">
                            <label class="col-form-label">Volumes</label>
                            <input type="text" name="catalog_volumes" class="form-control border-dark border" />
                        </div>
                        <div class="form-group col-6 mb-0">
                            <label class="col-form-label">Pages</label>
                            <input type="text" name="catalog_pages" class="form-control border-dark border" />
                        </div>
                        <div class="form-group col-6 mb-0">
                            <label class="col-form-label">Source of Fund</label>
                            <input type="text" name="catalog_source_of_fund" class="form-control border-dark border" />
                        </div>
                        <div class="form-group col-6 mb-0">
                            <label class="col-form-label">Cost Price</label>
                            <input type="text" name="catalog_cost_price" class="form-control border-dark border" />
                        </div>
                        <div class="form-group col-6 mb-0">
                            <label class="col-form-label">Location Symbol</label>
                            <input type="text" name="catalog_location_symbol" class="form-control border-dark border" />
                        </div>
                        <div class="form-group col-6 mb-0">
                            <label class="col-form-label">Class Number</label>
                            <input type="text" name="catalog_class_number" class="form-control border-dark border" />
                        </div>
                        <div class="form-group col-6 mb-0">
                            <label class="col-form-label">Author Number</label>
                            <input type="text" name="catalog_author_number" class="form-control border-dark border" />
                        </div>
                        <div class="form-group col-6 mb-0">
                            <label class="col-form-label">Copyright Date</label>
                            <input type="text" name="catalog_copyright_date" class="form-control border-dark border" />
                        </div>
                        <div class="form-group col-6 mb-0">
                            <label class="col-form-label">Status</label>
                            <select class="form-select" aria-label="" name="catalog_status">
                                <option selected value="Available">Available</option>
                                <option value="Unavailable">Unavailable</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="add_catalog" class="btn btn-success">Submit</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- end add modal -->

    <?php
    if ( count($catalogs)<=0 ) {
        echo '
        <div class="alert alert-warning">
            No catalogs to be displayed
        </div>
        ';
    }
    else{
        echo '
        <div class="">
            <table class="table table-bordered border-secondary myDataTable table-responsive">
                <thead class="border">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Book ID</th>
                        <th scope="col">RFID Code</th>
                        <th scope="col">Catalog Number</th>
                        <th scope="col">Book Title</th>
                        <th scope="col">Author</th>
                        <th scope="col">Publisher</th>
                        <th scope="col">Year</th>
                        <th scope="col">Date Received</th>
                        <th scope="col">Class</th>
                        <th scope="col">Edition</th>
                        <th scope="col">Volumes</th>
                        <th scope="col">Pages</th>
                        <th scope="col">Source of Fund</th>
                        <th scope="col">Cost Price</th>
                        <th scope="col">Location Symbol</th>
                        <th scope="col">Class Number</th>
                        <th scope="col">Author Number</th>
                        <th scope="col">Copyright Date</th>
                        <th scope="col">Status</th>
                        <th scope="col">Edit</th>
                        <th scope="col">Delete</th>
                    </tr>
                </thead>
                <tbody class="border">
                ';
                    $number = 0;
                    foreach ($catalogs as $catalog){
                        $number++;
                        echo '
                        <tr>
                            <td class="border-tr">'.$number.'</td>
                            <td class="border-tr">'.$catalog['book_id'].'</td>
                            <td class="border-tr">'.$catalog['rfid_code'].'</td>
                            <td class="border-tr">'.$catalog['catalog_number'].'</td>
                            <td class="border-tr">'.$catalog['catalog_book_title'].'</td>
                            <td class="border-tr">'.$catalog['catalog_author'].'</td>
                            <td class="border-tr">'.$catalog['catalog_publisher'].'</td>
                            <td class="border-tr">'.$catalog['catalog_year'].'</td>
                            <td class="border-tr">'.$catalog['catalog_date_received'].'</td>
                            <td class="border-tr">'.$catalog['catalog_class'].'</td>
                            <td class="border-tr">'.$catalog['catalog_edition'].'</td>
                            <td class="border-tr">'.$catalog['catalog_volumes'].'</td>
                            <td class="border-tr">'.$catalog['catalog_pages'].'</td>
                            <td class="border-tr">'.$catalog['catalog_source_of_fund'].'</td>
                            <td class="border-tr">'.$catalog['catalog_cost_price'].'</td>
                            <td class="border-tr">'.$catalog['catalog_location_symbol'].'</td>
                            <td class="border-tr">'.$catalog['catalog_class_number'].'</td>
                            <td class="border-tr">'.$catalog['catalog_author_number'].'</td>
                            <td class="border-tr">'.$catalog['catalog_copyright_date'].'</td>
                            <td class="border-tr">';
                            if($catalog["catalog_status"]=="Available"){
                                echo '
                                    <span class="text-success">
                                        <i class="bi bi-check-circle-fill"></i>
                                    </span>
                                    '.$catalog["catalog_status"];
                            }else{
                                echo '
                                    <span class="text-danger">
                                        <i class="bi bi-x-circle-fill"></i>
                                    </span>
                                    '.$catalog["catalog_status"];
                            }
                            echo '
                            </td>
                            <td class="border-tr">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#modalEdit'.$number.'" onclick="clearRFID2()">
                                    Edit
                                </button>
                                <!-- edit modal -->
                                <div class="modal fade" id="modalEdit'.$number.'" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="api/edit_catalog.php" method="post">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Edit Catalog</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body row">
                                                    <input type="hidden" name="book_id" value="'.$catalog['book_id'].'">
                                                    ';

                                                    if($catalog['rfid_code']!=''){
                                                        echo '
                                                        <div class="form-group col-12 mb-0">
                                                            <label class="col-form-label">RFID Code
                                                                <span class="text-danger">(RFID Code cannot be changed)</span>
                                                            </label>
                                                            <input type="text"
                                                                class="form-control border-dark border col-3" value="'.$catalog['rfid_code'].'" disabled/>
                                                            <input type="hidden" name="hasRfidCodeAlready" value="true"/>
                                                        </div>
                                                        ';
                                                    }else{
                                                        echo '
                                                        <div class="form-group col-12 mb-1">
                                                            <label class="col-form-label">RFID Code</label>
                                                            
                                                            <span class="renderrfidcode">
                                                                
                                                            </span>
                                                            <!-- triggers modal and refresh rfid code -->
                                                            <button type="button"  class="btn btn-primary mt-2" onclick="clearRFID()2">Scan New</button>

                                                            <script>
                                                                function clearRFID2() {
                                                                    $(document).ready(function() {
                                                                        $.post("rfid/refreshreg.php",
                                                                        function(data, status){
                                                                            console.log("rfid cleared");
                                                                        });
                                                                    });
                                                                }
                                                            </script>

                                                        </div>
                                                        ';
                                                    }
                                                    
                                                    echo '
                                                    <div class="form-group col-6 mb-0">
                                                        <label class="col-form-label">Catalog Number
                                                        <span class="text-danger"><em>(required)</em></span>
                                                        </label>
                                                        <input type="text" name="catalog_number"
                                                            class="form-control border-dark border" value="'.$catalog['catalog_number'].'" required/>
                                                    </div>
                                                    <div class="form-group col-6 mb-0">
                                                        <label class="col-form-label">Book Title
                                                        <span class="text-danger"><em>(required)</em></span>
                                                        </label>
                                                        <input type="text" name="catalog_book_title"
                                                            class="form-control border-dark border" value="'.$catalog['catalog_book_title'].'" required/>
                                                    </div>
                                                    <div class="form-group col-6 mb-0">
                                                        <label class="col-form-label">Author
                                                        <span class="text-danger"><em>(required)</em></span>
                                                        </label>
                                                        <input type="text" name="catalog_author"
                                                            class="form-control border-dark border" value="'.$catalog['catalog_author'].'" required/>
                                                    </div>
                                                    <div class="form-group col-6 mb-0">
                                                        <label class="col-form-label">Publisher
                                                        <span class="text-danger"><em>(required)</em></span>
                                                        </label>
                                                        <input type="text" name="catalog_publisher"
                                                            class="form-control border-dark border" value="'.$catalog['catalog_publisher'].'" required/>
                                                    </div>
                                                    <div class="form-group col-6 mb-0">
                                                        <label class="col-form-label">Year
                                                        <span class="text-danger"><em>(required)</em></span>
                                                        </label>
                                                        <input type="text" name="catalog_year"
                                                            class="form-control border-dark border" value="'.$catalog['catalog_year'].'" required/>
                                                    </div>
                                                    <div class="form-group col-6 mb-0">
                                                        <label class="col-form-label">Date Received</label>
                                                        <input type="text" name="catalog_date_received"
                                                            class="form-control border-dark border" value="'.$catalog['catalog_date_received'].'"/>
                                                    </div>
                                                    <div class="form-group col-6 mb-0">
                                                        <label class="col-form-label">Class</label>
                                                        <input type="text" name="catalog_class"
                                                            class="form-control border-dark border" value="'.$catalog['catalog_class'].'"/>
                                                    </div>
                                                    <div class="form-group col-6 mb-0">
                                                        <label class="col-form-label">Edition</label>
                                                        <input type="text" name="catalog_edition"
                                                            class="form-control border-dark border" value="'.$catalog['catalog_edition'].'"/>
                                                    </div>
                                                    <div class="form-group col-6 mb-0">
                                                        <label class="col-form-label">Volumes</label>
                                                        <input type="text" name="catalog_volumes"
                                                            class="form-control border-dark border" value="'.$catalog['catalog_volumes'].'"/>
                                                    </div>
                                                    <div class="form-group col-6 mb-0">
                                                        <label class="col-form-label">Pages</label>
                                                        <input type="text" name="catalog_pages"
                                                            class="form-control border-dark border" value="'.$catalog['catalog_pages'].'"/>
                                                    </div>
                                                    <div class="form-group col-6 mb-0">
                                                        <label class="col-form-label">Source of Fund</label>
                                                        <input type="text" name="catalog_source_of_fund"
                                                            class="form-control border-dark border" value="'.$catalog['catalog_source_of_fund'].'"/>
                                                    </div>
                                                    <div class="form-group col-6 mb-0">
                                                        <label class="col-form-label">Cost Price</label>
                                                        <input type="text" name="catalog_cost_price"
                                                            class="form-control border-dark border" value="'.$catalog['catalog_cost_price'].'"/>
                                                    </div>
                                                    <div class="form-group col-6 mb-0">
                                                        <label class="col-form-label">Location Symbol</label>
                                                        <input type="text" name="catalog_location_symbol"
                                                            class="form-control border-dark border" value="'.$catalog['catalog_location_symbol'].'"/>
                                                    </div>
                                                    <div class="form-group col-6 mb-0">
                                                        <label class="col-form-label">Class Number</label>
                                                        <input type="text" name="catalog_class_number"
                                                            class="form-control border-dark border" value="'.$catalog['catalog_class_number'].'"/>
                                                    </div>
                                                    <div class="form-group col-6 mb-0">
                                                        <label class="col-form-label">Author Number</label>
                                                        <input type="text" name="catalog_author_number"
                                                            class="form-control border-dark border" value="'.$catalog['catalog_author_number'].'"/>
                                                    </div>
                                                    <div class="form-group col-6 mb-0">
                                                        <label class="col-form-label">Copyright Date</label>
                                                        <input type="text" name="catalog_copyright_date"
                                                            class="form-control border-dark border" value="'.$catalog['catalog_copyright_date'].'"/>
                                                    </div>
                                                    <div class="form-group col-6 mb-0">
                                                        <label class="col-form-label">Status</label>
                                                        ';
                                                        if($catalog['catalog_status'] == "Available"){
                                                            echo '
                                                            <select class="form-select" aria-label="" name="catalog_status">
                                                                <option selected value="Available">Available</option>
                                                                <option value="Unavailable">Unavailable</option>
                                                            </select>
                                                            ';
                                                        }else{
                                                            echo '
                                                            <select class="form-select" aria-label="" name="catalog_status">
                                                                <option selected value="Unavailable">Unavailable</option>
                                                                <option value="Available">Available</option>
                                                            </select>
                                                            ';
                                                        }
                                                    echo '
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" name="edit_catalog" class="btn btn-success">Submit</button>
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Cancel</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- end edit modal -->
                            </td>
                            <td class="border-tr">
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#modalDelete'.$number.'">
                                    Delete
                                </button>
                                <!-- delete modal -->
                                <div class="modal fade" id="modalDelete'.$number.'" tabindex="-1"
                                    aria-labelledby="" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="api/delete_catalog.php" method="post">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="">Delete Catalog</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure you want to delete this catalog?
                                                </div>
                                                <input type="hidden" name="id" value="'.$catalog['book_id'].'">
                                                <div class="modal-footer">
                                                    <button type="submit" name="delete_catalog" class="btn btn-success">Yes</button>
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
    <script>
        $(document).ready(function() {
            setInterval(() => {
                $('.renderrfidcode').load('rfid/codeForRegister.php').fadeIn("fast");
            }, 500);
        });
    </script>

    <!---------------->
    <!---- END BODY -->
    <!---------------->

<?php
include_once 'includes/footer.php';
?>