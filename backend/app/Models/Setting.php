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

class Setting extends Model
{
    protected $table = "settings";

    protected $fillable = [
        "key_name",
        "key_value"
    ];

    public static function getAll(){
        $result = [];
        $settings = self::where("id", "<>", 0)->orderBy("key_name")->get();
        foreach($settings as $setting){
            $result[$setting->key_name] = $setting->key_value;
        }
        return $result;
    }

}
