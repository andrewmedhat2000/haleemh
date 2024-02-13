<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Setter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Models\PasswordReset;
use Illuminate\Validation\Rule;

class AuthController extends BaseController
{

    /*
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register','verifyCode','resendVerificationCode','logout']]);
    }
*/
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
           // 'password'          => 'required',
            'phone'         => 'required'
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
          $user=User::where('phone',$request->phone)->first();
        if ($user) {


             if($user->is_active==false){
                return response()->json([
                    'message' => 'account deactivated'
                ], 402);
             }

            if($user->is_verified==1){
            $user['token'] = $user->createToken('Laravelia')->accessToken;
            /*
            $data_show= User::select('users.*','setter.*')
            ->join('setter','setter.user_id','=','users.id')
            ->where('setter.user_id','=',$user->id)
            ->first();
            */
            if($request->has('fcm_key')){
                $user->update(['fcm_key' => $request->input('fcm_key')]);
            }
            return response()->json([
                'user' => $user
            ], 200);
        }
        else{
            return response()->json([
                'message' => 'not verified'
            ], 402);
        }
        }
        return response()->json([
            'message' => 'Invalid credentials'
        ], 402);
    }

  public function register(Request $request)
{

    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'phone' => 'required|min:10|unique:users',
        'phone_code' => 'required',
        'image'=>'required',
        'national_id'=>'required',
        'nationality'=>'required',
        'email' => 'required|string|email|max:255|unique:users',
        'fcm_token'         => 'nullable|string',
        'Professional_life' => [
            'required',
            Rule::in(['freelance', 'nursery', 'عمل حر', 'حضانة']),
        ],
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
        'national_id' => $request->national_id,
        'nationality' => $request->nationality,

    ]);
    $englishValues = [
        'عمل حر' => 'freelance',
        'حضانة' => 'nursery',
        'nursery' => 'nursery',
        'freelance' => 'freelance',
    ];
    $englishValue = $englishValues[$request->input('Professional_life')];
    $data_setter['Professional_life'] = $englishValue;
    $data_setter['user_id'] = $user->id;
    $setter = new Setter($data_setter);
    $user->setter()->save($setter);
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

$data_show= User::select('users.*','setter.*')
            ->join('setter','setter.user_id','=','users.id')
            ->where('setter.user_id','=',$user->id)
            ->first();
$data_show['token']=$token;
    return response()->json([
        'message' => 'User created successfully',
        'user' => $data_show
    ]);
}

public function resendVerificationCode(Request $request)
{
    $request->validate([
        'phone' => 'required',
    ]);

    // Find the user by email
    $user = User::where('phone', $request->phone)->first();

    if (!$user) {
        return response()->json([
            'message' => 'User not found.',
        ], 404);
    }

    // Generate a new verification code
    $verificationCode = rand(100000, 999999);

    // Calculate the expiry date for the verification code (e.g., 10 minutes from now)
    $expiryDate = now()->addMinutes(10);

    // Update the verification code and expiry date in the user's record
    $user->verification_code = $verificationCode;
    $user->verification_code_expiry = $expiryDate;
    $user->save();
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
            'body' => "Your new verification code: $verificationCode",
        ]
    );
*/
    return response()->json([
        'code'=> $verificationCode,
        'message' => 'Verification code has been resent.',
    ]);
}





    public function verifyCode(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);
        $user = User::where('verification_code', $request->code)
            ->where('verification_code_expiry', '>=', now())
            ->first();
        if ($user) {
            // Clear the verification code and expiry date from the user's record
            $user->verification_code = null;
            $user->verification_code_expiry = null;
            $user->is_verified = 1;
            $user->save();
            return response()->json([
                'user' => $user,
                'message' => 'Code verification successful',
            ], 200);
        }

        return response()->json([
            'message' => 'Invalid or expired verification code',
        ], 402);
    }
    public function logout(Request $request): JsonResponse
{
    $request->user()->tokens()->delete();

    return response()->json([
        'message' => 'Successfully logged out',
    ]);
}
public function forgotPassword(Request $request)
    {
        DB::beginTransaction();

        $validator = Validator::make($request->all(), [
            'phone'         => 'required',
        ]);

        if ($validator->fails()) {
            return $this->apiErrorResponse(array_values($validator->messages()->all()), 422);
        }

        $phone = $request->phone;
        $user_phone_exist = User::where('phone', $phone)->first();
        if ($user_phone_exist) {
            try {
                $code = mt_rand(10000, 99999);
                $test = PasswordReset::updateOrCreate(
                    ['phone' => $user_phone_exist->phone],
                    ['token' => $code]
                );
               // $this->sendSMS('Welcome To Hekayh. Here is your reset token: ' . $code, $phone);

                DB::commit();
                return response()->json([
                    'message' => 'We have sent an sms to your phone with code to reset password!',
                    'code'=>$code
                ]);
            }
             catch (\Exception $e) {
                return $e;
                DB::rollBack();
                info('exception: ');
                info($e->getMessage());
                return $this->apiErrorResponse("Something went", 500);
            }

        }else{
            return $this->apiErrorResponse("There aren't user belongs to this phone.", 404);
        }


    }

    public function reset(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'phone' => 'required|string|exists:users,phone',
            'password' => 'required|string|confirmed',
            'token' => 'required|string'

        ]);

        if ($validator->fails()) {
            return $this->apiErrorResponse(array_values($validator->messages()->all()), 422);
        }

        $user = User::where('phone', $request->get('phone'))->first();

        $passwordReset = PasswordReset::where([
            ['token', $request->token],
            ['phone', $user->phone]
        ])->first();

        if (!$passwordReset) {
            return response()->json([
                'message' => 'This password reset token is invalid.'
            ], 404);
        }

        $user->update($request->all());
        $passwordReset->delete();

        return response()->json($user);
    }
}
