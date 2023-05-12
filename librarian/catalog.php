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

        $sql = 'SELECT * FROM catalog_table ORDER BY catalog_book_title';
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
        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modalAdd"
            onclick="clearRFID()">
            Add
        </button>
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
            if($_GET['error']=='rfidexisting'){
                echo '
                <div class="alert alert-danger">
                    RFID already used.
                </div>
                ';
            }elseif($_GET['error']=='catalognumberexisting'){
                echo '
                <div class="alert alert-danger">
                    Catalog number already used.
                </div>
                ';
            }elseif($_GET['error']=='duplicateauthorid'){
                echo '
                <div class="alert alert-danger">
                    Error, Duplicate Author Names.
                </div>
                ';
            }elseif($_GET['error']=='authoridnotfound'){
                echo '
                <div class="alert alert-danger">
                    Author name not found.
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
            if(isset($_GET['rfid'])){
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
            }elseif(isset($_GET['error'])){
                if($_GET['error']=='rfidexisting'){
                    echo '
                    <div class="alert alert-danger">
                        RFID already used.
                    </div>
                    ';
                }elseif($_GET['error']=='catalognumberexisting'){
                    echo '
                    <div class="alert alert-danger">
                        Catalog number already used.
                    </div>
                    ';
                }elseif($_GET['error']=='duplicateauthorid'){
                    echo '
                    <div class="alert alert-danger">
                        Error, Duplicate Author Names.
                    </div>
                    ';
                }elseif($_GET['error']=='authoridnotfound'){
                    echo '
                    <div class="alert alert-danger">
                        Author name not found.
                    </div>
                    ';
                }else{
                    echo '
                    <div class="alert alert-danger">
                        Error Add, Please try again later.
                    </div>
                    ';
                }
            }else{
                echo '
                    <div class="alert alert-danger">
                        Error Add, Please try again later.
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
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form action="api/add_catalog.php" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Catalog</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body row">
                        <input type="hidden" name="librarian_id" value="<?php echo $librarian_id ?>">

                        <div class="form-group col-12 mb-1">
                            <label class="col-form-label">RFID Code <span class="text-danger"><em>(required)</em></span></label>

                            <span class="renderrfidcode">

                            </span>
                            <!-- triggers modal and refresh rfid code -->
                            <button type="button" class="btn btn-primary mt-2" onclick="clearRFID()">Clear / Scan
                                New</button>

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

                        </div>

                        <div class="form-group col-3 mb-0">
                            <label class="col-form-label">Catalog Number
                                <span class="text-danger"><em>(required)</em></span>
                            </label>
                            <input type="text" name="catalog_number" class="form-control border-dark border" required />
                        </div>
                        <div class="form-group col-3 mb-0">
                            <label class="col-form-label">Book Title
                                <span class="text-danger"><em>(required)</em></span>
                            </label>
                            <input type="text" name="catalog_book_title" class="form-control border-dark border"
                                required />
                        </div>

                        <div class="form-group col-12 m-0">
                            <hr />
                        </div>

                        <?php
                            $sql = 'SELECT * FROM author_table ORDER BY author_fullname';
                            $statement = $pdo->prepare($sql);
                            $statement->execute();
                            $authors = $statement->fetchAll();
                        ?>

                        <div class="form-group col-12 mb-0">
                            <label class="col-form-label">Number of Authors
                                <span class="text-danger"><em>(required)</em></span>
                            </label>
                            <select class="form-select col-2 border-dark border" aria-label="select example" id="no_of_authors">
                                <?php
                                    for($num = 1; $num <= 20; $num++){
                                        echo '
                                            <option value="'.$num.'">'.$num.'</option>
                                        ';
                                    }
                                    
                                ?>
                            </select>
                        </div>

                        <div class="row" id="rendered_authors"></div>
                        <?php
                        echo '
                        <script>
                        $(document).ready(function() {
                            ';
                                $options = '';
                                foreach($authors as $author){
                                    $author_full_name = $author['author_fullname'];
                                    $options = $options.'<option value="'.$author_full_name.'">'.$author_full_name.'</option>';
                                    
                                }

                                echo '
                                $("#no_of_authors")
                                    .on("change", function() {
                                        var str = "";
                                        $("#no_of_authors option:selected").each(function() {
                                            str += $(this).text() + " ";
                                        });

                                        if(str==1){
                                            $("#rendered_authors").html(`
                                            ';
                                                for($numi = 1; $numi <= 1; $numi++){
                                                    echo '
                                                    <div class="form-group col-2 mb-0">
                                                        <label class="col-form-label">Author '.$numi.'
                                                            <span class="text-danger"><em>(required)</em></span>
                                                        </label>
                                                        <input type="text" class="form-control border-dark border" list="authors-list" id="input-datalist" name="catalog_author'.$numi.'" required>
                                                        <datalist id="authors-list">
                                                            '.$options.'
                                                        </datalist>
                                                    </div>';
                                                }
                                            echo '
                                            `);
                                        }else if(str==2){
                                            $("#rendered_authors").html(`
                                            ';
                                                for($numi = 1; $numi <= 2; $numi++){
                                                    echo '
                                                    <div class="form-group col-2 mb-0">
                                                        <label class="col-form-label">Author '.$numi.'
                                                            <span class="text-danger"><em>(required)</em></span>
                                                        </label>
                                                        <input type="text" class="form-control border-dark border" list="authors-list" id="input-datalist" name="catalog_author'.$numi.'" required>
                                                        <datalist id="authors-list">
                                                            '.$options.'
                                                        </datalist>
                                                    </div>';
                                                }
                                            echo '
                                            `);
                                        }else if(str==3){
                                            $("#rendered_authors").html(`
                                            ';
                                                for($numi = 1; $numi <= 3; $numi++){
                                                    echo '
                                                    <div class="form-group col-2 mb-0">
                                                        <label class="col-form-label">Author '.$numi.'
                                                            <span class="text-danger"><em>(required)</em></span>
                                                        </label>
                                                        <input type="text" class="form-control border-dark border" list="authors-list" id="input-datalist" name="catalog_author'.$numi.'" required>
                                                        <datalist id="authors-list">
                                                            '.$options.'
                                                        </datalist>
                                                    </div>';
                                                }
                                            echo '
                                            `);
                                        }else if(str==4){
                                            $("#rendered_authors").html(`
                                            ';
                                                for($numi = 1; $numi <= 4; $numi++){
                                                    echo '
                                                    <div class="form-group col-2 mb-0">
                                                        <label class="col-form-label">Author '.$numi.'
                                                            <span class="text-danger"><em>(required)</em></span>
                                                        </label>
                                                        <input type="text" class="form-control border-dark border" list="authors-list" id="input-datalist" name="catalog_author'.$numi.'" required>
                                                        <datalist id="authors-list">
                                                            '.$options.'
                                                        </datalist>
                                                    </div>';
                                                }
                                            echo '
                                            `);
                                        }else if(str==5){
                                            $("#rendered_authors").html(`
                                            ';
                                                for($numi = 1; $numi <= 5; $numi++){
                                                    echo '
                                                    <div class="form-group col-2 mb-0">
                                                        <label class="col-form-label">Author '.$numi.'
                                                            <span class="text-danger"><em>(required)</em></span>
                                                        </label>
                                                        <input type="text" class="form-control border-dark border" list="authors-list" id="input-datalist" name="catalog_author'.$numi.'" required>
                                                        <datalist id="authors-list">
                                                            '.$options.'
                                                        </datalist>
                                                    </div>';
                                                }
                                            echo '
                                            `);
                                        }else if(str==6){
                                            $("#rendered_authors").html(`
                                            ';
                                                for($numi = 1; $numi <= 6; $numi++){
                                                    echo '
                                                    <div class="form-group col-2 mb-0">
                                                        <label class="col-form-label">Author '.$numi.'
                                                            <span class="text-danger"><em>(required)</em></span>
                                                        </label>
                                                        <input type="text" class="form-control border-dark border" list="authors-list" id="input-datalist" name="catalog_author'.$numi.'" required>
                                                        <datalist id="authors-list">
                                                            '.$options.'
                                                        </datalist>
                                                    </div>';
                                                }
                                            echo '
                                            `);
                                        }else if(str==7){
                                            $("#rendered_authors").html(`
                                            ';
                                                for($numi = 1; $numi <= 7; $numi++){
                                                    echo '
                                                    <div class="form-group col-2 mb-0">
                                                        <label class="col-form-label">Author '.$numi.'
                                                            <span class="text-danger"><em>(required)</em></span>
                                                        </label>
                                                        <input type="text" class="form-control border-dark border" list="authors-list" id="input-datalist" name="catalog_author'.$numi.'" required>
                                                        <datalist id="authors-list">
                                                            '.$options.'
                                                        </datalist>
                                                    </div>';
                                                }
                                            echo '
                                            `);
                                        }else if(str==8){
                                            $("#rendered_authors").html(`
                                            ';
                                                for($numi = 1; $numi <= 8; $numi++){
                                                    echo '
                                                    <div class="form-group col-2 mb-0">
                                                        <label class="col-form-label">Author '.$numi.'
                                                            <span class="text-danger"><em>(required)</em></span>
                                                        </label>
                                                        <input type="text" class="form-control border-dark border" list="authors-list" id="input-datalist" name="catalog_author'.$numi.'" required>
                                                        <datalist id="authors-list">
                                                            '.$options.'
                                                        </datalist>
                                                    </div>';
                                                }
                                            echo '
                                            `);
                                        }else if(str==9){
                                            $("#rendered_authors").html(`
                                            ';
                                                for($numi = 1; $numi <= 9; $numi++){
                                                    echo '
                                                    <div class="form-group col-2 mb-0">
                                                        <label class="col-form-label">Author '.$numi.'
                                                            <span class="text-danger"><em>(required)</em></span>
                                                        </label>
                                                        <input type="text" class="form-control border-dark border" list="authors-list" id="input-datalist" name="catalog_author'.$numi.'" required>
                                                        <datalist id="authors-list">
                                                            '.$options.'
                                                        </datalist>
                                                    </div>';
                                                }
                                            echo '
                                            `);
                                        }else if(str==10){
                                            $("#rendered_authors").html(`
                                            ';
                                                for($numi = 1; $numi <= 10; $numi++){
                                                    echo '
                                                    <div class="form-group col-2 mb-0">
                                                        <label class="col-form-label">Author '.$numi.'
                                                            <span class="text-danger"><em>(required)</em></span>
                                                        </label>
                                                        <input type="text" class="form-control border-dark border" list="authors-list" id="input-datalist" name="catalog_author'.$numi.'" required>
                                                        <datalist id="authors-list">
                                                            '.$options.'
                                                        </datalist>
                                                    </div>';
                                                }
                                            echo '
                                            `);
                                        }else if(str==11){
                                            $("#rendered_authors").html(`
                                            ';
                                                for($numi = 1; $numi <= 11; $numi++){
                                                    echo '
                                                    <div class="form-group col-2 mb-0">
                                                        <label class="col-form-label">Author '.$numi.'
                                                            <span class="text-danger"><em>(required)</em></span>
                                                        </label>
                                                        <input type="text" class="form-control border-dark border" list="authors-list" id="input-datalist" name="catalog_author'.$numi.'" required>
                                                        <datalist id="authors-list">
                                                            '.$options.'
                                                        </datalist>
                                                    </div>';
                                                }
                                            echo '
                                            `);
                                        }else if(str==12){
                                            $("#rendered_authors").html(`
                                            ';
                                                for($numi = 1; $numi <= 12; $numi++){
                                                    echo '
                                                    <div class="form-group col-2 mb-0">
                                                        <label class="col-form-label">Author '.$numi.'
                                                            <span class="text-danger"><em>(required)</em></span>
                                                        </label>
                                                        <input type="text" class="form-control border-dark border" list="authors-list" id="input-datalist" name="catalog_author'.$numi.'" required>
                                                        <datalist id="authors-list">
                                                            '.$options.'
                                                        </datalist>
                                                    </div>';
                                                }
                                            echo '
                                            `);
                                        }else if(str==13){
                                            $("#rendered_authors").html(`
                                            ';
                                                for($numi = 1; $numi <= 13; $numi++){
                                                    echo '
                                                    <div class="form-group col-2 mb-0">
                                                        <label class="col-form-label">Author '.$numi.'
                                                            <span class="text-danger"><em>(required)</em></span>
                                                        </label>
                                                        <input type="text" class="form-control border-dark border" list="authors-list" id="input-datalist" name="catalog_author'.$numi.'" required>
                                                        <datalist id="authors-list">
                                                            '.$options.'
                                                        </datalist>
                                                    </div>';
                                                }
                                            echo '
                                            `);
                                        }else if(str==14){
                                            $("#rendered_authors").html(`
                                            ';
                                                for($numi = 1; $numi <= 14; $numi++){
                                                    echo '
                                                    <div class="form-group col-2 mb-0">
                                                        <label class="col-form-label">Author '.$numi.'
                                                            <span class="text-danger"><em>(required)</em></span>
                                                        </label>
                                                        <input type="text" class="form-control border-dark border" list="authors-list" id="input-datalist" name="catalog_author'.$numi.'" required>
                                                        <datalist id="authors-list">
                                                            '.$options.'
                                                        </datalist>
                                                    </div>';
                                                }
                                            echo '
                                            `);
                                        }else if(str==15){
                                            $("#rendered_authors").html(`
                                            ';
                                                for($numi = 1; $numi <= 15; $numi++){
                                                    echo '
                                                    <div class="form-group col-2 mb-0">
                                                        <label class="col-form-label">Author '.$numi.'
                                                            <span class="text-danger"><em>(required)</em></span>
                                                        </label>
                                                        <input type="text" class="form-control border-dark border" list="authors-list" id="input-datalist" name="catalog_author'.$numi.'" required>
                                                        <datalist id="authors-list">
                                                            '.$options.'
                                                        </datalist>
                                                    </div>';
                                                }
                                            echo '
                                            `);
                                        }else if(str==16){
                                            $("#rendered_authors").html(`
                                            ';
                                                for($numi = 1; $numi <= 16; $numi++){
                                                    echo '
                                                    <div class="form-group col-2 mb-0">
                                                        <label class="col-form-label">Author '.$numi.'
                                                            <span class="text-danger"><em>(required)</em></span>
                                                        </label>
                                                        <input type="text" class="form-control border-dark border" list="authors-list" id="input-datalist" name="catalog_author'.$numi.'" required>
                                                        <datalist id="authors-list">
                                                            '.$options.'
                                                        </datalist>
                                                    </div>';
                                                }
                                            echo '
                                            `);
                                        }else if(str==17){
                                            $("#rendered_authors").html(`
                                            ';
                                                for($numi = 1; $numi <= 17; $numi++){
                                                    echo '
                                                    <div class="form-group col-2 mb-0">
                                                        <label class="col-form-label">Author '.$numi.'
                                                            <span class="text-danger"><em>(required)</em></span>
                                                        </label>
                                                        <input type="text" class="form-control border-dark border" list="authors-list" id="input-datalist" name="catalog_author'.$numi.'" required>
                                                        <datalist id="authors-list">
                                                            '.$options.'
                                                        </datalist>
                                                    </div>';
                                                }
                                            echo '
                                            `);
                                        }else if(str==18){
                                            $("#rendered_authors").html(`
                                            ';
                                                for($numi = 1; $numi <= 18; $numi++){
                                                    echo '
                                                    <div class="form-group col-2 mb-0">
                                                        <label class="col-form-label">Author '.$numi.'
                                                            <span class="text-danger"><em>(required)</em></span>
                                                        </label>
                                                        <input type="text" class="form-control border-dark border" list="authors-list" id="input-datalist" name="catalog_author'.$numi.'" required>
                                                        <datalist id="authors-list">
                                                            '.$options.'
                                                        </datalist>
                                                    </div>';
                                                }
                                            echo '
                                            `);
                                        }else if(str==19){
                                            $("#rendered_authors").html(`
                                            ';
                                                for($numi = 1; $numi <= 19; $numi++){
                                                    echo '
                                                    <div class="form-group col-2 mb-0">
                                                        <label class="col-form-label">Author '.$numi.'
                                                            <span class="text-danger"><em>(required)</em></span>
                                                        </label>
                                                        <input type="text" class="form-control border-dark border" list="authors-list" id="input-datalist" name="catalog_author'.$numi.'" required>
                                                        <datalist id="authors-list">
                                                            '.$options.'
                                                        </datalist>
                                                    </div>';
                                                }
                                            echo '
                                            `);
                                        }else if(str==20){
                                            $("#rendered_authors").html(`
                                            ';
                                                for($numi = 1; $numi <= 20; $numi++){
                                                    echo '
                                                    <div class="form-group col-2 mb-0">
                                                        <label class="col-form-label">Author '.$numi.'
                                                            <span class="text-danger"><em>(required)</em></span>
                                                        </label>
                                                        <input type="text" class="form-control border-dark border" list="authors-list" id="input-datalist" name="catalog_author'.$numi.'" required>
                                                        <datalist id="authors-list">
                                                            '.$options.'
                                                        </datalist>
                                                    </div>';
                                                }
                                            echo '
                                            `);
                                        }else{
                                            $("#rendered_authors").html(``);
                                        }
                                        
                                    })
                                    .trigger("change");
                                });
                                

                            document.addEventListener("DOMContentLoaded", e => {
                                $("#input-datalist").autocomplete()
                            }, false);

                        </script>
                            ';
                        ?>


                        <div class="form-group col-12 m-0">
                            <hr />
                        </div>

                        <div class="form-group col-3 mb-0">
                            <label class="col-form-label">Publisher
                                <span class="text-danger"><em>(required)</em></span>
                            </label>
                            <input type="text" name="catalog_publisher" class="form-control border-dark border"
                                required />
                        </div>
                        <div class="form-group col-3 mb-0">
                            <label class="col-form-label">Year
                                <span class="text-danger"><em>(required)</em></span>
                            </label>
                            <input type="text" name="catalog_year" class="form-control border-dark border" required />
                        </div>
                        <div class="form-group col-3 mb-0">
                            <label class="col-form-label">Date Received</label>
                            <input type="text" name="catalog_date_received" class="form-control border-dark border" />
                        </div>
                        <div class="form-group col-3 mb-0">
                            <label class="col-form-label">Class</label>
                            <input type="text" name="catalog_class" class="form-control border-dark border" />
                        </div>
                        <div class="form-group col-3 mb-0">
                            <label class="col-form-label">Edition</label>
                            <input type="text" name="catalog_edition" class="form-control border-dark border" />
                        </div>
                        <div class="form-group col-3 mb-0">
                            <label class="col-form-label">Volumes</label>
                            <input type="text" name="catalog_volumes" class="form-control border-dark border" />
                        </div>
                        <div class="form-group col-3 mb-0">
                            <label class="col-form-label">Pages</label>
                            <input type="text" name="catalog_pages" class="form-control border-dark border" />
                        </div>
                        <div class="form-group col-3 mb-0">
                            <label class="col-form-label">Source of Fund</label>
                            <input type="text" name="catalog_source_of_fund" class="form-control border-dark border" />
                        </div>
                        <div class="form-group col-3 mb-0">
                            <label class="col-form-label">Cost Price</label>
                            <input type="text" name="catalog_cost_price" class="form-control border-dark border" />
                        </div>
                        <div class="form-group col-3 mb-0">
                            <label class="col-form-label">Location Symbol</label>
                            <input type="text" name="catalog_location_symbol" class="form-control border-dark border" />
                        </div>
                        <div class="form-group col-3 mb-0">
                            <label class="col-form-label">Class Number</label>
                            <input type="text" name="catalog_class_number" class="form-control border-dark border" />
                        </div>
                        <div class="form-group col-3 mb-0">
                            <label class="col-form-label">Author Number</label>
                            <input type="text" name="catalog_author_number" class="form-control border-dark border" />
                        </div>
                        <div class="form-group col-3 mb-0">
                            <label class="col-form-label">Copyright Date</label>
                            <input type="text" name="catalog_copyright_date" class="form-control border-dark border" />
                        </div>
                        <input type="hidden" name="catalog_status" value="Available"/>
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
        <div class="table-responsive">
            <table class="table table-bordered border-secondary myDataTable">
                <thead class="border">
                    <tr>
                        <!--th scope="col">Book ID</th-->

                        <!--th scope="col">RFID Code</th>
                        <th scope="col">Catalog Number</th>
                        <th scope="col">Book Title</th-->

                        <th scope="col">Book Info</th>
                        <th scope="col">Status</th>
                        <th scope="col">View More Info</th>
                        <th scope="col">Edit</th>
                        <th scope="col">Clone Book</th>
                        <th scope="col">Delete</th>
                    </tr>
                </thead>
                <tbody class="border">
                ';
                    $number = 0;
                    foreach ($catalogs as $catalog){
                        $number++;
                        $sql = 'SELECT * FROM author_book_bridge_table WHERE book_id = ?';
                        $statement = $pdo->prepare($sql);
                        $statement->execute(array($catalog['book_id']));
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
                        $array_author_names = preg_split("/\,/", $author_names);
                        $author_names_exploded = explode(',', $author_names)[0];
                        echo '
                        <tr>
                            <!--td class="border-tr">'.$catalog['rfid_code'].'</td>
                            <td class="border-tr">'.$catalog['catalog_number'].'</td>
                            <td class="border-tr">'.$catalog['catalog_book_title'].'</td-->
                            ';
                            if(empty($catalog['catalog_edition'])){
                                if(count($array_author_names)==1){
                                    echo '<td class="border-tr">'.$catalog['catalog_book_title'].', '.$author_names_exploded.'</td>';
                                }else{
                                    echo '<td class="border-tr">'.$catalog['catalog_book_title'].', '.$author_names_exploded.' et al.</td>';
                                }
                            }else{
                                if(count($array_author_names)==1){
                                    echo '<td class="border-tr">'.$catalog['catalog_book_title'].', '.$catalog['catalog_edition'].', '.$author_names_exploded.'</td>';
                                }else{
                                    echo '<td class="border-tr">'.$catalog['catalog_book_title'].', '.$catalog['catalog_edition'].', '.$author_names_exploded.' et al.</td>';
                                }
                            }
                            echo'
                            <td class="border-tr">
                            ';
                            if($catalog["catalog_status"]=="Available"){
                                echo '
                                    <span class="badge badge-success">'.$catalog["catalog_status"].' </span> 
                                ';
                            }else{
                                echo '
                                    <span class="badge badge-danger">'.$catalog["catalog_status"].' </span> 
                                ';
                            }
                            echo '
                            </td>
                            <td class="border-tr">
                            
                                <button type="button" class="btn btn-info" data-bs-toggle="modal"
                                    data-bs-target="#modalViewInfo'.$number.'">
                                    View More Info
                                </button>

                                <!-- view modal -->
                                <div class="modal fade" id="modalViewInfo'.$number.'" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-xl">
                                        <div class="modal-content">
                                            <form action="api/edit_catalog.php" method="post">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">View More Catalog Info</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body row">
                                                    <div class="form-group col-3 mb-0">
                                                        <label class="col-form-label">RFID code
                                                        </label>
                                                        <input type="text" name="catalog_number"
                                                            class="form-control border-dark border" value="'.$catalog['rfid_code'].'" disabled/>
                                                    </div>
                                                    <div class="form-group col-3 mb-0">
                                                        <label class="col-form-label">Catalog Number
                                                        </label>
                                                        <input type="text" name="catalog_number"
                                                            class="form-control border-dark border" value="'.$catalog['catalog_number'].'" disabled/>
                                                    </div>
                                                    <div class="form-group col-3 mb-0">
                                                        <label class="col-form-label">Book Title
                                                        </label>
                                                        <input type="text" name="catalog_book_title"
                                                            class="form-control border-dark border" value="'.$catalog['catalog_book_title'].'" disabled/>
                                                    </div>';
                                                    

                                                        $sql = 'SELECT * FROM author_book_bridge_table WHERE book_id = ?';
                                                        $statement = $pdo->prepare($sql);
                                                        $statement->execute(array($catalog['book_id']));
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

                                                    echo '
                                                    <div class="form-group col-12 mb-0">
                                                        <label class="col-form-label">Authors
                                                        </label>
                                                        <input type="text" name="catalog_author"
                                                            class="form-control border-dark border" value="'.$author_names.'" disabled/>
                                                    </div>
                                                    <div class="form-group col-3 mb-0">
                                                        <label class="col-form-label">Publisher
                                                        </label>
                                                        <input type="text" name="catalog_publisher"
                                                            class="form-control border-dark border" value="'.$catalog['catalog_publisher'].'" disabled/>
                                                    </div>
                                                    <div class="form-group col-3 mb-0">
                                                        <label class="col-form-label">Year
                                                        </label>
                                                        <input type="text" name="catalog_year"
                                                            class="form-control border-dark border" value="'.$catalog['catalog_year'].'" disabled/>
                                                    </div>
                                                    <div class="form-group col-3 mb-0">
                                                        <label class="col-form-label">Date Received</label>
                                                        <input type="text" name="catalog_date_received"
                                                            class="form-control border-dark border" value="'.$catalog['catalog_date_received'].'" disabled/>
                                                    </div>
                                                    <div class="form-group col-3 mb-0">
                                                        <label class="col-form-label">Class</label>
                                                        <input type="text" name="catalog_class"
                                                            class="form-control border-dark border" value="'.$catalog['catalog_class'].'" disabled/>
                                                    </div>
                                                    <div class="form-group col-3 mb-0">
                                                        <label class="col-form-label">Edition</label>
                                                        <input type="text" name="catalog_edition"
                                                            class="form-control border-dark border" value="'.$catalog['catalog_edition'].'" disabled/>
                                                    </div>
                                                    <div class="form-group col-3 mb-0">
                                                        <label class="col-form-label">Volumes</label>
                                                        <input type="text" name="catalog_volumes"
                                                            class="form-control border-dark border" value="'.$catalog['catalog_volumes'].'" disabled/>
                                                    </div>
                                                    <div class="form-group col-3 mb-0">
                                                        <label class="col-form-label">Pages</label>
                                                        <input type="text" name="catalog_pages"
                                                            class="form-control border-dark border" value="'.$catalog['catalog_pages'].'" disabled/>
                                                    </div>
                                                    <div class="form-group col-3 mb-0">
                                                        <label class="col-form-label">Source of Fund</label>
                                                        <input type="text" name="catalog_source_of_fund"
                                                            class="form-control border-dark border" value="'.$catalog['catalog_source_of_fund'].'" disabled/>
                                                    </div>
                                                    <div class="form-group col-3 mb-0">
                                                        <label class="col-form-label">Cost Price</label>
                                                        <input type="text" name="catalog_cost_price"
                                                            class="form-control border-dark border" value="'.$catalog['catalog_cost_price'].'" disabled/>
                                                    </div>
                                                    <div class="form-group col-3 mb-0">
                                                        <label class="col-form-label">Location Symbol</label>
                                                        <input type="text" name="catalog_location_symbol"
                                                            class="form-control border-dark border" value="'.$catalog['catalog_location_symbol'].'" disabled/>
                                                    </div>
                                                    <div class="form-group col-3 mb-0">
                                                        <label class="col-form-label">Class Number</label>
                                                        <input type="text" name="catalog_class_number"
                                                            class="form-control border-dark border" value="'.$catalog['catalog_class_number'].'" disabled/>
                                                    </div>
                                                    <div class="form-group col-3 mb-0">
                                                        <label class="col-form-label">Author Number</label>
                                                        <input type="text" name="catalog_author_number"
                                                            class="form-control border-dark border" value="'.$catalog['catalog_author_number'].'" disabled/>
                                                    </div>
                                                    <div class="form-group col-3 mb-0">
                                                        <label class="col-form-label">Copyright Date</label>
                                                        <input type="text" name="catalog_copyright_date"
                                                            class="form-control border-dark border" value="'.$catalog['catalog_copyright_date'].'" disabled/>
                                                    </div>
                                                    <div class="form-group col-3 mb-0">
                                                        <label class="col-form-label">Status</label>
                                                        <input type="text" name="catalog_copyright_date"
                                                            class="form-control border-dark border" value="'.$catalog['catalog_status'].'" disabled/>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- end view modal -->
                            </td>

                            <td class="border-tr">

                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#modalEdit'.$number.'" onclick="clearRFID2()">
                                    Edit
                                </button>

                                <!-- edit modal -->
                                <div class="modal fade" id="modalEdit'.$number.'" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-xl">
                                        <div class="modal-content">
                                            <form action="api/edit_catalog.php" method="post">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Edit Catalog</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body row">
                                                    <input type="hidden" name="librarian_id" value="'.$librarian_id.'">
                                                    <input type="hidden" name="book_id" value="'.$catalog['book_id'].'">
                                                    
                                                    <div class="form-group col-3 mb-0">
                                                        <label class="col-form-label">RFID Code
                                                        <span class="text-danger"><em>(connot be changed)</em></span>
                                                        </label>
                                                        <input type="text"
                                                            class="form-control border-dark border" value="'.$catalog['rfid_code'].'" disabled/>
                                                    </div>

                                                    <div class="form-group col-3 mb-0">
                                                        <label class="col-form-label">Catalog Number
                                                        <span class="text-danger"><em>(required)</em></span>
                                                        </label>
                                                        <input type="text" name="catalog_number"
                                                            class="form-control border-dark border" value="'.$catalog['catalog_number'].'" required/>
                                                    </div>

                                                    <div class="form-group col-3 mb-0">
                                                        <label class="col-form-label">Book Title
                                                        <span class="text-danger"><em>(required)</em></span>
                                                        </label>
                                                        <input type="text" name="catalog_book_title"
                                                            class="form-control border-dark border" value="'.$catalog['catalog_book_title'].'" required/>
                                                    </div>

                                                    <div class="form-group col-12 m-0">
                                                        <hr/>
                                                    </div>
                                                    
                                                    ';

                                                    $sql = 'SELECT * FROM author_book_bridge_table WHERE book_id = ?';
                                                    $statement = $pdo->prepare($sql);
                                                    $statement->execute(array($catalog['book_id']));
                                                    $book_ids = $statement->fetchAll();
                                                    
                                                    $author_names = '';

                                                    foreach($book_ids as $book_id){
                                                        $sql = 'SELECT * FROM author_table WHERE author_id = ?';
                                                        $statement = $pdo->prepare($sql);
                                                        $statement->execute(array($book_id['author_id']));
                                                        $author = $statement->fetch();
                                                        if(empty($author_names)){
                                                            $author_names = $author_names.$author['author_fullname'];
                                                        }else{
                                                            $author_names = $author_names.','.$author['author_fullname'];
                                                        }
                                                    }

                                                    echo '
                                                    <div class="form-group col-12 mb-0">
                                                        <label class="col-form-label">Number of Authors
                                                            <span class="text-danger"><em>(required)</em></span>
                                                        </label>
                                                        <select class="form-select col-2 border-dark border" aria-label="select example" id="no_of_authors2'.$number.'">';
                                                                $no_authors = preg_split("/\,/", $author_names);
                                                                for($num = 1; $num <= 20; $num++){
                                                                    if(count($no_authors)==$num){
                                                                        echo '
                                                                        <option value="'.$num.'" selected>'.$num.'</option>
                                                                        ';
                                                                    }else{
                                                                        echo '
                                                                        <option value="'.$num.'">'.$num.'</option>
                                                                        ';
                                                                    }
                                                                }
                                                                
                                                            echo '
                                                        </select>
                                                    </div>

                                                    <div class="row" id="rendered_authors2'.$number.'"></div>

                                                    <script>
                                                        $(document).ready(function() {
                                                        ';

                                                        $sql = 'SELECT * FROM author_book_bridge_table WHERE book_id = ?';
                                                        $statement = $pdo->prepare($sql);
                                                        $statement->execute(array($catalog['book_id']));
                                                        $book_ids = $statement->fetchAll();
                                                        
                                                        $author_names = '';

                                                        foreach($book_ids as $book_id){
                                                            $sql = 'SELECT * FROM author_table WHERE author_id = ?';
                                                            $statement = $pdo->prepare($sql);
                                                            $statement->execute(array($book_id['author_id']));
                                                            $author = $statement->fetch();
                                                            if(empty($author_names)){
                                                                $author_names = $author_names.$author['author_fullname'];
                                                            }else{
                                                                $author_names = $author_names.','.$author['author_fullname'];
                                                            }
                                                        }

                                                        $authors = preg_split("/\,/", $author_names);

                                                        echo '
                                                        $("#no_of_authors2'.$number.'")
                                                            .on("change", function() {
                                                                var str = "";
                                                                $("#no_of_authors2'.$number.' option:selected").each(function() {
                                                                    str += $(this).text() + " ";
                                                                });
                                                                if(str==1){
                                                                    $("#rendered_authors2'.$number.'").html(`
                                                                    ';
                                                                        for($numi = 1; $numi <= 1; $numi++){
                                                                            echo '
                                                                            <div class="form-group col-2 mb-0">
                                                                                <label class="col-form-label">Author '.$numi.'
                                                                                    <span class="text-danger"><em>(required)</em></span>
                                                                                </label>
                                                                                <input type="text" class="form-control border-dark border" list="authors-list" id="input-datalist2" name="catalog_author'.$numi.'"
                                                                                value="'; 
                                                                                if(isset($authors[$numi-1])){
                                                                                    echo $authors[$numi-1];
                                                                                } 
                                                                                echo '"
                                                                                required>
                                                                                <datalist id="authors-list">
                                                                                    '.$options.'
                                                                                </datalist>
                                                                            </div>';
                                                                        }
                                                                    echo '
                                                                    `);
                                                                }else if(str==2){
                                                                    $("#rendered_authors2'.$number.'").html(`
                                                                    ';
                                                                        for($numi = 1; $numi <= 2; $numi++){
                                                                            echo '
                                                                            <div class="form-group col-2 mb-0">
                                                                                <label class="col-form-label">Author '.$numi.'
                                                                                    <span class="text-danger"><em>(required)</em></span>
                                                                                </label>
                                                                                <input type="text" class="form-control border-dark border" list="authors-list" id="input-datalist2" name="catalog_author'.$numi.'" 
                                                                                value="'; 
                                                                                if(isset($authors[$numi-1])){
                                                                                    echo $authors[$numi-1];
                                                                                } 
                                                                                echo '"
                                                                                required>
                                                                                <datalist id="authors-list">
                                                                                    '.$options.'
                                                                                </datalist>
                                                                            </div>';
                                                                        }
                                                                    echo '
                                                                    `);
                                                                }else if(str==3){
                                                                    $("#rendered_authors2'.$number.'").html(`
                                                                    ';
                                                                        for($numi = 1; $numi <= 3; $numi++){
                                                                            echo '
                                                                            <div class="form-group col-2 mb-0">
                                                                                <label class="col-form-label">Author '.$numi.'
                                                                                    <span class="text-danger"><em>(required)</em></span>
                                                                                </label>
                                                                                <input type="text" class="form-control border-dark border" list="authors-list" id="input-datalist2" name="catalog_author'.$numi.'"
                                                                                value="'; 
                                                                                if(isset($authors[$numi-1])){
                                                                                    echo $authors[$numi-1];
                                                                                } 
                                                                                echo '" 
                                                                                required>
                                                                                <datalist id="authors-list">
                                                                                    '.$options.'
                                                                                </datalist>
                                                                            </div>';
                                                                        }
                                                                    echo '
                                                                    `);
                                                                }else if(str==4){
                                                                    $("#rendered_authors2'.$number.'").html(`
                                                                    ';
                                                                        for($numi = 1; $numi <= 4; $numi++){
                                                                            echo '
                                                                            <div class="form-group col-2 mb-0">
                                                                                <label class="col-form-label">Author '.$numi.'
                                                                                    <span class="text-danger"><em>(required)</em></span>
                                                                                </label>
                                                                                <input type="text" class="form-control border-dark border" list="authors-list" id="input-datalist2" name="catalog_author'.$numi.'" 
                                                                                value="'; 
                                                                                if(isset($authors[$numi-1])){
                                                                                    echo $authors[$numi-1];
                                                                                } 
                                                                                echo '" 
                                                                                required>
                                                                                <datalist id="authors-list">
                                                                                    '.$options.'
                                                                                </datalist>
                                                                            </div>';
                                                                        }
                                                                    echo '
                                                                    `);
                                                                }else if(str==5){
                                                                    $("#rendered_authors2'.$number.'").html(`
                                                                    ';
                                                                        for($numi = 1; $numi <= 5; $numi++){
                                                                            echo '
                                                                            <div class="form-group col-2 mb-0">
                                                                                <label class="col-form-label">Author '.$numi.'
                                                                                    <span class="text-danger"><em>(required)</em></span>
                                                                                </label>
                                                                                <input type="text" class="form-control border-dark border" list="authors-list" id="input-datalist2" name="catalog_author'.$numi.'" 
                                                                                value="'; 
                                                                                if(isset($authors[$numi-1])){
                                                                                    echo $authors[$numi-1];
                                                                                } 
                                                                                echo '" 
                                                                                required>
                                                                                <datalist id="authors-list">
                                                                                    '.$options.'
                                                                                </datalist>
                                                                            </div>';
                                                                        }
                                                                    echo '
                                                                    `);
                                                                }else if(str==6){
                                                                    $("#rendered_authors2'.$number.'").html(`
                                                                    ';
                                                                        for($numi = 1; $numi <= 6; $numi++){
                                                                            echo '
                                                                            <div class="form-group col-2 mb-0">
                                                                                <label class="col-form-label">Author '.$numi.'
                                                                                    <span class="text-danger"><em>(required)</em></span>
                                                                                </label>
                                                                                <input type="text" class="form-control border-dark border" list="authors-list" id="input-datalist2" name="catalog_author'.$numi.'"
                                                                                value="'; 
                                                                                if(isset($authors[$numi-1])){
                                                                                    echo $authors[$numi-1];
                                                                                } 
                                                                                echo '" 
                                                                                required>
                                                                                <datalist id="authors-list">
                                                                                    '.$options.'
                                                                                </datalist>
                                                                            </div>';
                                                                        }
                                                                    echo '
                                                                    `);
                                                                }else if(str==7){
                                                                    $("#rendered_authors2'.$number.'").html(`
                                                                    ';
                                                                        for($numi = 1; $numi <= 7; $numi++){
                                                                            echo '
                                                                            <div class="form-group col-2 mb-0">
                                                                                <label class="col-form-label">Author '.$numi.'
                                                                                    <span class="text-danger"><em>(required)</em></span>
                                                                                </label>
                                                                                <input type="text" class="form-control border-dark border" list="authors-list" id="input-datalist2" name="catalog_author'.$numi.'" 
                                                                                value="'; 
                                                                                if(isset($authors[$numi-1])){
                                                                                    echo $authors[$numi-1];
                                                                                } 
                                                                                echo '" 
                                                                                required>
                                                                                <datalist id="authors-list">
                                                                                    '.$options.'
                                                                                </datalist>
                                                                            </div>';
                                                                        }
                                                                    echo '
                                                                    `);
                                                                }else if(str==8){
                                                                    $("#rendered_authors2'.$number.'").html(`
                                                                    ';
                                                                        for($numi = 1; $numi <= 8; $numi++){
                                                                            echo '
                                                                            <div class="form-group col-2 mb-0">
                                                                                <label class="col-form-label">Author '.$numi.'
                                                                                    <span class="text-danger"><em>(required)</em></span>
                                                                                </label>
                                                                                <input type="text" class="form-control border-dark border" list="authors-list" id="input-datalist2" name="catalog_author'.$numi.'" 
                                                                                value="'; 
                                                                                if(isset($authors[$numi-1])){
                                                                                    echo $authors[$numi-1];
                                                                                } 
                                                                                echo '" 
                                                                                required>
                                                                                <datalist id="authors-list">
                                                                                    '.$options.'
                                                                                </datalist>
                                                                            </div>';
                                                                        }
                                                                    echo '
                                                                    `);
                                                                }else if(str==9){
                                                                    $("#rendered_authors2'.$number.'").html(`
                                                                    ';
                                                                        for($numi = 1; $numi <= 9; $numi++){
                                                                            echo '
                                                                            <div class="form-group col-2 mb-0">
                                                                                <label class="col-form-label">Author '.$numi.'
                                                                                    <span class="text-danger"><em>(required)</em></span>
                                                                                </label>
                                                                                <input type="text" class="form-control border-dark border" list="authors-list" id="input-datalist2" name="catalog_author'.$numi.'" 
                                                                                value="'; 
                                                                                if(isset($authors[$numi-1])){
                                                                                    echo $authors[$numi-1];
                                                                                } 
                                                                                echo '" 
                                                                                required>
                                                                                <datalist id="authors-list">
                                                                                    '.$options.'
                                                                                </datalist>
                                                                            </div>';
                                                                        }
                                                                    echo '
                                                                    `);
                                                                }else if(str==10){
                                                                    $("#rendered_authors2'.$number.'").html(`
                                                                    ';
                                                                        for($numi = 1; $numi <= 10; $numi++){
                                                                            echo '
                                                                            <div class="form-group col-2 mb-0">
                                                                                <label class="col-form-label">Author '.$numi.'
                                                                                    <span class="text-danger"><em>(required)</em></span>
                                                                                </label>
                                                                                <input type="text" class="form-control border-dark border" list="authors-list" id="input-datalist2" name="catalog_author'.$numi.'" 
                                                                                value="'; 
                                                                                if(isset($authors[$numi-1])){
                                                                                    echo $authors[$numi-1];
                                                                                } 
                                                                                echo '" 
                                                                                required>
                                                                                <datalist id="authors-list">
                                                                                    '.$options.'
                                                                                </datalist>
                                                                            </div>';
                                                                        }
                                                                    echo '
                                                                    `);
                                                                }else if(str==11){
                                                                    $("#rendered_authors2'.$number.'").html(`
                                                                    ';
                                                                        for($numi = 1; $numi <= 11; $numi++){
                                                                            echo '
                                                                            <div class="form-group col-2 mb-0">
                                                                                <label class="col-form-label">Author '.$numi.'
                                                                                    <span class="text-danger"><em>(required)</em></span>
                                                                                </label>
                                                                                <input type="text" class="form-control border-dark border" list="authors-list" id="input-datalist2" name="catalog_author'.$numi.'" 
                                                                                value="'; 
                                                                                if(isset($authors[$numi-1])){
                                                                                    echo $authors[$numi-1];
                                                                                } 
                                                                                echo '" 
                                                                                required>
                                                                                <datalist id="authors-list">
                                                                                    '.$options.'
                                                                                </datalist>
                                                                            </div>';
                                                                        }
                                                                    echo '
                                                                    `);
                                                                }else if(str==12){
                                                                    $("#rendered_authors2'.$number.'").html(`
                                                                    ';
                                                                        for($numi = 1; $numi <= 12; $numi++){
                                                                            echo '
                                                                            <div class="form-group col-2 mb-0">
                                                                                <label class="col-form-label">Author '.$numi.'
                                                                                    <span class="text-danger"><em>(required)</em></span>
                                                                                </label>
                                                                                <input type="text" class="form-control border-dark border" list="authors-list" id="input-datalis2" name="catalog_author'.$numi.'" 
                                                                                value="'; 
                                                                                if(isset($authors[$numi-1])){
                                                                                    echo $authors[$numi-1];
                                                                                } 
                                                                                echo '" 
                                                                                required>
                                                                                <datalist id="authors-list">
                                                                                    '.$options.'
                                                                                </datalist>
                                                                            </div>';
                                                                        }
                                                                    echo '
                                                                    `);
                                                                }else if(str==13){
                                                                    $("#rendered_authors2'.$number.'").html(`
                                                                    ';
                                                                        for($numi = 1; $numi <= 13; $numi++){
                                                                            echo '
                                                                            <div class="form-group col-2 mb-0">
                                                                                <label class="col-form-label">Author '.$numi.'
                                                                                    <span class="text-danger"><em>(required)</em></span>
                                                                                </label>
                                                                                <input type="text" class="form-control border-dark border" list="authors-list" id="input-datalist2" name="catalog_author'.$numi.'" 
                                                                                value="'; 
                                                                                if(isset($authors[$numi-1])){
                                                                                    echo $authors[$numi-1];
                                                                                } 
                                                                                echo '" 
                                                                                required>
                                                                                <datalist id="authors-list">
                                                                                    '.$options.'
                                                                                </datalist>
                                                                            </div>';
                                                                        }
                                                                    echo '
                                                                    `);
                                                                }else if(str==14){
                                                                    $("#rendered_authors2'.$number.'").html(`
                                                                    ';
                                                                        for($numi = 1; $numi <= 14; $numi++){
                                                                            echo '
                                                                            <div class="form-group col-2 mb-0">
                                                                                <label class="col-form-label">Author '.$numi.'
                                                                                    <span class="text-danger"><em>(required)</em></span>
                                                                                </label>
                                                                                <input type="text" class="form-control border-dark border" list="authors-list" id="input-datalist2" name="catalog_author'.$numi.'" 
                                                                                value="'; 
                                                                                if(isset($authors[$numi-1])){
                                                                                    echo $authors[$numi-1];
                                                                                } 
                                                                                echo '" 
                                                                                required>
                                                                                <datalist id="authors-list">
                                                                                    '.$options.'
                                                                                </datalist>
                                                                            </div>';
                                                                        }
                                                                    echo '
                                                                    `);
                                                                }else if(str==15){
                                                                    $("#rendered_authors2'.$number.'").html(`
                                                                    ';
                                                                        for($numi = 1; $numi <= 15; $numi++){
                                                                            echo '
                                                                            <div class="form-group col-2 mb-0">
                                                                                <label class="col-form-label">Author '.$numi.'
                                                                                    <span class="text-danger"><em>(required)</em></span>
                                                                                </label>
                                                                                <input type="text" class="form-control border-dark border" list="authors-list" id="input-datalist2" name="catalog_author'.$numi.'" 
                                                                                value="'; 
                                                                                if(isset($authors[$numi-1])){
                                                                                    echo $authors[$numi-1];
                                                                                } 
                                                                                echo '" 
                                                                                required>
                                                                                <datalist id="authors-list">
                                                                                    '.$options.'
                                                                                </datalist>
                                                                            </div>';
                                                                        }
                                                                    echo '
                                                                    `);
                                                                }else if(str==16){
                                                                    $("#rendered_authors2'.$number.'").html(`
                                                                    ';
                                                                        for($numi = 1; $numi <= 16; $numi++){
                                                                            echo '
                                                                            <div class="form-group col-2 mb-0">
                                                                                <label class="col-form-label">Author '.$numi.'
                                                                                    <span class="text-danger"><em>(required)</em></span>
                                                                                </label>
                                                                                <input type="text" class="form-control border-dark border" list="authors-list" id="input-datalist2" name="catalog_author'.$numi.'" 
                                                                                value="'; 
                                                                                if(isset($authors[$numi-1])){
                                                                                    echo $authors[$numi-1];
                                                                                } 
                                                                                echo '" 
                                                                                required>
                                                                                <datalist id="authors-list">
                                                                                    '.$options.'
                                                                                </datalist>
                                                                            </div>';
                                                                        }
                                                                    echo '
                                                                    `);
                                                                }else if(str==17){
                                                                    $("#rendered_authors2'.$number.'").html(`
                                                                    ';
                                                                        for($numi = 1; $numi <= 17; $numi++){
                                                                            echo '
                                                                            <div class="form-group col-2 mb-0">
                                                                                <label class="col-form-label">Author '.$numi.'
                                                                                    <span class="text-danger"><em>(required)</em></span>
                                                                                </label>
                                                                                <input type="text" class="form-control border-dark border" list="authors-list" id="input-datalist2" name="catalog_author'.$numi.'" 
                                                                                value="'; 
                                                                                if(isset($authors[$numi-1])){
                                                                                    echo $authors[$numi-1];
                                                                                } 
                                                                                echo '" 
                                                                                required>
                                                                                <datalist id="authors-list">
                                                                                    '.$options.'
                                                                                </datalist>
                                                                            </div>';
                                                                        }
                                                                    echo '
                                                                    `);
                                                                }else if(str==18){
                                                                    $("#rendered_authors2'.$number.'").html(`
                                                                    ';
                                                                        for($numi = 1; $numi <= 18; $numi++){
                                                                            echo '
                                                                            <div class="form-group col-2 mb-0">
                                                                                <label class="col-form-label">Author '.$numi.'
                                                                                    <span class="text-danger"><em>(required)</em></span>
                                                                                </label>
                                                                                <input type="text" class="form-control border-dark border" list="authors-list" id="input-datalist2" name="catalog_author'.$numi.'" 
                                                                                value="'; 
                                                                                if(isset($authors[$numi-1])){
                                                                                    echo $authors[$numi-1];
                                                                                } 
                                                                                echo '" 
                                                                                required>
                                                                                <datalist id="authors-list">
                                                                                    '.$options.'
                                                                                </datalist>
                                                                            </div>';
                                                                        }
                                                                    echo '
                                                                    `);
                                                                }else if(str==19){
                                                                    $("#rendered_authors2'.$number.'").html(`
                                                                    ';
                                                                        for($numi = 1; $numi <= 19; $numi++){
                                                                            echo '
                                                                            <div class="form-group col-2 mb-0">
                                                                                <label class="col-form-label">Author '.$numi.'
                                                                                    <span class="text-danger"><em>(required)</em></span>
                                                                                </label>
                                                                                <input type="text" class="form-control border-dark border" list="authors-list" id="input-datalist2" name="catalog_author'.$numi.'" 
                                                                                value="'; 
                                                                                if(isset($authors[$numi-1])){
                                                                                    echo $authors[$numi-1];
                                                                                } 
                                                                                echo '" 
                                                                                required>
                                                                                <datalist id="authors-list">
                                                                                    '.$options.'
                                                                                </datalist>
                                                                            </div>';
                                                                        }
                                                                    echo '
                                                                    `);
                                                                }else if(str==20){
                                                                    $("#rendered_authors2'.$number.'").html(`
                                                                    ';
                                                                        for($numi = 1; $numi <= 20; $numi++){
                                                                            echo '
                                                                            <div class="form-group col-2 mb-0">
                                                                                <label class="col-form-label">Author '.$numi.'
                                                                                    <span class="text-danger"><em>(required)</em></span>
                                                                                </label>
                                                                                <input type="text" class="form-control border-dark border" list="authors-list" id="input-datalist2" name="catalog_author'.$numi.'" 
                                                                                value="'; 
                                                                                if(isset($authors[$numi-1])){
                                                                                    echo $authors[$numi-1];
                                                                                } 
                                                                                echo '" 
                                                                                required>
                                                                                <datalist id="authors-list">
                                                                                    '.$options.'
                                                                                </datalist>
                                                                            </div>';
                                                                        }
                                                                    echo '
                                                                    `);
                                                                }else{
                                                                    $("#rendered_authors2'.$number.'").html(``);
                                                                }
                                                                
                                                            })
                                                            .trigger("change");';
                                                        echo '
                                                        });
                                                    
                                                        document.addEventListener("DOMContentLoaded", e => {
                                                            $("#input-datalist2").autocomplete()
                                                        }, false);
                            
                                                    </script>
                            
                                                    <div class="form-group col-12 m-0">
                                                        <hr />
                                                    </div>
                                                    <div class="form-group col-3 mb-0">
                                                        <label class="col-form-label">Publisher
                                                        <span class="text-danger"><em>(required)</em></span>
                                                        </label>
                                                        <input type="text" name="catalog_publisher"
                                                            class="form-control border-dark border" value="'.$catalog['catalog_publisher'].'" required/>
                                                    </div>
                                                    <div class="form-group col-3 mb-0">
                                                        <label class="col-form-label">Year
                                                        <span class="text-danger"><em>(required)</em></span>
                                                        </label>
                                                        <input type="text" name="catalog_year"
                                                            class="form-control border-dark border" value="'.$catalog['catalog_year'].'" required/>
                                                    </div>
                                                    <div class="form-group col-3 mb-0">
                                                        <label class="col-form-label">Date Received</label>
                                                        <input type="text" name="catalog_date_received"
                                                            class="form-control border-dark border" value="'.$catalog['catalog_date_received'].'"/>
                                                    </div>
                                                    <div class="form-group col-3 mb-0">
                                                        <label class="col-form-label">Class</label>
                                                        <input type="text" name="catalog_class"
                                                            class="form-control border-dark border" value="'.$catalog['catalog_class'].'"/>
                                                    </div>
                                                    <div class="form-group col-3 mb-0">
                                                        <label class="col-form-label">Edition</label>
                                                        <input type="text" name="catalog_edition"
                                                            class="form-control border-dark border" value="'.$catalog['catalog_edition'].'"/>
                                                    </div>
                                                    <div class="form-group col-3 mb-0">
                                                        <label class="col-form-label">Volumes</label>
                                                        <input type="text" name="catalog_volumes"
                                                            class="form-control border-dark border" value="'.$catalog['catalog_volumes'].'"/>
                                                    </div>
                                                    <div class="form-group col-3 mb-0">
                                                        <label class="col-form-label">Pages</label>
                                                        <input type="text" name="catalog_pages"
                                                            class="form-control border-dark border" value="'.$catalog['catalog_pages'].'"/>
                                                    </div>
                                                    <div class="form-group col-3 mb-0">
                                                        <label class="col-form-label">Source of Fund</label>
                                                        <input type="text" name="catalog_source_of_fund"
                                                            class="form-control border-dark border" value="'.$catalog['catalog_source_of_fund'].'"/>
                                                    </div>
                                                    <div class="form-group col-3 mb-0">
                                                        <label class="col-form-label">Cost Price</label>
                                                        <input type="text" name="catalog_cost_price"
                                                            class="form-control border-dark border" value="'.$catalog['catalog_cost_price'].'"/>
                                                    </div>
                                                    <div class="form-group col-3 mb-0">
                                                        <label class="col-form-label">Location Symbol</label>
                                                        <input type="text" name="catalog_location_symbol"
                                                            class="form-control border-dark border" value="'.$catalog['catalog_location_symbol'].'"/>
                                                    </div>
                                                    <div class="form-group col-3 mb-0">
                                                        <label class="col-form-label">Class Number</label>
                                                        <input type="text" name="catalog_class_number"
                                                            class="form-control border-dark border" value="'.$catalog['catalog_class_number'].'"/>
                                                    </div>
                                                    <div class="form-group col-3 mb-0">
                                                        <label class="col-form-label">Author Number</label>
                                                        <input type="text" name="catalog_author_number"
                                                            class="form-control border-dark border" value="'.$catalog['catalog_author_number'].'"/>
                                                    </div>
                                                    <div class="form-group col-3 mb-0">
                                                        <label class="col-form-label">Copyright Date</label>
                                                        <input type="text" name="catalog_copyright_date"
                                                            class="form-control border-dark border" value="'.$catalog['catalog_copyright_date'].'"/>
                                                    </div>
                                                    <div class="form-group col-3 mb-0">
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
                                <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                data-bs-target="#modalClone'.$number.'" onclick="clearRFID2()">
                                Clone Book
                            </button>
                                                        
                                <!-- add modal -->
    <div class="modal fade" id="modalClone'.$number.'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form action="api/add_catalog.php" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Clone Book</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body row">
                        <input type="hidden" name="librarian_id" value="'; echo $librarian_id; echo '">

                        <div class="form-group col-12 mb-1">
                            <label class="col-form-label">RFID Code <span class="text-danger"><em>(required)(must be new)</em></span></label>

                            <span class="renderrfidcode">

                            </span>
                            <!-- triggers modal and refresh rfid code -->
                            <button type="button" class="btn btn-primary mt-2" onclick="clearRFID()">Clear / Scan
                                New</button>

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

                        </div>

                        <div class="form-group col-4 mb-0">
                            <label class="col-form-label">Catalog Number
                                <span class="text-danger"><em>(required)(must be new)</em></span>
                            </label>
                            <input type="text" name="catalog_number" class="form-control border-dark border" required />
                        </div>
                        <div class="form-group col-3 mb-0">
                            <label class="col-form-label">Book Title
                                <span class="text-danger"><em>(required)</em></span>
                            </label>
                            <input type="text" class="form-control border-dark border" value="'.$catalog['catalog_book_title'].'"
                                disabled/>
                            <input type="hidden" name="catalog_book_title" value="'.$catalog['catalog_book_title'].'"
                                required/>
                        </div>

                        <div class="form-group col-12 m-0">
                            <hr/>
                        </div>
                        
                        ';

                        $sql = 'SELECT * FROM author_book_bridge_table WHERE book_id = ?';
                        $statement = $pdo->prepare($sql);
                        $statement->execute(array($catalog['book_id']));
                        $book_ids = $statement->fetchAll();
                        
                        $author_names = '';

                        foreach($book_ids as $book_id){
                            $sql = 'SELECT * FROM author_table WHERE author_id = ?';
                            $statement = $pdo->prepare($sql);
                            $statement->execute(array($book_id['author_id']));
                            $author = $statement->fetch();
                            if(empty($author_names)){
                                $author_names = $author_names.$author['author_fullname'];
                            }else{
                                $author_names = $author_names.','.$author['author_fullname'];
                            }
                        }

                        echo '
                        <div class="form-group col-12 mb-0">
                            <label class="col-form-label">Number of Authors
                                <span class="text-danger"><em>(required)</em></span>
                            </label>
                            <select class="form-select col-2 border-dark border" aria-label="select example" id="no_of_authors3'.$number.'">';
                                    $no_authors = preg_split("/\,/", $author_names);
                                    for($num = 1; $num <= 20; $num++){
                                        if(count($no_authors)==$num){
                                            echo '
                                            <option value="'.$num.'" selected>'.$num.'</option>
                                            ';
                                        }else{
                                            echo '
                                            <option value="'.$num.'">'.$num.'</option>
                                            ';
                                        }
                                    }
                                    
                                echo '
                            </select>
                        </div>

                        <div class="row" id="rendered_authors3'.$number.'"></div>
                        <script>
                            $(document).ready(function() {
                            ';

                            $sql = 'SELECT * FROM author_book_bridge_table WHERE book_id = ?';
                            $statement = $pdo->prepare($sql);
                            $statement->execute(array($catalog['book_id']));
                            $book_ids = $statement->fetchAll();
                            
                            $author_names = '';

                            foreach($book_ids as $book_id){
                                $sql = 'SELECT * FROM author_table WHERE author_id = ?';
                                $statement = $pdo->prepare($sql);
                                $statement->execute(array($book_id['author_id']));
                                $author = $statement->fetch();
                                if(empty($author_names)){
                                    $author_names = $author_names.$author['author_fullname'];
                                }else{
                                    $author_names = $author_names.','.$author['author_fullname'];
                                }
                            }

                            $authors = preg_split("/\,/", $author_names);

                            echo '
                            $("#no_of_authors3'.$number.'")
                                .on("change", function() {
                                    var str = "";
                                    $("#no_of_authors3'.$number.' option:selected").each(function() {
                                        str += $(this).text() + " ";
                                    });
                                    if(str==1){
                                        $("#rendered_authors3'.$number.'").html(`
                                        ';
                                            for($numi = 1; $numi <= 1; $numi++){
                                                echo '
                                                <div class="form-group col-2 mb-0">
                                                    <label class="col-form-label">Author '.$numi.'
                                                        <span class="text-danger"><em>(required)</em></span>
                                                    </label>
                                                    <input type="text" class="form-control border-dark border" list="authors-list" id="input-datalist2" name="catalog_author'.$numi.'"
                                                    value="'; 
                                                    if(isset($authors[$numi-1])){
                                                        echo $authors[$numi-1];
                                                    } 
                                                    echo '"
                                                    required>
                                                    <datalist id="authors-list3">
                                                        '.$options.'
                                                    </datalist>
                                                </div>';
                                            }
                                        echo '
                                        `);
                                    }else if(str==2){
                                        $("#rendered_authors3'.$number.'").html(`
                                        ';
                                            for($numi = 1; $numi <= 2; $numi++){
                                                echo '
                                                <div class="form-group col-2 mb-0">
                                                    <label class="col-form-label">Author '.$numi.'
                                                        <span class="text-danger"><em>(required)</em></span>
                                                    </label>
                                                    <input type="text" class="form-control border-dark border" list="authors-list" id="input-datalist2" name="catalog_author'.$numi.'" 
                                                    value="'; 
                                                    if(isset($authors[$numi-1])){
                                                        echo $authors[$numi-1];
                                                    } 
                                                    echo '"
                                                    required>
                                                    <datalist id="authors-list3">
                                                        '.$options.'
                                                    </datalist>
                                                </div>';
                                            }
                                        echo '
                                        `);
                                    }else if(str==3){
                                        $("#rendered_authors3'.$number.'").html(`
                                        ';
                                            for($numi = 1; $numi <= 3; $numi++){
                                                echo '
                                                <div class="form-group col-2 mb-0">
                                                    <label class="col-form-label">Author '.$numi.'
                                                        <span class="text-danger"><em>(required)</em></span>
                                                    </label>
                                                    <input type="text" class="form-control border-dark border" list="authors-list" id="input-datalist2" name="catalog_author'.$numi.'"
                                                    value="'; 
                                                    if(isset($authors[$numi-1])){
                                                        echo $authors[$numi-1];
                                                    } 
                                                    echo '" 
                                                    required>
                                                    <datalist id="authors-list3">
                                                        '.$options.'
                                                    </datalist>
                                                </div>';
                                            }
                                        echo '
                                        `);
                                    }else if(str==4){
                                        $("#rendered_authors3'.$number.'").html(`
                                        ';
                                            for($numi = 1; $numi <= 4; $numi++){
                                                echo '
                                                <div class="form-group col-2 mb-0">
                                                    <label class="col-form-label">Author '.$numi.'
                                                        <span class="text-danger"><em>(required)</em></span>
                                                    </label>
                                                    <input type="text" class="form-control border-dark border" list="authors-list" id="input-datalist2" name="catalog_author'.$numi.'" 
                                                    value="'; 
                                                    if(isset($authors[$numi-1])){
                                                        echo $authors[$numi-1];
                                                    } 
                                                    echo '" 
                                                    required>
                                                    <datalist id="authors-list3">
                                                        '.$options.'
                                                    </datalist>
                                                </div>';
                                            }
                                        echo '
                                        `);
                                    }else if(str==5){
                                        $("#rendered_authors3'.$number.'").html(`
                                        ';
                                            for($numi = 1; $numi <= 5; $numi++){
                                                echo '
                                                <div class="form-group col-2 mb-0">
                                                    <label class="col-form-label">Author '.$numi.'
                                                        <span class="text-danger"><em>(required)</em></span>
                                                    </label>
                                                    <input type="text" class="form-control border-dark border" list="authors-list" id="input-datalist2" name="catalog_author'.$numi.'" 
                                                    value="'; 
                                                    if(isset($authors[$numi-1])){
                                                        echo $authors[$numi-1];
                                                    } 
                                                    echo '" 
                                                    required>
                                                    <datalist id="authors-list">
                                                        '.$options.'
                                                    </datalist>
                                                </div>';
                                            }
                                        echo '
                                        `);
                                    }else if(str==6){
                                        $("#rendered_authors3'.$number.'").html(`
                                        ';
                                            for($numi = 1; $numi <= 6; $numi++){
                                                echo '
                                                <div class="form-group col-2 mb-0">
                                                    <label class="col-form-label">Author '.$numi.'
                                                        <span class="text-danger"><em>(required)</em></span>
                                                    </label>
                                                    <input type="text" class="form-control border-dark border" list="authors-list" id="input-datalist2" name="catalog_author'.$numi.'"
                                                    value="'; 
                                                    if(isset($authors[$numi-1])){
                                                        echo $authors[$numi-1];
                                                    } 
                                                    echo '" 
                                                    required>
                                                    <datalist id="authors-list">
                                                        '.$options.'
                                                    </datalist>
                                                </div>';
                                            }
                                        echo '
                                        `);
                                    }else if(str==7){
                                        $("#rendered_authors3'.$number.'").html(`
                                        ';
                                            for($numi = 1; $numi <= 7; $numi++){
                                                echo '
                                                <div class="form-group col-2 mb-0">
                                                    <label class="col-form-label">Author '.$numi.'
                                                        <span class="text-danger"><em>(required)</em></span>
                                                    </label>
                                                    <input type="text" class="form-control border-dark border" list="authors-list" id="input-datalist2" name="catalog_author'.$numi.'" 
                                                    value="'; 
                                                    if(isset($authors[$numi-1])){
                                                        echo $authors[$numi-1];
                                                    } 
                                                    echo '" 
                                                    required>
                                                    <datalist id="authors-list">
                                                        '.$options.'
                                                    </datalist>
                                                </div>';
                                            }
                                        echo '
                                        `);
                                    }else if(str==8){
                                        $("#rendered_authors3'.$number.'").html(`
                                        ';
                                            for($numi = 1; $numi <= 8; $numi++){
                                                echo '
                                                <div class="form-group col-2 mb-0">
                                                    <label class="col-form-label">Author '.$numi.'
                                                        <span class="text-danger"><em>(required)</em></span>
                                                    </label>
                                                    <input type="text" class="form-control border-dark border" list="authors-list" id="input-datalist2" name="catalog_author'.$numi.'" 
                                                    value="'; 
                                                    if(isset($authors[$numi-1])){
                                                        echo $authors[$numi-1];
                                                    } 
                                                    echo '" 
                                                    required>
                                                    <datalist id="authors-list">
                                                        '.$options.'
                                                    </datalist>
                                                </div>';
                                            }
                                        echo '
                                        `);
                                    }else if(str==9){
                                        $("#rendered_authors3'.$number.'").html(`
                                        ';
                                            for($numi = 1; $numi <= 9; $numi++){
                                                echo '
                                                <div class="form-group col-2 mb-0">
                                                    <label class="col-form-label">Author '.$numi.'
                                                        <span class="text-danger"><em>(required)</em></span>
                                                    </label>
                                                    <input type="text" class="form-control border-dark border" list="authors-list" id="input-datalist2" name="catalog_author'.$numi.'" 
                                                    value="'; 
                                                    if(isset($authors[$numi-1])){
                                                        echo $authors[$numi-1];
                                                    } 
                                                    echo '" 
                                                    required>
                                                    <datalist id="authors-list">
                                                        '.$options.'
                                                    </datalist>
                                                </div>';
                                            }
                                        echo '
                                        `);
                                    }else if(str==10){
                                        $("#rendered_authors3'.$number.'").html(`
                                        ';
                                            for($numi = 1; $numi <= 10; $numi++){
                                                echo '
                                                <div class="form-group col-2 mb-0">
                                                    <label class="col-form-label">Author '.$numi.'
                                                        <span class="text-danger"><em>(required)</em></span>
                                                    </label>
                                                    <input type="text" class="form-control border-dark border" list="authors-list" id="input-datalist2" name="catalog_author'.$numi.'" 
                                                    value="'; 
                                                    if(isset($authors[$numi-1])){
                                                        echo $authors[$numi-1];
                                                    } 
                                                    echo '" 
                                                    required>
                                                    <datalist id="authors-list">
                                                        '.$options.'
                                                    </datalist>
                                                </div>';
                                            }
                                        echo '
                                        `);
                                    }else if(str==11){
                                        $("#rendered_authors3'.$number.'").html(`
                                        ';
                                            for($numi = 1; $numi <= 11; $numi++){
                                                echo '
                                                <div class="form-group col-2 mb-0">
                                                    <label class="col-form-label">Author '.$numi.'
                                                        <span class="text-danger"><em>(required)</em></span>
                                                    </label>
                                                    <input type="text" class="form-control border-dark border" list="authors-list" id="input-datalist2" name="catalog_author'.$numi.'" 
                                                    value="'; 
                                                    if(isset($authors[$numi-1])){
                                                        echo $authors[$numi-1];
                                                    } 
                                                    echo '" 
                                                    required>
                                                    <datalist id="authors-list">
                                                        '.$options.'
                                                    </datalist>
                                                </div>';
                                            }
                                        echo '
                                        `);
                                    }else if(str==12){
                                        $("#rendered_authors3'.$number.'").html(`
                                        ';
                                            for($numi = 1; $numi <= 12; $numi++){
                                                echo '
                                                <div class="form-group col-2 mb-0">
                                                    <label class="col-form-label">Author '.$numi.'
                                                        <span class="text-danger"><em>(required)</em></span>
                                                    </label>
                                                    <input type="text" class="form-control border-dark border" list="authors-list" id="input-datalis2" name="catalog_author'.$numi.'" 
                                                    value="'; 
                                                    if(isset($authors[$numi-1])){
                                                        echo $authors[$numi-1];
                                                    } 
                                                    echo '" 
                                                    required>
                                                    <datalist id="authors-list">
                                                        '.$options.'
                                                    </datalist>
                                                </div>';
                                            }
                                        echo '
                                        `);
                                    }else if(str==13){
                                        $("#rendered_authors3'.$number.'").html(`
                                        ';
                                            for($numi = 1; $numi <= 13; $numi++){
                                                echo '
                                                <div class="form-group col-2 mb-0">
                                                    <label class="col-form-label">Author '.$numi.'
                                                        <span class="text-danger"><em>(required)</em></span>
                                                    </label>
                                                    <input type="text" class="form-control border-dark border" list="authors-list" id="input-datalist2" name="catalog_author'.$numi.'" 
                                                    value="'; 
                                                    if(isset($authors[$numi-1])){
                                                        echo $authors[$numi-1];
                                                    } 
                                                    echo '" 
                                                    required>
                                                    <datalist id="authors-list">
                                                        '.$options.'
                                                    </datalist>
                                                </div>';
                                            }
                                        echo '
                                        `);
                                    }else if(str==14){
                                        $("#rendered_authors3'.$number.'").html(`
                                        ';
                                            for($numi = 1; $numi <= 14; $numi++){
                                                echo '
                                                <div class="form-group col-2 mb-0">
                                                    <label class="col-form-label">Author '.$numi.'
                                                        <span class="text-danger"><em>(required)</em></span>
                                                    </label>
                                                    <input type="text" class="form-control border-dark border" list="authors-list" id="input-datalist2" name="catalog_author'.$numi.'" 
                                                    value="'; 
                                                    if(isset($authors[$numi-1])){
                                                        echo $authors[$numi-1];
                                                    } 
                                                    echo '" 
                                                    required>
                                                    <datalist id="authors-list">
                                                        '.$options.'
                                                    </datalist>
                                                </div>';
                                            }
                                        echo '
                                        `);
                                    }else if(str==15){
                                        $("#rendered_authors3'.$number.'").html(`
                                        ';
                                            for($numi = 1; $numi <= 15; $numi++){
                                                echo '
                                                <div class="form-group col-2 mb-0">
                                                    <label class="col-form-label">Author '.$numi.'
                                                        <span class="text-danger"><em>(required)</em></span>
                                                    </label>
                                                    <input type="text" class="form-control border-dark border" list="authors-list" id="input-datalist2" name="catalog_author'.$numi.'" 
                                                    value="'; 
                                                    if(isset($authors[$numi-1])){
                                                        echo $authors[$numi-1];
                                                    } 
                                                    echo '" 
                                                    required>
                                                    <datalist id="authors-list">
                                                        '.$options.'
                                                    </datalist>
                                                </div>';
                                            }
                                        echo '
                                        `);
                                    }else if(str==16){
                                        $("#rendered_authors3'.$number.'").html(`
                                        ';
                                            for($numi = 1; $numi <= 16; $numi++){
                                                echo '
                                                <div class="form-group col-2 mb-0">
                                                    <label class="col-form-label">Author '.$numi.'
                                                        <span class="text-danger"><em>(required)</em></span>
                                                    </label>
                                                    <input type="text" class="form-control border-dark border" list="authors-list" id="input-datalist2" name="catalog_author'.$numi.'" 
                                                    value="'; 
                                                    if(isset($authors[$numi-1])){
                                                        echo $authors[$numi-1];
                                                    } 
                                                    echo '" 
                                                    required>
                                                    <datalist id="authors-list">
                                                        '.$options.'
                                                    </datalist>
                                                </div>';
                                            }
                                        echo '
                                        `);
                                    }else if(str==17){
                                        $("#rendered_authors3'.$number.'").html(`
                                        ';
                                            for($numi = 1; $numi <= 17; $numi++){
                                                echo '
                                                <div class="form-group col-2 mb-0">
                                                    <label class="col-form-label">Author '.$numi.'
                                                        <span class="text-danger"><em>(required)</em></span>
                                                    </label>
                                                    <input type="text" class="form-control border-dark border" list="authors-list" id="input-datalist2" name="catalog_author'.$numi.'" 
                                                    value="'; 
                                                    if(isset($authors[$numi-1])){
                                                        echo $authors[$numi-1];
                                                    } 
                                                    echo '" 
                                                    required>
                                                    <datalist id="authors-list">
                                                        '.$options.'
                                                    </datalist>
                                                </div>';
                                            }
                                        echo '
                                        `);
                                    }else if(str==18){
                                        $("#rendered_authors3'.$number.'").html(`
                                        ';
                                            for($numi = 1; $numi <= 18; $numi++){
                                                echo '
                                                <div class="form-group col-2 mb-0">
                                                    <label class="col-form-label">Author '.$numi.'
                                                        <span class="text-danger"><em>(required)</em></span>
                                                    </label>
                                                    <input type="text" class="form-control border-dark border" list="authors-list" id="input-datalist2" name="catalog_author'.$numi.'" 
                                                    value="'; 
                                                    if(isset($authors[$numi-1])){
                                                        echo $authors[$numi-1];
                                                    } 
                                                    echo '" 
                                                    required>
                                                    <datalist id="authors-list">
                                                        '.$options.'
                                                    </datalist>
                                                </div>';
                                            }
                                        echo '
                                        `);
                                    }else if(str==19){
                                        $("#rendered_authors3'.$number.'").html(`
                                        ';
                                            for($numi = 1; $numi <= 19; $numi++){
                                                echo '
                                                <div class="form-group col-2 mb-0">
                                                    <label class="col-form-label">Author '.$numi.'
                                                        <span class="text-danger"><em>(required)</em></span>
                                                    </label>
                                                    <input type="text" class="form-control border-dark border" list="authors-list" id="input-datalist2" name="catalog_author'.$numi.'" 
                                                    value="'; 
                                                    if(isset($authors[$numi-1])){
                                                        echo $authors[$numi-1];
                                                    } 
                                                    echo '" 
                                                    required>
                                                    <datalist id="authors-list">
                                                        '.$options.'
                                                    </datalist>
                                                </div>';
                                            }
                                        echo '
                                        `);
                                    }else if(str==20){
                                        $("#rendered_authors3'.$number.'").html(`
                                        ';
                                            for($numi = 1; $numi <= 20; $numi++){
                                                echo '
                                                <div class="form-group col-2 mb-0">
                                                    <label class="col-form-label">Author '.$numi.'
                                                        <span class="text-danger"><em>(required)</em></span>
                                                    </label>
                                                    <input type="text" class="form-control border-dark border" list="authors-list" id="input-datalist2" name="catalog_author'.$numi.'" 
                                                    value="'; 
                                                    if(isset($authors[$numi-1])){
                                                        echo $authors[$numi-1];
                                                    } 
                                                    echo '" 
                                                    required>
                                                    <datalist id="authors-list">
                                                        '.$options.'
                                                    </datalist>
                                                </div>';
                                            }
                                        echo '
                                        `);
                                    }else{
                                        $("#rendered_authors3'.$number.'").html(``);
                                    }
                                    
                                })
                                .trigger("change");';
                            echo '
                            });
                        
                            document.addEventListener("DOMContentLoaded", e => {
                                $("#input-datalist2").autocomplete()
                            }, false);

                        </script>


                        <div class="form-group col-12 m-0">
                            <hr />
                        </div>

                        <div class="form-group col-3 mb-0">
                            <label class="col-form-label">Publisher
                                <span class="text-danger"><em>(required)</em></span>
                            </label>
                            <input type="text" name="catalog_publisher" class="form-control border-dark border"
                                required />
                        </div>
                        <div class="form-group col-3 mb-0">
                            <label class="col-form-label">Year
                                <span class="text-danger"><em>(required)</em></span>
                            </label>
                            <input type="text" name="catalog_year" class="form-control border-dark border" required />
                        </div>
                        <div class="form-group col-3 mb-0">
                            <label class="col-form-label">Date Received</label>
                            <input type="text" name="catalog_date_received" class="form-control border-dark border" />
                        </div>
                        <div class="form-group col-3 mb-0">
                            <label class="col-form-label">Class</label>
                            <input type="text" name="catalog_class" class="form-control border-dark border" />
                        </div>
                        <div class="form-group col-3 mb-0">
                            <label class="col-form-label">Edition</label>
                            <input type="text" name="catalog_edition" class="form-control border-dark border" />
                        </div>
                        <div class="form-group col-3 mb-0">
                            <label class="col-form-label">Volumes</label>
                            <input type="text" name="catalog_volumes" class="form-control border-dark border" />
                        </div>
                        <div class="form-group col-3 mb-0">
                            <label class="col-form-label">Pages</label>
                            <input type="text" name="catalog_pages" class="form-control border-dark border" />
                        </div>
                        <div class="form-group col-3 mb-0">
                            <label class="col-form-label">Source of Fund</label>
                            <input type="text" name="catalog_source_of_fund" class="form-control border-dark border" />
                        </div>
                        <div class="form-group col-3 mb-0">
                            <label class="col-form-label">Cost Price</label>
                            <input type="text" name="catalog_cost_price" class="form-control border-dark border" />
                        </div>
                        <div class="form-group col-3 mb-0">
                            <label class="col-form-label">Location Symbol</label>
                            <input type="text" name="catalog_location_symbol" class="form-control border-dark border" />
                        </div>
                        <div class="form-group col-3 mb-0">
                            <label class="col-form-label">Class Number</label>
                            <input type="text" name="catalog_class_number" class="form-control border-dark border" />
                        </div>
                        <div class="form-group col-3 mb-0">
                            <label class="col-form-label">Author Number</label>
                            <input type="text" name="catalog_author_number" class="form-control border-dark border" />
                        </div>
                        <div class="form-group col-3 mb-0">
                            <label class="col-form-label">Copyright Date</label>
                            <input type="text" name="catalog_copyright_date" class="form-control border-dark border" />
                        </div>
                        <input type="hidden" name="catalog_status" value="Available"/>
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


<!---------------->
<!---- END BODY -->
<!---------------->

<?php
include_once 'includes/footer.php';
?>

<script>
$(document).ready(function() {
    setInterval(() => {
        $('.renderrfidcode').load('rfid/codeForRegister.php').fadeIn("fast");
    }, 500);
});

$(document).ready(function() {
    $('.myDataTable').DataTable({
        "order": [
            [2, 'asc']
        ]
    });

});
</script>