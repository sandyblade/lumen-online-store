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

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderBilling;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;


class OrderController extends AppController
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function billing()
    {
        $user = Auth::User();
        $order = Order::where("user_id", $user->id)->orderBy("id", "desc")->first();
        if (is_null($order)) {
            return response()->json($user);
        } else {
            $billing = OrderBilling::getByOrder($order->id);
            return response()->json($billing);
        }
    }

    public function cart($id)
    {
        $product = Product::where("id", $id)->first();

        if (is_null($product)) {
            return response()->json(['message' => 'These product do not match our records.'], 400);
        }

        $payload = [
            "product" => $product
        ];

        return response()->json($payload);
    }

    public function detail($id)
    {
        $user = Auth::User();
        $order = Order::where("user_id", $user->id)->with('carts')->where("id", $id)->where("status", 0)->first();

        if (is_null($order)) {
            return response()->json(['message' => 'These order do not match our records.'], 400);
        }

        $details = OrderDetail::where("order_id", $id)->get();

        $payload = [
            "order" => $order,
            "details" => $details
        ];

        return response()->json($payload);
    }

    public function checkout($id) {}
}
