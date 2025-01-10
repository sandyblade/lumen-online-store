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

class OrderDetail extends Model
{
    protected $table = "orders_details";

    protected $fillable = [
        "order_id",
        "product_inventory_id",
        "price",
        "qty",
        "total",
        "status"
    ];

    public function Order() {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function ProductInventory() {
        return $this->belongsTo(ProductInventory::class, 'product_inventory_id');
    }


}
