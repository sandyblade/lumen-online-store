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

class ProductInventory extends Model
{
    protected $table = "products_inventories";

    protected $fillable = [
        "product_id",
        "size_id",
        "color_id",
        "stock",
        "status"
    ];

    public function Product() {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function Size() {
        return $this->belongsTo(Size::class, 'size_id');
    }

    public function Colour() {
        return $this->belongsTo(Colour::class, 'color_id');
    }

    public function OrderDetail() {
        return $this->hasMany(OrderDetail::class);
    }


}
