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

class Size extends Model
{
    protected $table = "sizes";

    protected $fillable = [
        "name",
        "description",
        "status"
    ];

    public function ProductInventory() {
        return $this->hasMany(ProductInventory::class);
    }

}
