<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartOrderDetail extends Model
{
    use HasFactory;

    protected $table = 'cart_order_details';

    public $timestamps = true;

    protected $fillable = [
        'cart_order_id',
        'product_id',
        'product_variant_id',
        'unit_price',
        'quantity',
        'created_at',
        'updated_at',
    ];

    public function order()
    {
        return $this->belongsTo(CartOrders::class, 'cart_order_id', 'id');
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
