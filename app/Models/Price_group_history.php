<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price_group_history extends Model
{
    use HasFactory;
    protected $table = 'price_group_history';

    protected $fillable = [
        "name",
        "shipping",
        "exchange_rate",
        "user_id",
        "price_group_id"
    ];
    public $timestamps = false;

    public function details()
    {
        return $this->hasMany(Price_group_history_deatil::class, 'price_group_id', 'id');
    }
}
