<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Parents;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Models\PasswordReset;
use Illuminate\Validation\Rule;

class ParentAuthController extends BaseController
{

    

  public function register(Request $request)
{

    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'phone' => 'required|min:10|unique:users',
        'phone_code' => 'required',
        'image'=>'required',
        'nationality'=>'required',
        'email' => 'required|string|email|max:255|unique:users',
        'fcm_token'         => 'nullable|string',
     ]);

    if ($validator->fails()) {
        $est = $validator->messages();
        foreach ($est->all() as $key => $as) {
            $messages[] = $as;
        }
        return response()->json([
            'message' => $messages,
        ], 422);
    }

    $user = User::create([
        'name' => $request->name,
        'phone'=> $request->phone,
        'phone_code'=> $request->phone_code,
        'email' => $request->email,
        'image' => $request->image,
        'nationality' => $request->nationality,

    ]);

    $parent = new Parents();
    $user->parent()->save($parent);
    // Generate a random verification code
    $verificationCode = rand(100000, 999999);

    // Calculate the expiry date for the verification code (e.g., 10 minutes from now)
    $expiryDate = now()->addMinutes(10);

    // Store the verification code and expiry date in the user's record
    $user->verification_code = $verificationCode;
    $user->verification_code_expiry = $expiryDate;
    if($request->has('fcm_key')){
        $user->fcm_key=$request->input('fcm_key');
    }
    $user->save();
    $user['token'] = $user->createToken('Laravelia')->accessToken;
    $token=$user['token'];

/*
    // Send the verification code via Twilio SMS
    $twilioSid = 'YOUR_TWILIO_SID'; // Replace with your Twilio SID
    $twilioToken = 'YOUR_TWILIO_AUTH_TOKEN'; // Replace with your Twilio Auth Token
    $twilioPhoneNumber = 'YOUR_TWILIO_PHONE_NUMBER'; // Replace with your Twilio phone number

    $twilioClient = new Client($twilioSid, $twilioToken);
    $twilioClient->messages->create(
        $user->phone_number,
        [
            'from' => $twilioPhoneNumber,
            'body' => "Your verification code: $verificationCode",
        ]
    );
*/

$data_show= User::select('users.*','parents.*')
            ->join('parents','parents.user_id','=','users.id')
            ->where('parents.user_id','=',$user->id)
            ->first();
$data_show['token']=$token;
    return response()->json([
        'message' => 'User created successfully',
        'user' => $data_show
    ]);
}







}
