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

use App\Models\Setting;
use App\Models\Category;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class HomeController extends AppController
{

    public function component()
    {
        $setting = Setting::getAll();
        $categories = Category::select(["id", "name"])->where("status", 1)->orderBy("name")->get();
        $wishlists = [];
        $carts = [];

        if(Auth::User())
        {
            /**
            *
            * @var user User
            */
            $user = Auth::User();
            $productSelect = ["id", "name", "price", "image"];
            $wishlists = $user->Wishlists()->select($productSelect)->get();
            $orders = Order::where("user_id", $user->id)->where("status", 0)->get();
            foreach($orders as $order){
                $carts[] = $order->Carts()->select($productSelect)->get();
            }
        }

        $payload = [
            "setting"    => $setting,
            "categories" => $categories,
            "wishlists"  => $wishlists,
            "carts"      => $carts
        ];
        return response()->json($payload);
    }


    public function page()
    {
        $categories =  Category::select(["id", "name", "image"])->where("status", 1)->where("displayed", 1)->limit(3)->orderBy("name")->get();
        $products = Product::where("status", 1)->orderBy("id", "DESC")->with('categories')->limit(4)->get();
        $topSellings = Product::where("status", 1)->orderBy("total_order", "DESC")->with('categories')->limit(6)->get();
        $bestSellers = Product::where("status", 1)->orderBy("total_rating", "DESC")->with('categories')->limit(3)->get();
        $payload = [
            "categories"   => $categories,
            "products"     => $products,
            "topSellings"  => $topSellings,
            "bestSellers"  => $bestSellers
        ];
        return response()->json($payload);
    }

   

    public function stream($param)
    {
        $file_path = storage_path('files') . '/' . $param;
        if (file_exists($file_path)) {
            $file = file_get_contents($file_path);
            return response($file, 200)->header('Content-Type', 'image/jpeg');
        }
        $res['success'] = false;
        $res['message'] = "File not found";
        return $res;
    }

}
