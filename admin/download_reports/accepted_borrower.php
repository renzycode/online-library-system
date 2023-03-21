
<?php


include_once "../../includes/conn.php";

$sql = 'SELECT * FROM borrower_table WHERE borrower_status="accepted"; ';
$statement = $pdo->prepare($sql);
$statement->execute();
$accepted_borrowers = $statement->fetchAll();



date_default_timezone_set("Asia/Hong_Kong");
$delimiter = ","; 
$filename = "accepted-borrowers_" . date('Y-m-d') . ".csv"; 
    
// Create a file pointer 
$f = fopen('php://memory', 'w'); 
    
// Set column headers 
$fields = array(
    'No.',
    'Borrower Id',
    'First Name',
    'Last Name',
    'Address',
    'Contact',
    'Email',
    'Borrower Image Name'); 
fputcsv($f, $fields, $delimiter); 
    
// Output each row of the data, format line as csv and write to file pointer 
    
$number = 0;
foreach ($accepted_borrowers as $accepted){
    $number++;
    $lineData = array(
        $number,
        $accepted['borrower_id'],
        $accepted['borrower_fname'],
        $accepted['borrower_lname'],
        $accepted['borrower_address'],
        $accepted['borrower_contact'],
        $accepted['borrower_email'],
        $accepted['borrower_id_image_name']
    );
    fputcsv($f, $lineData, $delimiter);
}

// Move back to beginning of file 
fseek($f, 0); 
    
// Set headers to download file rather than displayed 
header('Content-Type: text/csv'); 
header('Content-Disposition: attachment; filename="' . $filename . '";'); 
    
//output all remaining data on a file pointer 
fpassthru($f); 
exit; 


?>
