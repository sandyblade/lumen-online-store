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

class ProductImage extends Model
{
    protected $table = "products_images";

    protected $fillable = [
        "product_id",
        "path",
        "sort",
        "status"
    ];

    public function Product() {
        return $this->belongsTo(Product::class, 'product_id');
    }


}
