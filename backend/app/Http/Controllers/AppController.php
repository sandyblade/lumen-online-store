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

use Laravel\Lumen\Routing\Controller as BaseController;
use App\Models\Activity;

class AppController extends BaseController
{
    protected static function activity($user_id, $event, $subject, $description)
    {
        $activity = new Activity();
        $activity->user_id = $user_id;
        $activity->event = $event;
        $activity->subject = $subject;
        $activity->description = $description;
        $activity->status = 1;
        $activity->save();
        return $activity;
    }
}
