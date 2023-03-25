<?php

include_once "../../includes/conn.php";
include_once "../../includes/functions.php";

    //for registration
	$rfidCode=$_POST["rfidCode"];


	$Write1='
	<input name="rfid_code" value="'.$rfidCode.'" >
	';
	file_put_contents('codeForRegister.php', $Write1);




    //for scan
	$sql = "SELECT * FROM catalog_table WHERE rfid_code = ?";
	$statement = $pdo->prepare($sql);
	$statement->execute(array($rfidCode));
	$fetched = $statement->fetch();

	if($fetched['rfid_code']==$rfidCode){
		$Write2='
		<div class="form-group mt-3">
			<span class="alert alert-success py-3">
				Registered
			</span>
		</div>

		<div class="form-group mb-1">
			<label class="col-form-label">RFID Code</label>
			<input type="text" class="form-control w-50" value="'.$rfidCode.'">
		</div>

		<div class="form-group mb-1">
			<label class="col-form-label">Book ID</label>
			<input type="text" class="form-control w-50" id="bookid" value="'.$fetched['book_id'].'">
		</div>

		<div class="form-group mb-1">
			<label class="col-form-label">Book Title</label>
			<input type="text" class="form-control w-50" value="'.$fetched['catalog_book_title'].'">
		</div>
		';
	}else{
		$Write2='
		<div class="form-group mt-3">
			<span class="alert alert-danger py-3">
				Not Registered
			</span>
		</div>

		<div class="form-group mb-1">
			<label class="col-form-label">RFID Code</label>
			<input type="text" class="form-control w-50" value="'.$rfidCode.'">
		</div>

		<div class="form-group mb-1">
			<label class="col-form-label">Book ID</label>
			<input type="text" class="form-control w-50" value="------">
		</div>

		<div class="form-group mb-1">
			<label class="col-form-label">Book Title</label>
			<input type="text" class="form-control w-50" value="------">
		</div>
		';
	}

	
	file_put_contents('codeForScan.php', $Write2);