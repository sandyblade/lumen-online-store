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

class Product extends Model
{
    protected $table = "products";

    protected $fillable = [
        "brand_id",
        "image",
        "sku",
        "name",
        "name",
        "price",
        "total_order",
        "total_rating",
        "published_date",
        "description",
        "details"
    ];

    public function Brand() {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function ProductImage() {
        return $this->hasMany(ProductImage::class);
    }

    public function ProductInventory() {
        return $this->hasMany(ProductInventory::class);
    }

    public function ProductReview() {
        return $this->hasMany(ProductReview::class);
    }

    public function Categories() {
        return $this->belongsToMany(Category::class, "products_categories");
    }

    public function Wishlists() {
        return $this->belongsToMany(User::class, "products_wishlists");
    }

    public function Carts() {
        return $this->belongsToMany(Order::class, "orders_carts");
    }

    public static function getByPublished($limit, $order, $dir){

        $maxRating = self::where("status", 1)
            ->where('total_rating', '>', 0)
            ->orderBy("total_rating", "desc")
            ->first();

        $data = self::where("status", 1)
            ->with('categories')
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();

        $data = $data->map(function ($row, $index) use ($data, $maxRating) {

            $price = (float) $row->price;
            $price_old = (float) $row->price + ($row->price * 0.05);
            $newest = rand(0, count($data));
            $discount = rand(0, count($data));
            $rating = $row->total_rating;

            if($maxRating != null){
                $rating = ((($row->total_rating / $maxRating->total_rating) * 100) / 20);
            }

            return [
                "id"=> $row->id,
                "name"=> $row->name,
                "image"=> $row->image,
                "category"=> $row->categories->pluck("name")->first(),
                "price"=> $price,
                "price_old"=> $price_old,
                "newest"=> $newest == $index,
                "discount"=> $discount == $index,
                "total_rating"=> floor($rating)
            ];
        });

        return $data;
    }

}
