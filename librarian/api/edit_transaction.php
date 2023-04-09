<?php

include_once "../../includes/conn.php";
include_once "../../includes/functions.php";

try {
    if(isset($_POST['edit_transaction'])){




        if($_POST['transaction_id']=='----------'){
            redirectURL('../return_book.php?return=error&id=empty');
            exit();
        }

        $sql = 'SELECT * FROM transaction_table
        WHERE transaction_id = ? ';
        $statement = $pdo->prepare($sql);
        $params=array(
            $_POST['transaction_id']
        );
        $statement->execute($params);
        $result = $statement->fetch();



        $string = '';
        date_default_timezone_set("Asia/Hong_Kong");

        $dueDateTime = strtotime($result['transaction_due_datetime']);
        
        $dueDateTimeConverted = date("Y-m-d H:i", $dueDateTime);
        $currentDateTimeConverted = date("Y-m-d H:i");
        
        $due_date_time=strtotime($dueDateTimeConverted);
        $current_date_time=strtotime($currentDateTimeConverted);
        
        $difference=$current_date_time-$due_date_time;
        
        $hours=($difference / 3600);
        $minutes=($difference / 60 % 60);
        $seconds=($difference % 60);
        $days=($hours/24);
        $hours=($hours % 24);
        

        if(floor($days)==1 || floor($days)==-1){
            $string = floor($days). " day & ";
        }else{
            $string = floor($days). " days & ";
        }
        
    
        $hour = sprintf("%02d",$hours);
        if($hour==1){
            $string = $string.$hour." hour";
        }else{
            $string = $string.$hour." hours";
        }

        if(floor($days)>0){
            $penalty = floor($days)*10;
            $paid = "No";
        }else{
            $penalty = "----";
            $paid = "----";
        }

        $currentDateTime = date("Y-m-d h:i a");



        $sql = 'UPDATE transaction_table SET 
        transaction_status = ? , transaction_datetime_return = ? , transaction_datetime_lapse = ?, transaction_penalty = ?, transaction_paid = ?
        WHERE transaction_id = ? ';
        $statement = $pdo->prepare($sql);
        $params=array(
            'Returned',
            $currentDateTime,
            $string,
            $penalty,
            $paid,
            $_POST['transaction_id']
        );

        if($statement->execute($params)){

            $sql = 'SELECT * FROM transaction_table
            WHERE transaction_id = ? ';
            $statement = $pdo->prepare($sql);
            $params=array(
                $_POST['transaction_id']
            );
            $statement->execute($params);
            $result = $statement->fetch();
            $sql = 'UPDATE catalog_table SET 
            catalog_status = "Available"
            WHERE book_id = ?';
            $statement = $pdo->prepare($sql);
            $statement->execute(array($result['book_id']));
        }

        


        redirectURL('../return_book.php?return=success');
        exit();
    }else{
        printInConsole('return error!');
        redirectURL('../return_book.php?return=error');
        exit();
    }
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage();
}
