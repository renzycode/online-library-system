
<?php


include_once "../../includes/conn.php";

$sql = 'SELECT * FROM borrower_table WHERE borrower_status = "accepted"';
$statement = $pdo->prepare($sql);
$statement->execute();
$acceptedborrowers = $statement->fetchAll();

date_default_timezone_set("Asia/Hong_Kong");
$filename = "accepted_borrowers_" . date('Y-m-d') . ".xls"; 

header('Content-Type: application/xls');
header('Content-Disposition:attachment; filename='.$filename);


    
?>
<table>
    <tr>
        <th style="border: 1px solid black;">No.</th>
        <th style="border: 1px solid black;">Borrower ID</th>
        <th style="border: 1px solid black;">First Name</th>
        <th style="border: 1px solid black;">Last Name</th>
        <th style="border: 1px solid black;">Address</th>
        <th style="border: 1px solid black;">Contact</th>
        <th style="border: 1px solid black;">Email</th>
        <th style="border: 1px solid black;">Status</th>
    </tr>
    <?php
    $num_row = 1;
    foreach($acceptedborrowers as $acceptedborrower){
        echo '
            <tr>
                <td style="border: 1px solid black;">'.$num_row.' </td>
                <td style="border: 1px solid black;">'.$acceptedborrower['borrower_id'].'</td>
                <td style="border: 1px solid black;">'.$acceptedborrower['borrower_fname'].'</td>
                <td style="border: 1px solid black;">'.$acceptedborrower['borrower_lname'].'</td>
                <td style="border: 1px solid black;">'.$acceptedborrower['borrower_address'].'</td>
                <td style="border: 1px solid black;">'.$acceptedborrower['borrower_contact'].'</td>
                <td style="border: 1px solid black;">'.$acceptedborrower['borrower_email'].'</td>
                <td style="border: 1px solid black;">'.$acceptedborrower['borrower_status'].'</td>
            </tr>
        ';
        $num_row++;
    }
    ?>
</table>

<?php


exit();
?>



