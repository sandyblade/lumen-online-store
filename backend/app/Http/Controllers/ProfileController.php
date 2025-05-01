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

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Activity;

class ProfileController extends AppController
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function detail()
    {
        $user = Auth::User();
        return response()->json($user);
    }

    public function update(Request $request)
    {
        /**
         *
         * @var user User
         */
        $user = Auth::User();

        $rules = [
            'first_name' => 'required|max:100|min:3',
            'last_name' => 'required|max:100|min:3',
            'city'      => 'required|max:255|min:3',
            'country'   => 'required|max:255|min:3',
            'address'   => 'required|min:3',
            'zip_code'  => 'required|max:100|min:3',
            'email'     => 'required|email|max:180|unique:users,email,' . $user->id
        ];

        $this->validate($request, $rules);

        $user->email = $request->input('email');

        if ($request->input('phone')) {
            $user->phone = $request->input('phone');
        }

        $user->first_name   = $request->input('first_name');
        $user->last_name    = $request->input('last_name');
        $user->gender       = $request->input('gender');
        $user->email        = $request->input('email');
        $user->phone        = $request->input('phone');
        $user->city         = $request->input('city');
        $user->country      = $request->input('country');
        $user->zip_code     = $request->input('zip_code');
        $user->address      = $request->input('address');
        $user->save();

        $this->activity($user->id, "Update Profile", "Update Current User Profile", "Your has been updated current user profile.");
        return response()->json(["message" => "Your user profile has been changed !!"]);
    }

    public function password(Request $request)
    {
        /**
         *
         * @var user User
         */
        $user = Auth::User();

        $this->validate($request, [
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        $current_password = $request->input('current_password');
        $password = $request->input('password');

        $hashedPassword = $user->password;
        if (!Hash::check($current_password, $hashedPassword)) {
            return response()->json(["message" => "Incorrect current password please try again !!"], 400);
        }

        $user->password = Hash::make($password);
        $user->save();

        $this->activity($user->id, "Change Password", "Update Current User Password", "Your has been updated current password.");
        return response()->json(["message" => "Your current password has been changed!!"]);
    }

    public function history(Request $request)
    {
        /**
         *
         * @var user User
         */
        $user   = Auth::User();
        $limit  = $request->input("limit", 10);
        $page   = $request->input("page", 1);
        $offset = (($page - 1) * $limit);
        $result = Activity::where("user_id", $user->id)->limit($limit)->offset($offset)->orderBy("created_at", "desc")->get();
        return response()->json($result);
    }

    public function upload(Request $request)
    {
        /**
         *
         * @var user User
         */
        $user = Auth::User();
        $dirUpload = storage_path('files');

        if (!is_dir($dirUpload)) {
            @mkdir($dirUpload);
        }

        if (!$request->file('file_image')) {
            return response()->json(["file_image" => ["The file with name 'file_image' is required."]]);
        }

        $image = md5(Str::random(34));

        if ($request->file('file_image')) {
            $upload = $request->file('file_image')->move($dirUpload, $image);

            if ($upload) {
                if (!is_null($user->image)) {
                    $currentUpload = $dirUpload . "/" . $user->image;
                    if (file_exists($currentUpload)) {
                        unlink($currentUpload);
                    }
                }

                $user->image = $image;
                $user->save();
            }
        }

        $this->activity($user->id, "Change Profile Image", "Update Current Profile Image", "Your has been updated current profile image.");
        return response()->json(["message" => "Your profile picture has been changed !!"]);
    }
}
