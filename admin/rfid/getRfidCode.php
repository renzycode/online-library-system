<?php

    //for registration
	$rfidCode=$_POST["rfidCode"];
	$Write1='
	<input name="rfid_code" value="'.$rfidCode.'" >
	';
	file_put_contents('codeForRegister.php', $Write1);




    //for scan
    $rfidCode=$_POST["rfidCode"];
	$Write2='
	<h1> '.$rfidCode.' </h1>
	';
	file_put_contents('codeForScan.php', $Write2);