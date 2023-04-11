
<?php


include_once "../../includes/conn.php";

$sql = 'SELECT * FROM transaction_table as tt, borrower_table as bt, catalog_table as ct
WHERE tt.borrower_id = bt.borrower_id AND ct.book_id = tt.book_id AND tt.transaction_status = "Returned"
';
$statement = $pdo->prepare($sql);
$statement->execute();
$transactions = $statement->fetchAll();



date_default_timezone_set("Asia/Hong_Kong");
$filename = "returned_transactions_" . date('Y-m-d') . ".xls"; 
    
header('Content-Type: application/xls');
header('Content-Disposition:attachment; filename='.$filename);

?>
<table>
    <tr>
        <th style="border: 1px solid black;">No.</th>
        <th style="border: 1px solid black;">Transaction ID</th>
        <th style="border: 1px solid black;">Borrower ID</th>
        <th style="border: 1px solid black;">Borrower Email</th>
        <th style="border: 1px solid black;">Book ID</th>
        <th style="border: 1px solid black;">Catalog Number</th>
        <th style="border: 1px solid black;">Book Title</th>
        <th style="border: 1px solid black;">Borrow Date</th>
        <th style="border: 1px solid black;">Due Date</th>
        <th style="border: 1px solid black;">Date Returned</th>
        <th style="border: 1px solid black;">Days Lapse</th>
        <th style="border: 1px solid black;">Transaction Status</th>
        <th style="border: 1px solid black;">Penalty</th>
        <th style="border: 1px solid black;">Paid</th>
        
    </tr>
    <?php
    $num_row = 1;
    foreach($transactions as $transaction){
        echo '
            <tr>
                <td style="border: 1px solid black;">'.$num_row.' </td>
                <td style="border: 1px solid black;">'.$transaction['transaction_id'].'</td>
                <td style="border: 1px solid black;">'.$transaction['borrower_id'].'</td>
                <td style="border: 1px solid black;">'.$transaction['borrower_email'].'</td>
                <td style="border: 1px solid black;">'.$transaction['book_id'].'</td>
                <td style="border: 1px solid black;">'.$transaction['catalog_number'].'</td>
                <td style="border: 1px solid black;">'.$transaction['catalog_book_title'].'</td>
                <td style="border: 1px solid black;">'.strval($transaction['transaction_borrow_datetime']).'</td>
                <td style="border: 1px solid black;">'.strval($transaction['transaction_due_datetime']).'</td>
                <td style="border: 1px solid black;">'.strval($transaction['transaction_datetime_return']).'</td>
                <td style="border: 1px solid black;">'.strval($transaction['transaction_datetime_lapse']).'</td>
                <td style="border: 1px solid black;">'.$transaction['transaction_status'].'</td>
                <td style="border: 1px solid black;">'.$transaction['transaction_penalty'].'</td>
                <td style="border: 1px solid black;">'.$transaction['transaction_paid'].'</td>
            </tr>
        ';
        $num_row++;
    }
    ?>
</table>

<?php

exit();
?>



