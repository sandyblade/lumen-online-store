<?php

/**
* This file is part of the Sandy Andryanto Online Store Website.
*
* @author     Sandy Andryanto <sandy.andryanto.blade@gmail.com>
* @copyright  2025
*
* For the full copyright and license information,
* please view the LICENSE.md file that was distributed
* with this source code.
*/

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = "products";

    protected $fillable = [
        "brand_id",
        "sku",
        "name",
        "name",
        "price",
        "published_date",
        "description",
        "details"
    ];

    public function Brand() {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function ProductImage() {
        return $this->hasMany(ProductImage::class);
    }

    public function ProductInventory() {
        return $this->hasMany(ProductInventory::class);
    }

    public function ProductReview() {
        return $this->hasMany(ProductReview::class);
    }

    public function Categories() {
        return $this->belongsToMany(Category::class, "products_categories");
    }

}
