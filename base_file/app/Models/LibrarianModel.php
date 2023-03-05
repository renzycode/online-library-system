<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibrarianModel extends Model{
    use HasFactory;
    protected $table='librarian_table';
    protected $primaryKey='librarian_id';
    protected $fillable = [
        'librarian_uname',
        'librarian_pass'
    ];
    public $timestamps = false;
}