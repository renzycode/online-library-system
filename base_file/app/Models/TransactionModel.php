<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionModel extends Model{
    use HasFactory;
    protected $table='transaction_table';
    protected $primaryKey='transaction_id';
    protected $fillable = [
        'book_id',
        'borrower_id',
        'transaction_borrow_datetime',
        'transaction_return_datetime',
    ];
    public $timestamps = false;
}