<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatalogModel extends Model{
    use HasFactory;
    protected $table='catalog_table';
    protected $primaryKey='catalog_id';
    protected $fillable = [
        'librarian_id',
        'catalog_number',
        'catalog_book_title',
        'catalog_author',
        'catalog_publisher',
        'catalog_year',
        'catalog_date_received',
        'catalog_class',
        'catalog_edition',
        'catalog_volumes',
        'catalog_pages',
        'catalog_source_of_fund',
        'catalog_cost_price',
        'catalog_location_symbol',
        'catalog_class_number',
        'catalog_author_number',
        'catalog_copyright_date',
        'catalog_status',
    ];
    public $timestamps = false;
}