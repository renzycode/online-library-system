<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookModel extends Model{
    use HasFactory;
    protected $table='book_table';
    protected $primaryKey='book_id';
    protected $fillable = [
        'catalog_id',
        'book_status'
    ];
    public $timestamps = false;
}