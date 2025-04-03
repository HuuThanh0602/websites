<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartDetail extends Model
{
    use HasFactory;

    protected $table = "cart_details";
    protected $fillable = ['cart_id', 'product_id', 'product_variant_id', 'unit_price', 'quantity'];
    protected $primaryKey = 'cart_id'; // Nếu khóa chính là cart_id
    public $incrementing = false;
    protected $keyType = 'int';
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function product_name()
    {
        return $this->belongsTo(Product_language::class, 'product_id', 'product_id');
    }


    public function variant()
    {
        return $this->belongsTo(ProductVariantLanguage::class, 'product_variant_id');
    }
}
