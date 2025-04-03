<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price_range extends Model
{
    use HasFactory;
    protected $table='price_ranges';
    protected $fillable = 
    [
    'name',
    'sub_brand_id',
    'value_type',
    'value',
    'price_min',
    'price_max',
    'updated_at',
    'created_at'
];

    public $timestamps = true; 
    public function brand()
    {
        return $this->hasOne(ProductCatalogueLanguage::class, 'product_catalogue_id','brand_id');
    }
}
