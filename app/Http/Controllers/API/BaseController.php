<?php

namespace App\Http\Controllers\Api;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\ChatGrant;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Log;
use App\Models\BannedUser;
use Illuminate\Support\Facades\Auth;

class BaseController extends Controller
{
    protected $sid;
    protected $token;
    protected $key;
    protected $secret;
    protected $number;

    // return $this->apiResponse();
    // return $this->apiResponseCustom();
    // return $this->apiErrorResponse();
    // return $this->apiErrorResponse($validator->errors()->first());
    // return $this->internalServerError($ex);

    public function __construct()
    {
        $this->sid = config('services.twilio.sid');
        $this->token = config('services.twilio.token');
        $this->key = config('services.twilio.key');
        $this->secret = config('services.twilio.secret');
        $this->number = config('services.twilio.number');
        $this->chat_sid = config('services.twilio.chat_sid');

    }


    public function apiResponse($data = [], $message = 'success', $status_code = 200)
    {
        return response()->json([
            'status_code' => $status_code,
            'message' => $message,
            'data' => $data,
        ]);
    }

    public function apiResponseCustom($key, $value, $message = 'success', $status_code = 200)
    {
        return response()->json([
            'status_code' => $status_code,
            'message' => $message,
            $key => $value,
        ]);
    }

    public function apiErrorResponse($message = 'Not found', $status_code = 404)
    {
        return response()->json([
            'status_code' => $status_code,
            'message' => $message,
        ], $status_code);
    }

    public function internalServerError(\Exception $ex)
    {
        Log::info('exception: ');
        Log::info($ex->getMessage());
        Log::info($ex);

        return response()->json([
            'status_code' => 500,
            'message' => 'Something Went Wrong',
            'info' => $ex->getMessage()
        ], 500);
    }








    public function allowUser(){

        $user = Auth::user();

        $bannedUser = BannedUser::where('user_id', $user->id)->first();
        if ($bannedUser) {
            return $this->apiErrorResponse('This User is banned.', 422);
        }

        if (request()->get('mobile_uuid')) {
            $bannedMobile = BannedUser::where('mobile_uuid', request()->get('mobile_uuid'))->first();
            if ($bannedMobile) {
                return $this->apiErrorResponse('This Mobile Device is banned.', 422);
            }
        }

        if (!$user->active) {
            return $this->apiErrorResponse('This User is deactivated by admin.', 422);
        }

        return false;
    }


    public function sendSMS($message, $recipient)
    {
        try{

            $client = new Client($this->sid, $this->token);
            if(substr($recipient, 0, 4) == '+200'){
                $recipient = '+20' . substr($recipient, 4);
            }
            $client->messages->create($recipient,
            ['from' => $this->number, 'body' => $message] );

        } catch (\Exception $ex) {

            Log::info('exception: ');
            Log::info($ex->getMessage());
            Log::info($ex);

            return response()->json([
                'status_code' => 407,
                'message' => 'Something Went Wrong',
                'info' => $ex->getMessage()
            ], 407);
        }
    }




}
