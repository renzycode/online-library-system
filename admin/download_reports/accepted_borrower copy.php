
<?php

date_default_timezone_set("Asia/Hong_Kong");
$time = date("h:i:sa");
$date = date("Y-m-d");
$filename = 'Accepted_Borrowers';
header('Content-Type: application/xls');
header('Content-Disposition:attachment; filename='.$filename.'_'.$date.'_Time_'.$time.'.xls');


include_once "../../includes/conn.php";

$sql = 'SELECT * FROM borrower_table WHERE borrower_status="accepted"; ';
$statement = $pdo->prepare($sql);
$statement->execute();
$accepted_borrowers = $statement->fetchAll();

echo '
    <table>
        <thead>
            <tr>
                <th scope="col" style="border: 1px solid black;">No.</th>
                <th scope="col" style="border: 1px solid black;">Borrower Id</th>
                <th scope="col" style="border: 1px solid black;">First Name</th>
                <th scope="col" style="border: 1px solid black;">Last Name</th>
                <th scope="col" style="border: 1px solid black;">Address</th>
                <th scope="col" style="border: 1px solid black;">Contact</th>
                <th scope="col" style="border: 1px solid black;">Email</th>
                <th scope="col" style="border: 1px solid black;">Borrower Image</th>
            </tr>
        </thead>
        <tbody class="border">
        ';
        $number = 0;
            foreach ($accepted_borrowers as $accepted){
                $number++;
                echo '
                <tr>
                    <td style="border: 1px solid black;">'.$number.'</td>
                    <td style="border: 1px solid black;">'.$accepted['borrower_id'].'</td>
                    <td style="border: 1px solid black;">'.$accepted['borrower_fname'].'</td>
                    <td style="border: 1px solid black;">'.$accepted['borrower_lname'].'</td>
                    <td style="border: 1px solid black;">'.$accepted['borrower_address'].'</td>
                    <td style="border: 1px solid black;">'.$accepted['borrower_contact'].'</td>
                    <td style="border: 1px solid black;">'.$accepted['borrower_email'].'</td>
                    <td style="border: 1px solid black;">'.$accepted['borrower_id_image_name'].'</td>
                </tr>
                ';
            }
        echo '
        </tbody>
    </table>
';

?>
