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
    <h2 class="mb-4 text-dark">
        <span class="page-title">Catalog Table</span>
        <hr>
        <a type="button" class="btn btn-secondary" href="catalog.php">
            Go Back
        </a>
    </h2>

    <div class="col-12">
        <div class="row">
            <div class=" col-lg-12 col-12 col-md-12">
                <div class=" p-3 border-left-primary border-top border-right border-bottom shadow rounded">
                    <h5 id="exampleModalLabel">Add Book Copy</h5>
                    <hr>
                    <?php

                        if(isset($_GET['clone'])){
                            if($_GET['clone']=='error'){
                                if($_GET['error']=='allempty'){
                                    echo '
                                    <div class="alert alert-danger">
                                        Error, No catalog info inputed.
                                    </div>
                                    ';
                                }elseif($_GET['error']=='catalognumberexisting'){
                                    echo '
                                    <div class="alert alert-danger">
                                        Error, Catalog number already exist.
                                    </div>
                                    ';
                                }elseif($_GET['error']=='rfidexisting'){
                                    echo '
                                    <div class="alert alert-danger">
                                        Error, RFID code already exist.
                                    </div>
                                    ';
                                }else{
                                    echo '
                                    <div class="alert alert-danger">
                                        Error, Please try again later.
                                    </div>
                                    ';
                                }
                            }elseif($_GET['clone']=='success'){
                                echo '
                                    <div class="alert alert-success">
                                        Book has been successfully added.
                                    </div>
                                    ';
                            }
                        }
                    ?>

                    <div class="form-group col-12 mb-1">
                        <div class="row">

                            

                            <form action="api/clone_catalog.php" method="post">
                                <?php
                                $data = array(
                                    'book_id'=>'----------',
                                    'catalog_book_title'=>'----------',
                                    'catalog_author'=>'----------',
                                    'catalog_publisher'=>'----------',
                                    'catalog_year'=>'----------',
                                    'catalog_date_received'=>'----------',
                                    'catalog_class'=>'----------',
                                    'catalog_edition'=>'----------',
                                    'catalog_volumes'=>'----------',
                                    'catalog_pages'=>'----------',
                                    'catalog_source_of_fund'=>'----------',
                                    'catalog_cost_price'=>'----------',
                                    'catalog_location_symbol'=>'----------',
                                    'catalog_class_number'=>'----------',
                                    'catalog_author_number'=>'----------',
                                    'catalog_copyright_date'=>'----------',

                                );
                                if(isset($_GET['book_id'])){
                                    $sql = 'SELECT * FROM catalog_table
                                    WHERE book_id = ?';
                                    $statement = $pdo->prepare($sql);
                                    $statement->execute(array($_GET['book_id']));
                                    $catalog = $statement->fetch();

                                    $sql = 'SELECT * FROM author_book_bridge_table WHERE book_id = ? ';
                                    $statement = $pdo->prepare($sql);
                                    $statement->execute(array($_GET['book_id']));
                                    $books_bridged = $statement->fetchAll();

                                    $author_ids = '';
                                    foreach($books_bridged as $book_bridged){
                                        if(empty($author_ids)){
                                            $author_ids = $author_ids.$book_bridged['author_id'];
                                        }else{
                                            $author_ids = $author_ids.','.$book_bridged['author_id'];
                                        }
                                    }

                                    $author_ids_array = preg_split("/\,/", $author_ids);

                                    $author_names = '';
                                    foreach($author_ids_array as $author_id_array){
                                        $sql = 'SELECT * FROM author_table WHERE author_id = ? ';
                                        $statement = $pdo->prepare($sql);
                                        $statement->execute(array($author_id_array));
                                        $author = $statement->fetch();

                                        if(empty($author_names)){
                                            $author_names = $author_names.$author['author_fullname'];
                                        }else{
                                            $author_names = $author_names.','.$author['author_fullname'];
                                        }
                                    }

                                    if(!empty($catalog)){
                                        if($catalog['book_id']==$_GET['book_id']){
                                            $data = array();
                                            $data = array(
                                                'book_id'=>$catalog['book_id'],
                                                'catalog_book_title'=>$catalog['catalog_book_title'],
                                                'catalog_author'=>$author_names,
                                                'catalog_publisher'=>$catalog['catalog_publisher'],
                                                'catalog_year'=>$catalog['catalog_year'],
                                                'catalog_date_received'=>$catalog['catalog_date_received'],
                                                'catalog_class'=>$catalog['catalog_class'],
                                                'catalog_edition'=>$catalog['catalog_edition'],
                                                'catalog_volumes'=>$catalog['catalog_volumes'],
                                                'catalog_pages'=>$catalog['catalog_pages'],
                                                'catalog_source_of_fund'=>$catalog['catalog_source_of_fund'],
                                                'catalog_cost_price'=>$catalog['catalog_cost_price'],
                                                'catalog_location_symbol'=>$catalog['catalog_location_symbol'],
                                                'catalog_class_number'=>$catalog['catalog_class_number'],
                                                'catalog_author_number'=>$catalog['catalog_author_number'],
                                                'catalog_copyright_date'=>$catalog['catalog_copyright_date'],
                                            );
                                        }
                                    }else{
                                        echo '
                                        <div class="row mx-1">
                                            <div class="col-12 mb-0 mt-3">
                                                <div class="alert alert-danger py-2 mb-2">No book found.</div>
                                            </div>
                                        </div>
                                        ';
                                    }
                                }
                                ?>


                                


                                <div class="col-12">
                                    <label class="col-form-label"> Catalog Info </label>
                                    <div class="form-group col-12 mb-1 border pb-3">
                                        <div class="row">
                                            <input type="hidden" name="book_id" value="<?php echo $data['book_id'] ?>">
                                            <div class="col-12">
                                                <label class="col-form-label">RFID Code <span class="text-danger"><em>(must be
                                                            new)</em></span></label>
                                                <span class="renderrfidcode">

                                                </span>
                                                <!-- triggers modal and refresh rfid code -->
                                                <button type="button" class="btn btn-primary mt-2" onclick="clearRFID()">Clear / Scan New</button>

                                                <script>
                                                function clearRFID() {
                                                    $(document).ready(function() {
                                                        $.post("rfid/refreshreg.php",
                                                            function(data, status) {
                                                                console.log("rfid cleared");
                                                            });
                                                    });
                                                }
                                                </script>
                                                <script>
                                                    $(document).ready(function() {
                                                        setInterval(() => {
                                                            $('.renderrfidcode').load('rfid/codeForRegister.php').fadeIn("fast");
                                                        }, 500);
                                                    });
                                                </script>
                                            </div>
                                            <div class="col-6">
                                                <label class="col-form-label"> Catalog Number <span
                                                        class="text-danger"><em>(must be new) (required)</em></span></label>
                                                <input type="text" class="form-control" name="catalog_number" required>
                                            </div>
                                            <div class="col-6">
                                                <label class="col-form-label">
                                                    Book Title</label>
                                                <input type="text" class="form-control"
                                                    value="<?php echo $data['catalog_book_title'] ?>" readonly
                                                    disabled />
                                            </div>
                                            <div class="col-12">
                                                <label class="col-form-label">
                                                    Author</label>
                                                <input type="text" class="form-control"
                                                    value="<?php echo $data['catalog_author'] ?>" readonly disabled />
                                            </div>
                                            <div class="col-6">
                                                <label class="col-form-label">
                                                    Publisher</label>
                                                <input type="text" class="form-control"
                                                    value="<?php echo $data['catalog_publisher'] ?>" readonly
                                                    disabled />
                                            </div>
                                            <div class="col-6">
                                                <label class="col-form-label">
                                                    Year</label>
                                                <input type="text" class="form-control"
                                                    value="<?php echo $data['catalog_year'] ?>" readonly disabled />
                                            </div>
                                            <div class="col-6">
                                                <label class="col-form-label">
                                                    Date Received</label>
                                                <input type="text" class="form-control"
                                                    value="<?php echo $data['catalog_date_received'] ?>" readonly
                                                    disabled />
                                            </div>
                                            <!--div class="col-6">
                                                <label class="col-form-label">
                                                    Class</label>
                                                <input type="text" class="form-control"
                                                    value="<?php //echo $data['catalog_class'] ?>" readonly disabled />
                                            </div>
                                            <div class="col-6">
                                                <label class="col-form-label">
                                                    Edition</label>
                                                <input type="text" class="form-control"
                                                    value="<?php //echo $data['catalog_edition'] ?>" readonly disabled />
                                            </div>
                                            <div class="col-6">
                                                <label class="col-form-label">
                                                    Volumes</label>
                                                <input type="text" class="form-control"
                                                    value="<?php //echo $data['catalog_volumes'] ?>" readonly disabled />
                                            </div>
                                            <div class="col-6">
                                                <label class="col-form-label">
                                                    Pages</label>
                                                <input type="text" class="form-control"
                                                    value="<?php //echo $data['catalog_pages'] ?>" readonly disabled />
                                            </div>
                                            <div class="col-6">
                                                <label class="col-form-label">
                                                    Source of Fund</label>
                                                <input type="text" class="form-control"
                                                    value="<?php //echo $data['catalog_source_of_fund'] ?>" readonly
                                                    disabled />
                                            </div>
                                            <div class="col-6">
                                                <label class="col-form-label">
                                                    Cost Price</label>
                                                <input type="text" class="form-control"
                                                    value="<?php //echo $data['catalog_cost_price'] ?>" readonly
                                                    disabled />
                                            </div>
                                            <div class="col-6">
                                                <label class="col-form-label">
                                                    Location Symbol</label>
                                                <input type="text" class="form-control"
                                                    value="<?php //echo $data['catalog_location_symbol'] ?>" readonly
                                                    disabled />
                                            </div>
                                            <div class="col-6">
                                                <label class="col-form-label">
                                                    Class Number</label>
                                                <input type="text" class="form-control"
                                                    value="<?php //echo $data['catalog_class_number'] ?>" readonly
                                                    disabled />
                                            </div>
                                            <div class="col-6">
                                                <label class="col-form-label">
                                                    Author Number</label>
                                                <input type="text" class="form-control"
                                                    value="<?php //echo $data['catalog_author_number'] ?>" readonly
                                                    disabled />
                                            </div>
                                            <div class="col-6">
                                                <label class="col-form-label">
                                                    Copyright Date</label>
                                                <input type="text" class="form-control"
                                                    value="<?php //echo $data['catalog_copyright_date'] ?>" readonly
                                                    disabled />
                                            </div-->
                                            <!--div class="col-6">
                                                <label class="col-form-label">Status</label>
                                                <select class="form-select" aria-label="" name="catalog_status">
                                                    <option selected value="Available">Available</option>
                                                    <option value="Unavailable">Unavailable</option>
                                                </select>
                                            </div-->
                                            <input type="hidden" name="catalog_status" value="Available"/>
                                        </div>
                                    </div>
                                </div>


                                <div class="mt-4 text-right">
                                    <button type="submit" class="btn btn-success"
                                        name="clone_catalog">Submit</button>
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