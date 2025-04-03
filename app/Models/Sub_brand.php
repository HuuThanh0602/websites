<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sub_brand extends Model
{
    use HasFactory;
    protected $table = 'sub_brands';
    protected $fillable = [
        'brand_id',
        'name',
    ];
    public $timestamps = false;

    // Thiết lập quan hệ với bảng Price
    public function prices()
    {
        return $this->hasMany(Price_range::class, 'sub_brand_id', 'id');
    }
}
