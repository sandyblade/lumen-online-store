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

class Order extends Model
{
    protected $table = "orders";

    protected $fillable = [
        "user_id",
        "payment_id",
        "invoice_number",
        "total_item",
        "subtotal",
        "total_taxes",
        "total_shipment",
        "total_paid",
        "status"
    ];

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function Payment()
    {
        return $this->belongsTo(Payment::class, 'payment_id');
    }

    public function OrderDetail()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function OrderBilling()
    {
        return $this->hasMany(OrderBilling::class);
    }

    public function Carts()
    {
        return $this->belongsToMany(Product::class, "orders_carts");
    }
}
