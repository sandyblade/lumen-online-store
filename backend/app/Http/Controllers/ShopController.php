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

        $maxRating = Product::where("status", 1)
            ->where('total_rating', '>', 0)
            ->orderBy("total_rating", "desc")
            ->first();

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
            $range = explode("|", $request->price);
            $min = isset($range[0]) ? $range[0] : 0;
            $max = isset($range[1]) ? $range[1] : 0;
            $products = $products->whereRaw("price BETWEEN ".$min." AND ".$max." ");
        }

        $order = ["id", "DESC"];

        if ($request->input("sort")) {
            $sorts = explode(",", $request->input("sort"));
            $order = [$sorts[0], $sorts[1]];
        }

        $total_filtered = $products->count();
        $products = $products->limit($limit)->offset($offset)->orderBy($order[0], $order[1])->get();

        $products = $products->map(function ($row, $index) use ($total_all, $maxRating) {
            $price = (float) $row->price;
            $price_old = (float) $row->price + ($row->price * 0.05);
            $rating = $row->total_rating;
            if($maxRating != null){
                $rating = ((($row->total_rating / $maxRating->total_rating) * 100) / 20);
            }
            return [
                "id"=> $row->id,
                "name"=> $row->name,
                "image"=> $row->image,
                "category"=> $row->categories->pluck("name")->toArray(),
                "price"=> $price,
                "price_old"=> $price_old,
                "total_rating"=> round($rating)
            ];
        });


        $payload = [
            "list" => $products,
            "total_all" => $total_all,
            "total_filtered" => $total_filtered,
            "limit"=> $limit
        ];

        return response()->json($payload);
    }

    public function filter()
    {
        $categories = Category::where("status", 1)->orderBy("name")->with('products')->get();
        $brands = Brand::where("status", 1)->orderBy("name")->with('product')->get();
        $topselling = Product::getByPublished(3, 'total_order', 'desc');
        return response()->json(["categories" => $categories, "brands" => $brands, "tops" => $topselling]);
    }
}
