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
use App\Models\ProductImage;
use App\Models\ProductInventory;
use App\Models\ProductReview;
use App\Models\Colour;
use App\Models\Size;
use App\Models\Payment;
use App\Models\Setting;
use Illuminate\Http\Request;
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
        $product = Product::where("id", $id)->with('categories')->where("status", 1)->first();

        if (is_null($product)) {
            return response()->json(['message' => 'These product do not match our records.'], 404);
        }

        $images = ProductImage::where("product_id", $id)
            ->select(["id", "path"])
            ->where("status", 1)
            ->orderBy("sort")
            ->get();
        
        $stocks     = ProductInventory::where("product_id", $id)->where("stock", ">", 0)->where("status", 1)->get();
        $reviews    = ProductReview::where("product_id", $id)->with('user')->get();
        $categories = $product->Categories()->get()->pluck("id")->toArray();

        $related    = Product::where("status", 1)->with('categories')->where("id", "!=", $id)->whereHas('categories', function ($query) use ($categories) {
            $query->whereIn('category_id', $categories);
        })
        ->orderBy("total_rating", "desc")
        ->limit(4)
        ->get();

        $sizes = Size::where("status", 1)->whereHas('ProductInventory', function ($query) use ($id) {
            $query->where('product_id', $id);
            $query->where('stock', ">", 0);
            $query->where('status', 1);
        })
        ->orderBy("name")
        ->get();

        $colours = Colour::where("status", 1)->whereHas('ProductInventory', function ($query) use ($id) {
            $query->where('product_id', $id);
            $query->where('stock', ">", 0);
            $query->where('status', 1);
        })
        ->orderBy("name")
        ->get();

        $payload = [
            "product" => $product,
            "images"  => $images,
            "stocks"  => $stocks,
            "reviews" => $reviews,
            "related" => $related,
            "sizes"   => $sizes,
            "colours" => $colours
        ];

        return response()->json($payload);
    }

    public function wishlist($id)
    {
        $product = Product::where("id", $id)->with('categories')->where("status", 1)->first();

        if (is_null($product)) {
            return response()->json(['message' => 'These product do not match our records.'], 404);
        }

        $user = Auth::User();
        $product->Wishlists()->sync([$user->id]);

        $this->activity($user->id, "Add Wishlist", "Add Product To Wishlist", "Your has been added product to your wishlist.");
        return response()->json(['message'=> 'Your product has been added to wishlist.']);
    }

    public function review($id, Request $request)
    {
        $product = Product::where("id", $id)->with('categories')->where("status", 1)->first();

        if (is_null($product)) {
            return response()->json(['message' => 'These product do not match our records.'], 404);
        }

        $this->validate($request, [
            'email'     => 'required|string|email|max:180',
            'name'      => 'required|string|max:200',
            'review'    => 'required|string|max:200|min:20',
        ]);

        $user = Auth::User();
        $model = new ProductReview();
        $model->product_id = $id;
        $model->user_id = $user->id;
        $model->rating = $request->input('rating', 0);
        $model->review = $request->input('review');
        $model->status = 1;
        $model->save();

        $totalRating = ProductReview::where("product_id", $id)->where("status", 1)->sum("rating");
        $product->total_rating = $totalRating;
        $product->save();

        $this->activity($user->id, "Add Review", "Add Review To Product", "Your has been added review to product.");
        return response()->json(['message'=> 'Your review has been added.']);
    }

    public function detail($id)
    {
        $user = Auth::User();
        $order = Order::where("user_id", $user->id)->with('carts')->where("id", $id)->where("status", 0)->first();

        if (is_null($order)) {
            return response()->json(['message' => 'These order do not match our records.'], 404);
        }

        $details = OrderDetail::where("order_id", $id)->get();
        $payments = Payment::where("status", 1)->orderBy("name")->get();

        $payload = [
            "order"     => $order,
            "details"   => $details,
            "payments"  => $payments
        ];

        return response()->json($payload);
    }

    public function add($id, Request $request)
    {
        $rules = [
            'size_id'   => 'required|numeric',
            'color_id'  => 'required|numeric',
            'qty'       => 'required|numeric',
        ];
        $this->validate($request, $rules);

        $product = Product::where("id", $id)->with('categories')->where("status", 1)->first();

        if (is_null($product)) {
            return response()->json(['message' => 'These product do not match our records.'], 404);
        }

        $user = Auth::User();
        $order = Order::where("user_id", $user->id)->orderBy("id", "DESC")->where("status", 0)->first();

        if(is_null($order))
        {
            $order = new Order();
            $order->invoice_number = date("Ymd")."".(floor(microtime(true) * 1000));
            $order->status = 0;
        }

        $order->size_id = $request->input('size_id');
        $order->color_id = $request->input('color_id');
        $order->qty = $request->input('qty');
        $order->total_item = $order->total_item + $request->input('qty');
        $order->save();

        $order->Carts()->sync([$id]);

        $invetory = ProductInventory::where("product_id", $id)
            ->where("size_id", $request->input('size_id'))
            ->where("color_id", $request->input('color_id'))
            ->first();
        
        $detail = new OrderDetail();
        $detail->order_id = $order->id;
        $detail->product_inventory_id = $invetory->id;
        $detail->price = $product->price;
        $detail->qty = $request->input('qty');
        $detail->total = $product->price * $request->input('qty');
        $detail->status = 1;
        $detail->save();

        $totalItem = OrderDetail::where("order_id", $order->id)->sum('qty');
        $totalSubTotal = OrderDetail::where("order_id", $order->id)->sum('total');
        $discount = (float) Setting::getConfig("discount_value");
        $taxes = (float) Setting::getConfig("tax_value");
        $shipment = (float) Setting::getConfig("total_shipment");
        $updateOrder = $order;

        if($discount > 0){
            $updateOrder->total_discount = $totalSubTotal * ($discount/100);
        }

        if($taxes > 0){
            $updateOrder->total_taxes = $totalSubTotal * ($taxes/100);
        }

        $totalPaid = ($totalSubTotal + $updateOrder->total_taxes + $shipment) - $updateOrder->total_discount;
        $updateOrder->total_item = $totalItem;
        $updateOrder->subtotal = $totalSubTotal;
        $updateOrder->total_shipment = $shipment;
        $updateOrder->total_paid = $totalPaid;
        $updateOrder->save();

        $this->activity($user->id, "Add Cart", "Add Product To Cart", "Your has been added product to cart.");
        return response()->json(["message"=> "Your cart has been added."]);
    }

    public function delete($id)
    {
        $detail = OrderDetail::where("id", $id)->first();

        if(is_null($detail)){
            return response()->json(['message' => 'These detail do not match our records.'], 404);
        }

        OrderDetail::where("id", $id)->delete();

        $user = Auth::User();
        $order = $detail->Order()->first();
        $totalItem = OrderDetail::where("order_id", $order->id)->sum('qty');
        $totalSubTotal = OrderDetail::where("order_id", $order->id)->sum('total');
        $discount = (float) Setting::getConfig("discount_value");
        $taxes = (float) Setting::getConfig("tax_value");
        $shipment = (float) Setting::getConfig("total_shipment");
        $updateOrder = $order;

        if($discount > 0){
            $updateOrder->total_discount = $totalSubTotal * ($discount/100);
        }

        if($taxes > 0){
            $updateOrder->total_taxes = $totalSubTotal * ($taxes/100);
        }

        $totalPaid = ($totalSubTotal + $updateOrder->total_taxes + $shipment) - $updateOrder->total_discount;
        $updateOrder->total_item = $totalItem;
        $updateOrder->subtotal = $totalSubTotal;
        $updateOrder->total_shipment = $shipment;
        $updateOrder->total_paid = $totalPaid;
        $updateOrder->save();

        $this->activity($user->id, "Delete Cart", "Remove Product From Cart", "Your has been removeed product from cart.");
        return response()->json(["message"=> "Your cart has been deleted."]);
    }

    public function checkout($id, Request $request) 
    {
        $user = Auth::User();
        $order = Order::where("user_id", $user->id)->where("id", $id)->where("status", 0)->first();

        if (is_null($order)) {
            return response()->json(['message' => 'These order do not match our records.'], 404);
        }

        # Update Order
        $rules = [
            'payment_id' => 'required|numeric',
            'first_name' => 'required|max:100|min:3',
            'last_name'  => 'required|max:100|min:3',
            'city'       => 'required|max:255|min:3',
            'country'    => 'required|max:255|min:3',
            'address'    => 'required|min:3',
            'zip_code'   => 'required|max:100|min:3',
            'email'      => 'required|email|max:180'
        ];
        $this->validate($request, $rules);
        $order->payment_id = $request->input('payment_id');
        $order->status = 1;
        $order->save();

        # Create Billing
        $fields = array_keys($rules);
        unset($fields[0]);

        $fields = array_values($fields);

        foreach($fields as $field){
            $bill = new OrderBilling();
            $bill->order_id = $id;
            $bill->name = $field;
            $bill->description = $request->input($field);
            $bill->status = 1;
            $bill->save();
        }

        # Update Inventories, Product, Whislist
        $details = OrderDetail::where("order_id", $id)->get();
        foreach($details as $detail){
            
            $qty = $detail->qty;
            $stock = $detail->ProductInventory()->first();
            $stock->stock = $stock->stock - $qty;
            $stock->save();

            $product = $stock->ProductInventory()->Product()->first();
            $product->total_order = $product->total_order + $qty;
            $product->Wishlists()->detach($user->id);
            $product->save();
        }
        
        $this->activity($user->id, "Checkout Order", "Completed Checkout Current Order", "Your order has been finished.");
        return response()->json(["message"=> "Your order has been completed."]);
    }
}
