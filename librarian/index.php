<?php

session_start();

$active = 'dashboard';
include_once "../includes/conn.php";
include_once "../includes/functions.php";

//redirectURL('borrower.php');

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

//sql for select all borrowers with pending status
$sql = 'SELECT * FROM borrower_table WHERE borrower_status = "pending"';
$statement = $pdo->prepare($sql);
$statement->execute();
$pending_borrowers = count($statement->fetchAll());

//sql for select all borrowers with accepted status
$sql = 'SELECT * FROM borrower_table WHERE borrower_status = "accepted"';
$statement = $pdo->prepare($sql);
$statement->execute();
$accepted_borrowers = count($statement->fetchAll());

//sql for select all borrowers with rejected status
$sql = 'SELECT * FROM borrower_table WHERE borrower_status = "rejected"';
$statement = $pdo->prepare($sql);
$statement->execute();
$rejected_borrowers = count($statement->fetchAll());

//sql for select all books
$sql = 'SELECT * FROM catalog_table';
$statement = $pdo->prepare($sql);
$statement->execute();
$books = count($statement->fetchAll());

//sql for select all available books
$sql = 'SELECT * FROM catalog_table WHERE catalog_status = "Available"';
$statement = $pdo->prepare($sql);
$statement->execute();
$available_books = count($statement->fetchAll());

//sql for select all unavailable books
$sql = 'SELECT * FROM catalog_table WHERE catalog_status = "Unvailable"';
$statement = $pdo->prepare($sql);
$statement->execute();
$unavailable_books = count($statement->fetchAll());

$sql = 'SELECT * FROM transaction_table WHERE transaction_status = "On Borrow"';
$statement = $pdo->prepare($sql);
$statement->execute();
$on_borrow_books = count($statement->fetchAll());

$sql = 'SELECT * FROM transaction_table WHERE transaction_status = "Returned"';
$statement = $pdo->prepare($sql);
$statement->execute();
$returned_books = count($statement->fetchAll());

?>

<!---------------->
<!-- START BODY -->
<!---------------->


<!-- Content Row -->
<div class="row">

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-6 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100">
            <a href="borrower.php?borrower=pending" class="text-decoration-none">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col-10 d-flex justify-content-center row">
                            <div class="ml-4">
                                <div class="col-12 font-weight-bold text-primary text-uppercase mb-1"
                                    style="font-size: 1.3rem !important;">Pending Borrowers</div>
                                <div class="col-12 font-weight-bold text-gray-800" style="font-size: 1.2rem !important;"><?php echo $pending_borrowers ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-2 d-flex justify-content-center">
                            <i class="bi bi-person-fill-exclamation text-primary text-center"
                                style="font-size: 4rem !important;"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-6 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100">
            <a href="borrower.php?borrower=accepted" class="text-decoration-none">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col-10 d-flex justify-content-center row">
                            <div class="ml-4">
                                <div class="col-12 font-weight-bold text-success text-uppercase mb-1"
                                    style="font-size: 1.3rem !important;">Accepted Borrowers</div>
                                <div class="col-12 font-weight-bold text-gray-800" style="font-size: 1.2rem !important;"><?php echo $accepted_borrowers ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-2 d-flex justify-content-center">
                            <i class="bi bi-person-fill-check text-success text-center"
                                style="font-size: 4rem !important;"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example
    <div class="col-xl-6 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100">
            <a href="borrower.php?borrower=rejected" class="text-decoration-none">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col-10 d-flex justify-content-center row">
                            <div class="ml-4">
                                <div class="col-12 font-weight-bold text-danger text-uppercase mb-1"
                                    style="font-size: 1.3rem !important;">Rejected Borrowers</div>
                                <div class="col-12 font-weight-bold text-gray-800" style="font-size: 1.2rem !important;"><?php echo $rejected_borrowers ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-2 d-flex justify-content-center">
                            <i class="bi bi-person-fill-x text-danger text-center" style="font-size: 4rem !important;"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div-->

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-6 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100">
            <a href="catalog.php" class="text-decoration-none">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col-10 d-flex justify-content-center row">
                            <div class="ml-4">
                                <div class="col-12 font-weight-bold text-info text-uppercase mb-1"
                                    style="font-size: 1.3rem !important;">All Books</div>
                                <div class="col-12 font-weight-bold text-gray-800" style="font-size: 1.2rem !important;"><?php echo $books ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-2 d-flex justify-content-center">
                            <i class="bi bi-book-half text-info text-center" style="font-size: 4rem !important;"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-6 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100">
            <a href="transaction_table.php?transaction=returned" class="text-decoration-none">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col-10 d-flex justify-content-center row">
                            <div class="ml-4">
                                <div class="col-12 font-weight-bold text-warning text-uppercase mb-1"
                                    style="font-size: 1.3rem !important;">Returned Books</div>
                                <div class="col-12 font-weight-bold text-gray-800" style="font-size: 1.2rem !important;"><?php echo $returned_books ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-2 d-flex justify-content-center">
                            <i class="bi bi-journal-check text-warning text-center" style="font-size: 4rem !important;"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-6 col-md-6 mb-4">
        <div class="card border-left-secondary shadow h-100">
            <a href="transaction_table.php?transaction=on borrow" class="text-decoration-none">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col-10 d-flex justify-content-center row">
                            <div class="ml-4">
                                <div class="col-12 font-weight-bold text-secondary text-uppercase mb-1"
                                    style="font-size: 1.3rem !important;">On Borrow Books</div>
                                <div class="col-12 font-weight-bold text-gray-800" style="font-size: 1.2rem !important;"><?php echo $on_borrow_books ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-2 d-flex justify-content-center">
                            <i class="bi bi-journal-x text-secondary text-center" style="font-size: 4rem !important;"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

