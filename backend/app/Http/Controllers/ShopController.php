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
        $offset = (($page - 1) * $limit);
        $products =  Product::where("status", 1);
        $total_all =  $products->count();

        if ($request->input("search")) {
            $products = $products->where(function ($query) use ($request) {
                $query->where('sku', "like", "%" . $request->search . "%");
                $query->orWhere('name', "like", "%" . $request->search . "%");
                $query->orWhere('description', "like", "%" . $request->search . "%");
                $query->orWhere('details', "like", "%" . $request->search . "%");
            });
        }

        if ($request->input("category")) {
            $products = $products->whereHas('categories', function ($query) use ($request) {
                $query->whereIn('category_id', explode(",", $request->category));
            });
        }

        if ($request->input("brand")) {
            $products = $products->where(function ($query) use ($request) {
                $query->whereIn('brand_id', explode(",", $request->brand));
            });
        }

        if ($request->input("price")) {
            $range = explode(",", $request->price);
            $min = isset($range[0]) ? $range[0] : 0;
            $max = isset($range[1]) ? $range[1] : 0;
            $products = $products->where("price", ">=", $min)->where("price", "<=", $max);
        }

        $total_filtered = $products->count();
        $products = $products->limit($limit)->offset($offset)->orderBy("id", "DESC")->get();


        $payload = [
            "list" => $products,
            "total_all" => $total_all,
            "total_filtered" => $total_filtered
        ];

        return response()->json($payload);
    }

    public function filter()
    {
        $categories = Category::where("status", 1)->orderBy("name")->with('products')->get();
        $brands = Brand::where("status", 1)->orderBy("name")->with('product')->get();
        $topselling = Product::where("status", 1)->orderBy("total_order", "DESC")->with('categories')->limit(3)->get();
        return response()->json(["categories" => $categories, "brands" => $brands, "tops" => $topselling]);
    }
}
