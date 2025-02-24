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
use App\Models\NewsLetter;

class NewsletterController extends AppController
{
    public function send(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|max:180|unique:newsletters'
        ]);

        $model = new NewsLetter();
        $model->ip_address = $request->ip();
        $model->email = $request->input('email');
        $model->status = 1;
        $model->save();

        return response()->json(["message"=> "Your subscription request has been sent. Thank you!"]);
    }
}