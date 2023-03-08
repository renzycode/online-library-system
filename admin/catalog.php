<?php
$active = 'catalog';
include_once 'includes/header.php';

include_once "../includes/conn.php";
include_once "../includes/functions.php";


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
        <span class="page-title">Catalog</span>
        <hr>
        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modalAdd">
            Add
        </button>
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="">
            Download Report
        </button>
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="">
            Clear Catalog
        </button>
    </h2>

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
                        <input type="hidden" name="librarian_id" value="{!! $librarian_id .'">
                        <div class="form-group col-6 mb-0">
                            <label class="col-form-label">Catalog Number
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="catalog_number" class="form-control border-dark border" required/>
                        </div>
                        <div class="form-group col-6 mb-0">
                            <label class="col-form-label">Book Title
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="catalog_book_title" class="form-control border-dark border" required/>
                        </div>
                        <div class="form-group col-6 mb-0">
                            <label class="col-form-label">Author
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="catalog_author" class="form-control border-dark border" required/>
                        </div>
                        <div class="form-group col-6 mb-0">
                            <label class="col-form-label">Publisher
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="catalog_publisher" class="form-control border-dark border" required/>
                        </div>
                        <div class="form-group col-6 mb-0">
                            <label class="col-form-label">Year
                                <span class="text-danger">*</span>
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
            </div>
            </form>
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
            <table class="table table-bordered border-secondary">
                <thead class="border">
                    <tr>
                        <th scope="col">No.</th>
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
                            <td>'.$number.'</td>
                            <td>'.$catalog['catalog_number'].'</td>
                            <td>'.$catalog['catalog_book_title'].'</td>
                            <td>'.$catalog['catalog_author'].'</td>
                            <td>'.$catalog['catalog_publisher'].'</td>
                            <td>'.$catalog['catalog_year'].'</td>
                            <td>'.$catalog['catalog_date_received'].'</td>
                            <td>'.$catalog['catalog_class'].'</td>
                            <td>'.$catalog['catalog_edition'].'</td>
                            <td>'.$catalog['catalog_volumes'].'</td>
                            <td>'.$catalog['catalog_pages'].'</td>
                            <td>'.$catalog['catalog_source_of_fund'].'</td>
                            <td>'.$catalog['catalog_cost_price'].'</td>
                            <td>'.$catalog['catalog_location_symbol'].'</td>
                            <td>'.$catalog['catalog_class_number'].'</td>
                            <td>'.$catalog['catalog_author_number'].'</td>
                            <td>'.$catalog['catalog_copyright_date'].'</td>
                            <td>';
                            if($catalog["catalog_status"]=="Available"){
                                echo '
                                <td>
                                    <span class="text-success">
                                        <i class="bi bi-check-circle-fill"></i>
                                    </span>
                                    '.$catalog["catalog_status"].' 
                                </td>';
                            }else{
                                echo '
                                <td>
                                    <span class="text-danger">
                                        <i class="bi bi-x-circle-fill"></i>
                                    </span>
                                    '.$catalog["catalog_status"].' 
                                </td>';
                            }
                            echo '
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
                                            <form action="api/edit_catalog.php" method="post">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Edit Catalog</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body row">
                                                    <input type="hidden" name="catalog_id" value="'.$catalog['catalog_id'].'">
                                                    <div class="form-group col-6 mb-0">
                                                        <label class="col-form-label">Catalog Number
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <input type="text" name="catalog_number"
                                                            class="form-control border-dark border" value="'.$catalog['catalog_number'].'" required/>
                                                    </div>
                                                    <div class="form-group col-6 mb-0">
                                                        <label class="col-form-label">Book Title
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <input type="text" name="catalog_book_title"
                                                            class="form-control border-dark border" value="'.$catalog['catalog_book_title'].'" required/>
                                                    </div>
                                                    <div class="form-group col-6 mb-0">
                                                        <label class="col-form-label">Author
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <input type="text" name="catalog_author"
                                                            class="form-control border-dark border" value="'.$catalog['catalog_author'].'" required/>
                                                    </div>
                                                    <div class="form-group col-6 mb-0">
                                                        <label class="col-form-label">Publisher
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <input type="text" name="catalog_publisher"
                                                            class="form-control border-dark border" value="'.$catalog['catalog_publisher'].'" required/>
                                                    </div>
                                                    <div class="form-group col-6 mb-0">
                                                        <label class="col-form-label">Year
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <input type="text" name="catalog_year"
                                                            class="form-control border-dark border" value="'.$catalog['catalog_year'].'" required/>
                                                    </div>
                                                    <div class="form-group col-6 mb-0">
                                                        <label class="col-form-label">Date Received</label>
                                                        <input type="text" name="catalog_date_received"
                                                            class="form-control border-dark border" />
                                                    </div>
                                                    <div class="form-group col-6 mb-0">
                                                        <label class="col-form-label">Class</label>
                                                        <input type="text" name="catalog_class"
                                                            class="form-control border-dark border" />
                                                    </div>
                                                    <div class="form-group col-6 mb-0">
                                                        <label class="col-form-label">Edition</label>
                                                        <input type="text" name="catalog_edition"
                                                            class="form-control border-dark border" />
                                                    </div>
                                                    <div class="form-group col-6 mb-0">
                                                        <label class="col-form-label">Volumes</label>
                                                        <input type="text" name="catalog_volumes"
                                                            class="form-control border-dark border" />
                                                    </div>
                                                    <div class="form-group col-6 mb-0">
                                                        <label class="col-form-label">Pages</label>
                                                        <input type="text" name="catalog_pages"
                                                            class="form-control border-dark border" />
                                                    </div>
                                                    <div class="form-group col-6 mb-0">
                                                        <label class="col-form-label">Source of Fund</label>
                                                        <input type="text" name="catalog_source_of_fund"
                                                            class="form-control border-dark border" />
                                                    </div>
                                                    <div class="form-group col-6 mb-0">
                                                        <label class="col-form-label">Cost Price</label>
                                                        <input type="text" name="catalog_cost_price"
                                                            class="form-control border-dark border" />
                                                    </div>
                                                    <div class="form-group col-6 mb-0">
                                                        <label class="col-form-label">Location Symbol</label>
                                                        <input type="text" name="catalog_location_symbol"
                                                            class="form-control border-dark border" />
                                                    </div>
                                                    <div class="form-group col-6 mb-0">
                                                        <label class="col-form-label">Class Number</label>
                                                        <input type="text" name="catalog_class_number"
                                                            class="form-control border-dark border" />
                                                    </div>
                                                    <div class="form-group col-6 mb-0">
                                                        <label class="col-form-label">Author Number</label>
                                                        <input type="text" name="catalog_author_number"
                                                            class="form-control border-dark border" />
                                                    </div>
                                                    <div class="form-group col-6 mb-0">
                                                        <label class="col-form-label">Copyright Date</label>
                                                        <input type="text" name="catalog_copyright_date"
                                                            class="form-control border-dark border" />
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
                            <td>
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#modalDelete'.$number.'">
                                    <i class="bi-trash"></i>
                                </button>
                                <!-- delete modal -->
                                <div class="modal fade" id="modalDelete'.$number.'" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="" method="post">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Delete Catalog</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure you want to delete this catalog?
                                                </div>
                                                <input type="hidden" name="catalog_id" value="'.$catalog['catalog_id'].'">
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-success">Yes</button>
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