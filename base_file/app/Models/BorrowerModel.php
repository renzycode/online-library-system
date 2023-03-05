<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BorrowerModel extends Model{
    use HasFactory;
    protected $table='borrower_table';
    protected $primaryKey='borrower_id';
    protected $fillable = [
        'borrower_fname',
        'borrower_lname',
        'borrower_address',
        'borrower_contact',
        'borrower_email',
        'borrower_id_image_name',
        'borrower_status'
    ];
    public $timestamps = false;
}