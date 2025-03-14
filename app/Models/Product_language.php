<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_language extends Model
{
    use HasFactory;
    protected $fillable = ['name'];
    protected $table = 'product_language';
}
