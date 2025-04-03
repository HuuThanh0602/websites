<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Price_group_deatil extends Model
{
    protected $table = 'price_group_detail';

    protected $fillable = [
        "price_group_id",
        "product_brand_id",
        "sub_brand_id",
        "product_catalogue_id",
        "discount",
        "user_id",
    ];

    /**
     * Quan hệ với bảng price_group
     */
    public function priceGroup()
    {
        return $this->belongsTo(Price_group::class, 'price_group_id', 'id');
    }

    /**
     * Quan hệ với bảng product_catalogue_language cho product_catalogue_id
     */
    public function catalogue()
    {
        return $this->belongsTo(ProductCatalogueLanguage::class, 'product_catalogue_id', 'product_catalogue_id');
    }

    /**
     * Quan hệ với bảng product_brand (giả sử bảng là product_brands)
     */
    public function brand()
    {
        return $this->belongsTo(ProductBrand::class, 'product_brand_id', 'id');
    }

    /**
     * Quan hệ với bảng sub_brand (giả sử bảng là sub_brands)
     */
    public function subBrand()
    {
        return $this->belongsTo(Sub_brand::class, 'sub_brand_id', 'id');
    }
}
