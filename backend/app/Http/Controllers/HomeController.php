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

        if(Auth::User())
        {
            /**
            *
            * @var user User
            */
            $user = Auth::User();
            $productSelect = ["id", "name", "price", "image"];
            $orders = Order::where("user_id", $user->id)->where("status", 0)->get();
            foreach($orders as $order){
                $carts[] = $order->Carts()->select($productSelect)->get();
            }
        }

        $payload = [
            "setting"    => $setting,
            "categories" => $categories,
        ];
        return response()->json($payload);
    }


    public function page()
    {
        $categories     = Category::select(["id", "name", "image"])->where("status", 1)->where("displayed", 1)->limit(3)->orderBy("name")->get();
        $products       = Product::getByPublished(4, 'id', 'desc');
        $topSellings    = Product::getByPublished(6, 'total_order', 'desc');
        $bestSellers    = Product::getByPublished(3, 'total_rating', 'desc');
        $payload        = [
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
