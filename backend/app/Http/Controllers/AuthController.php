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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
use App\Models\User;
use App\Models\Authentication;
use Carbon\Carbon;

class AuthController extends AppController
{

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|string|email|max:180',
            'password' => 'required|string|min:6',
        ]);

        $credentials = $request->only(['email', 'password']);

        if (!$token = Auth::attempt($credentials, ['exp' => Carbon::now()->addDays(30)->timestamp])) {
            return response()->json(['message' => 'These credentials do not match our records.'], 401);
        }

        $email = $request->input('email');
        $user  = User::where("email", $email)->first();
        $status = (int) $user->status;

        if($status == 0)
        {
            return response()->json(['message' => 'You need to confirm your account. We have sent you an activation code, please check your email.'], 401);
        }

        $this->activity($user->id, "Sign In", "Sign In To Application", "Your has been logged in an application.");
        return response()->json(["token"=> $token]);
    }


    public function register(Request $request)
    {
        
        $this->validate($request, [
            'name' => 'required|min:3',
            'email' => 'required|email|max:180|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        $faker = Faker::create();
        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');
        $token = $faker->uuid();
        $names = explode(" ", $name);

        $user = new User();

        if(count($names) > 1){
            $last_name = array_slice($names, 1, (count($names) - 1));
            $last_name = implode(" ", $last_name);
            $user->first_name = $names[0];
            $user->last_name = $last_name;
        }else{
            $user->first_name = $names[0];
        }

        $user->email = $email;
        $user->password = Hash::make($password);
        $user->status = 0;
        $user->save();

        $verification = new Authentication();
        $verification->user_id = $user->id;
        $verification->type = "email-verification";
        $verification->credential = $email;
        $verification->token = $token;
        $verification->expired_at = date("Y-m-d H:i:s", strtotime("+30 minutes"));
        $verification->status = 0;
        $verification->save();

        $this->activity($user->id, "Sign Up", "Sign Up To Application", "Your has been registered in an application.");

        $payload = [
            'message' => 'You need to confirm your account. We have sent you an activation code, please check your email.',
            'token'=> $token
        ];

        return response()->json($payload);
    }

    public function confirm($token)
    {
        $verification = Authentication::where("token", $token)
            ->where("type", "email-verification")
            ->where("status", 0)
            ->where("expired_at", ">", date("Y-m-d H:i:s"))
            ->first();

        if(is_null($verification))
        {
            return response()->json(['message' => "We can't find a user with that token is invalid or expired!"], 400);
        }

        $verification->status = 1;
        $verification->save();

        $user_id = $verification->user_id;
        User::where("id", $user_id)->update(["status"=> 1]);
        
        $this->activity($user_id, "Confirmation", "E-mail Confirmation", "Your has been confirmed a registration account.");
        return response()->json(['message' => 'Your e-mail is verified. You can now login.']);
    }

    public function resend($token)
    {
        $verification = Authentication::where("token", $token)->where("type", "email-verification")->where("status", 0)->first();

        if(is_null($verification))
        {
            return response()->json(['message' => "We can't find a user with that token is invalid.!"], 400);
        }
        
        $faker = Faker::create();
        $token = $faker->uuid();

        $verification->token = $token;
        $verification->expired_at = date("Y-m-d H:i:s", strtotime("+30 minutes"));
        $verification->save();
        
        $this->activity($verification->user_id, "Resend Link Confirm", "Send Request Link Confirmation", "Your has been sent a request link confirmation.");
        return response()->json(['message' => 'We have sent you an activation code, please check your email.']);
    }


    public function forgot(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|string|email|max:180'
        ]);

        $faker = Faker::create();
        $email = $request->input('email');
        $token = $faker->uuid();

        $user = User::where("email", $email)->first();

        if(is_null($user))
        {
            return response()->json(['message' => "We can't find a user with that e-mail address."], 400);
        }

        $reset = Authentication::where("credential", $email)->where("user_id", $user->id)->where("type", "email-reset")->first();

        if(is_null($reset))
        {
            $reset = new Authentication();
        }

        $reset->user_id = $user->id;
        $reset->type = "email-reset";
        $reset->credential = $email;
        $reset->token = $token;
        $reset->expired_at = date("Y-m-d H:i:s", strtotime("+30 minutes"));
        $reset->status = 0;
        $reset->save();

        $this->activity($user->id, "Reset Password", "Send Request Reset Password", "Your has been sent a request reset password.");

        $payload = ["message" => "We have e-mailed your password reset link!", "token"=> $token];

        return response()->json($payload);
    }

    public function reset($token, Request $request)
    {

        $this->validate($request, [
            'email' => 'required|email|max:180',
            'password' => 'required|min:6|confirmed',
        ]);

        $email = $request->input('email');
        $password = $request->input('password');
        $user = User::where("email", $email)->first();

        $reset = Authentication::where("token", $token)
            ->where("credential", $email)
            ->where("type", "email-reset")
            ->where("status", 0)
            ->where("expired_at", ">", date("Y-m-d H:i:s"))
            ->first();

        if(is_null($reset))
        {
            return response()->json(['message' => "We can't find a user with that token is invalid or expired !."], 400);
        }

        if(is_null($user))
        {
            return response()->json(['message' => "We can't find a user with that e-mail address."], 400);
        }

        $user->password = Hash::make($password);
        $user->save();

        $reset->status = 1;
        $reset->save();

        $this->activity($user->id, "Reset Password", "Update Current Password", "Your has been changed a current password.");
        return response()->json(["message" => "Your password has been reset!"]);
    }

}