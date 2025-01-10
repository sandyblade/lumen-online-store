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

class Activity extends Model
{
    protected $table = "activties";

    protected $fillable = [
        "user_id",
        "event",
        "subject",
        "description",
        "status"
    ];

    public function User() {
        return $this->belongsTo(User::class, 'user_id');
    }


}
