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

class ProductReview extends Model
{
    protected $table = "products_reviews";

    protected $fillable = [
        "product_id",
        "user_id",
        "rating",
        "review",
        "status"
    ];

    public function Product() {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function User() {
        return $this->belongsTo(User::class, 'user_id');
    }


}
