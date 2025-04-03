<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductBrand extends Model
{
    use HasFactory;
    protected $table = 'product_brands';
    public $timestamps = true;
    protected $fillable = [
        'image',
        'publish',
        'user_id',
    ];
    public function brand_language(){
        return $this->belongsTo(ProductBrandLanguage::class,'id','product_brand_id');
    }
}
