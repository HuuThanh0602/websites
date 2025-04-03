<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartOrders extends Model
{
    use HasFactory;

    // Tên bảng trong cơ sở dữ liệu
    protected $table = 'cart_orders';

    // Cho phép Eloquent tự động quản lý timestamps
    public $timestamps = true;

    // Các trường có thể gán dữ liệu hàng loạt (Mass Assignment)
    protected $fillable = [
        'customer_id',
        'created_at',
        'updated_at',
    ];

    // Mối quan hệ với `CartOrderDetails`
    public function details()
    {
        return $this->hasMany(CartOrderDetail::class, 'cart_order_id', 'id');
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
