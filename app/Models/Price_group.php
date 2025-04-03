<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price_group extends Model
{
    use HasFactory;

    protected $table = 'price_group';

    protected $fillable = [
        "name",
        "shipping",
        "exchange_rate",
        "user_id"
    ];

    public function details()
    {
        return $this->hasMany(Price_group_deatil::class, 'price_group_id', 'id');
    }
}