</div>

<!-- Content Row 
<div class="row">

    <div class="col-lg-12 col-xl-6 col-md-12 col-sm-12">

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Projects</h6>
            </div>
            <div class="card-body">
                <h4 class="small font-weight-bold">Server Migration <span class="float-right">20%</span></h4>
                <div class="progress mb-4">
                    <div class="progress-bar bg-danger" role="progressbar" style="width: 20%" aria-valuenow="20"
                        aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <h4 class="small font-weight-bold">Sales Tracking <span class="float-right">40%</span></h4>
                <div class="progress mb-4">
                    <div class="progress-bar bg-warning" role="progressbar" style="width: 40%" aria-valuenow="40"
                        aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <h4 class="small font-weight-bold">Customer Database <span class="float-right">60%</span></h4>
                <div class="progress mb-4">
                    <div class="progress-bar" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0"
                        aria-valuemax="100"></div>
                </div>
                <h4 class="small font-weight-bold">Payout Details <span class="float-right">80%</span></h4>
                <div class="progress mb-4">
                    <div class="progress-bar bg-info" role="progressbar" style="width: 80%" aria-valuenow="80"
                        aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <h4 class="small font-weight-bold">Account Setup <span class="float-right">Complete!</span></h4>
                <div class="progress">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100"
                        aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>

    </div>

    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-6 mb-4">
                <a class="card bg-primary text-white shadow nav-link" type=button>
                    <div class="card-body">
                        <h1 class="mb-0" >You have 30 Pending Borrowers !!</h1>
                        <div class="text-white-50 small">Take Action</div>
                    </div>
                </a>
            </div>
            <div class="col-lg-6 mb-4">
                    <div class="card bg-success text-white shadow">
                        <div class="card-body">
                            Success
                            <div class="text-white-50 small">#1cc88a</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="card bg-info text-white shadow">
                        <div class="card-body">
                            Info
                            <div class="text-white-50 small">#36b9cc</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="card bg-warning text-white shadow">
                        <div class="card-body">
                            Warning
                            <div class="text-white-50 small">#f6c23e</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="card bg-danger text-white shadow">
                        <div class="card-body">
                            Danger
                            <div class="text-white-50 small">#e74a3b</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="card bg-secondary text-white shadow">
                        <div class="card-body">
                            Secondary
                            <div class="text-white-50 small">#858796</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="card bg-light text-black shadow">
                        <div class="card-body">
                            Light
                            <div class="text-black-50 small">#f8f9fc</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="card bg-dark text-white shadow">
                        <div class="card-body">
                            Dark
                            <div class="text-white-50 small">#5a5c69</div>
                        </div>
                    </div>
                </div>

        </div>
    </div>

</div-->


<!---------------->
<!---- END BODY -->
<!---------------->

<?php

include_once 'includes/footer.php';

?>