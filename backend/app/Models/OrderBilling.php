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

class OrderBilling extends Model
{
    protected $table = "orders_billings";

    protected $fillable = [
        "order_id",
        "name",
        "description",
        "status"
    ];

    public function Order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public static function getByOrder($order_id)
    {
        $result = [];
        $data = self::where("order_id", "!=", $order_id)->orderBy("id", "desc")->get();
        foreach ($data as $row) {
            $result[$row->name] = $row->description;
        }
        return $result;
    }
}
