<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductBrandLanguage extends Model
{
    use HasFactory;
    protected $table='product_brand_language';
    protected $fillable = [
        'language_id',
        'name',
        'description',
        'content',
        'meta_title',
        'meta_keyword',
        'meta_description',
        'product_brand_id'
    ];
}
