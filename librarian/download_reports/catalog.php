
<?php


include_once "../../includes/conn.php";

$sql = 'SELECT * FROM catalog_table';
$statement = $pdo->prepare($sql);
$statement->execute();
$catalogs = $statement->fetchAll();



date_default_timezone_set("Asia/Hong_Kong");
$filename = "catalogs_" . date('Y-m-d') . ".xls"; 
    


header('Content-Type: application/xls');
header('Content-Disposition:attachment; filename='.$filename);


?>
<table>
    <tr>
        <th style="border: 1px solid black;">No.</th>
        <th style="border: 1px solid black;">Book ID</th>
        <th style="border: 1px solid black;">RFID Code</th>
        <th style="border: 1px solid black;">Catalog Number</th>
        <th style="border: 1px solid black;">Book Title</th>
        <th style="border: 1px solid black;">Author</th>
        <th style="border: 1px solid black;">Publisher</th>
        <th style="border: 1px solid black;">Year</th>
        <th style="border: 1px solid black;">Date Received</th>
        <th style="border: 1px solid black;">Class</th>
        <th style="border: 1px solid black;">Edition</th>
        <th style="border: 1px solid black;">Volumes</th>
        <th style="border: 1px solid black;">Pages</th>
        <th style="border: 1px solid black;">Source of Fund</th>
        <th style="border: 1px solid black;">Cost Price</th>
        <th style="border: 1px solid black;">Location</th>
        <th style="border: 1px solid black;">Class Number</th>
        <th style="border: 1px solid black;">Author</th>
        <th style="border: 1px solid black;">Copyright Date</th>
        <th style="border: 1px solid black;">Status</th>
    </tr>
    <?php
    $num_row = 1;
    foreach($catalogs as $catalog){
        echo '
            <tr>
                <td style="border: 1px solid black;">'.$num_row.' </td>
                <td style="border: 1px solid black;">'.$catalog['book_id'].'</td>
                <td style="border: 1px solid black;">'.$catalog['rfid_code'].'</td>
                <td style="border: 1px solid black;">'.$catalog['catalog_number'].'</td>
                <td style="border: 1px solid black;">'.$catalog['catalog_book_title'].'</td>
                <td style="border: 1px solid black;">'.$catalog['catalog_author'].'</td>
                <td style="border: 1px solid black;">'.$catalog['catalog_publisher'].'</td>
                <td style="border: 1px solid black;">'.$catalog['catalog_year'].'</td>
                <td style="border: 1px solid black;">'.$catalog['catalog_date_received'].'</td>
                <td style="border: 1px solid black;">'.$catalog['catalog_class'].'</td>
                <td style="border: 1px solid black;">'.$catalog['catalog_edition'].'</td>
                <td style="border: 1px solid black;">'.$catalog['catalog_volumes'].'</td>
                <td style="border: 1px solid black;">'.$catalog['catalog_pages'].'</td>
                <td style="border: 1px solid black;">'.$catalog['catalog_source_of_fund'].'</td>
                <td style="border: 1px solid black;">'.$catalog['catalog_cost_price'].'</td>
                <td style="border: 1px solid black;">'.$catalog['catalog_location_symbol'].'</td>
                <td style="border: 1px solid black;">'.$catalog['catalog_class_number'].'</td>
                <td style="border: 1px solid black;">'.$catalog['catalog_author_number'].'</td>
                <td style="border: 1px solid black;">'.$catalog['catalog_copyright_date'].'</td>
                <td style="border: 1px solid black;">'.$catalog['catalog_status'].'</td>
            </tr>
        ';
        $num_row++;
    }
    ?>
</table>

<?php


exit();
?>

