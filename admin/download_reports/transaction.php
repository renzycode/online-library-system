
<?php


include_once "../../includes/conn.php";

$sql = 'SELECT * FROM transaction_table ';
$statement = $pdo->prepare($sql);
$statement->execute();
$transactions = $statement->fetchAll();



date_default_timezone_set("Asia/Hong_Kong");
$delimiter = ","; 
$filename = "transactions_" . date('Y-m-d') . ".csv"; 
    
// Create a file pointer 
$f = fopen('php://memory', 'w'); 
    
// Set column headers 
$fields = array(
    'No.',
    'Transaction ID',
    'Book ID 1',
    'Book ID 2',
    'Book ID 3',
    'Book ID 4',
    'Book ID 5',
    'Borrower ID',
    'Borrow Date & Time',
    'Return Date & Time',
    'Transaction Status'); 
fputcsv($f, $fields, $delimiter); 
    
// Output each row of the data, format line as csv and write to file pointer 
    
$number = 0;
foreach ($transactions as $transaction){
    $number++;
    $lineData = array(
        $number,
        $transaction['transaction_id'],
        $transaction['book_id_1'],
        $transaction['book_id_2'],
        $transaction['book_id_3'],
        $transaction['book_id_4'],
        $transaction['book_id_5'],
        $transaction['borrower_id'],
        $transaction['transaction_borrow_datetime'],
        $transaction['transaction_return_datetime'],
        $transaction['transaction_status'],
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
