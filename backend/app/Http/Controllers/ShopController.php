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

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

class ShopController extends AppController
{
    public function list(Request $request)
    {
        $limit  = $request->input("limit", 10);
        $page   = $request->input("page", 1);
        $offset = (($page-1)*$limit);
        $products =  Product::where("status", 1);

        if($request->input("search")){

        }

        if($request->input("category")){

        }

        if($request->input("brand")){

        }

        if($request->input("price")){

        }

        $products = $products->limit($limit)->offset($offset)->orderBy("id", "DESC")->get();
        return response()->json($products);
    }

    public function filter()
    {
        $categories = Category::where("status", 1)->orderBy("name")->with('products')->get();
        $brands = Brand::where("status", 1)->orderBy("name")->with('product')->get();
        $topselling = Product::where("status", 1)->orderBy("total_order", "DESC")->with('categories')->limit(3)->get();
        return response()->json(["categories"=> $categories, "brands"=> $brands, "tops"=> $topselling]);
    }


}
