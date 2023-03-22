
<?php


include_once "../../includes/conn.php";

$sql = 'SELECT * FROM catalog_table ';
$statement = $pdo->prepare($sql);
$statement->execute();
$catalogs = $statement->fetchAll();



date_default_timezone_set("Asia/Hong_Kong");
$delimiter = ","; 
$filename = "catalog_" . date('Y-m-d') . ".csv"; 
    
// Create a file pointer 
$f = fopen('php://memory', 'w'); 
    
// Set column headers 
$fields = array(
    '#',
    'Catalog ID',
    'Catalog Number',
    'Book Title',
    'Author',
    'Publisher',
    'Year',
    'Date Received',
    'Class',
    'Edition',
    'Volumes',
    'Pages',
    'Source of Fund',
    'Cost Price',
    'Location Symbol',
    'Class Number',
    'Author Number',
    'Copyright Date',
    'Status'
);
fputcsv($f, $fields, $delimiter); 
    
// Output each row of the data, format line as csv and write to file pointer 
    
$number = 0;
foreach ($catalogs as $catalog){
    $number++;
    $lineData = array(
        $number,
        $catalog['book_id'],
        $catalog['catalog_number'],
        $catalog['catalog_book_title'],
        $catalog['catalog_author'],
        $catalog['catalog_publisher'],
        $catalog['catalog_year'],
        $catalog['catalog_date_received'],
        $catalog['catalog_class'],
        $catalog['catalog_edition'],
        $catalog['catalog_volumes'],
        $catalog['catalog_pages'],
        $catalog['catalog_source_of_fund'],
        $catalog['catalog_cost_price'],
        $catalog['catalog_location_symbol'],
        $catalog['catalog_class_number'],
        $catalog['catalog_author_number'],
        $catalog['catalog_copyright_date'],
        $catalog['catalog_status']
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
