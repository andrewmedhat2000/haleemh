<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Events\NewMessage;
use App\Jobs\FCMNotification;
use App\Models\Conversation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Pusher\Pusher;
use Illuminate\Support\Facades\Redis;
use Illuminate\Broadcasting\Broadcasters\RedisBroadcaster;
class ChatController extends BaseController
{

    public function conversations(Request $request)
    {
        try {
              $conversations = Conversation::whereHas('users', function($q) {
                $q->where('users.id', Auth::id());//Auth::id()
              })->when($request->filled('search'), function($q) use($request) {
                $q->whereHas('users', function($query) use($request) {
                    $query->where('users.id', '!=', Auth::id())->where('name', 'like', "%{$request->search}%");
                });
            })
            ->orderBy('updated_at', 'desc')
            ->with('users', 'lastMessage')
            ->get()->each->withUser();


            return response()->json([
                'status_code' => 200,
                'data' => $conversations,
            ]);

        } catch(\Exception $ex) {
            return $this->internalServerError($ex);
        }
    }

    public function destroy(Request $request)
    {


         /*
       // dd('adas');
        try {
            $Conversation = Conversation::where('id', $request->id)->first();
            if(! $Conversation){
                return response()->json([
                    'status_code' => 404,
                    'message' => 'conversation not found.'
                ], 404);
            }
            $Conversation->delete();
            return response()->json([
                'status_code' => 200,
                'msg' => "Conversation deleted successfully",
                ]);
        } catch(\Exception $ex) {
            return $this->internalServerError($ex);
        }
        */

    }

    public function messages(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'conversation_id'   => 'required_without:user_id|exists:conversation_user,conversation_id,user_id,'.Auth::id(),
                'user_id' => 'required_without:conversation_id|exists:users,id',
            ]);

            if ($validator->fails()) {
                return $this->apiErrorResponse($validator->errors()->first(), 409);
            }

            if($request->has('conversation_id')) {
                $conversation = Conversation::find($request->conversation_id);
            } else {
                $conversation = Conversation::whereHas('users', function($q) {
                    $q->where('users.id', Auth::id());
                })->whereHas('users', function($q) use($request) {
                    $q->where('users.id', $request->user_id);
                })->firstOr(function() use($request) {
                    $conversation = Conversation::create();
                    $conversation->users()->attach([Auth::id(), $request->user_id]);
                    return $conversation;
                });
            }

            $messages = $conversation->messages()->latest()->paginate(20);

            return response()->json([
                'status_code' => 200,
                'conversation_id' => $conversation->id,
                'data' => $messages,
            ]);

        } catch(\Exception $ex) {
            return $this->internalServerError($ex);
        }
    }



    public function send(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'conversation_id'   => 'required_without:user_id|exists:conversation_user,conversation_id,user_id,'.Auth::id(),
                'user_id' => 'required_without:conversation_id|exists:users,id',
                'text' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->apiErrorResponse($validator->errors()->first(), 409);
            }


            if($request->has('conversation_id')) {
                $conversation = Conversation::find($request->conversation_id);
            } else {
                $conversation = Conversation::whereHas('users', function($q) {
                    $q->where('users.id', Auth::id());
                })->whereHas('users', function($q) use($request) {
                    $q->where('users.id', $request->user_id);
                })->first();
                if(!$conversation){
                    return $this->apiErrorResponse('The selected user id is invalid.', 409);
                }
            }

            //$conversation = Conversation::find(1);

            $message = $conversation->messages()->create(['user_id' => Auth::id(), 'text' => $request->input('text')]);
           // $message = $conversation->messages()->create(['user_id' => 1, 'text' =>'hello andrew']);

            $conversation->touch();
            broadcast(new NewMessage($message));

            $pusher = new Pusher(
                config('broadcasting.connections.pusher.key'),
                config('broadcasting.connections.pusher.secret'),
                config('broadcasting.connections.pusher.app_id'),
                ['cluster' => config('broadcasting.connections.pusher.options.cluster')]
            );

            $active_users_count = $pusher->get_channel_info(
                "conversation.{$conversation->id}", ['info' => 'subscription_count']
            )->subscription_count;

          // $token='fZrIeDZIIylA8u5RR2_kk4:APA91bG8KmEEaF41q7P5RI3G2OTPI4eK8ts-78RK22X98hMHloxuW_IZyvDNro-NOTFKhvua8Wvh8h0gpkL_-UWuV2KwLk5trxzkBgVN8Z4-cBZAA9vYjOXJ_CVwsSq-B22v8E-ROomy';

            if($active_users_count == 1){
                $sender = Auth::user();
                FCMNotification::dispatch(
                    $conversation->users->where('id', '!=', $sender->id)->pluck('id'),
                   // $token,
                    $sender->name,
                    $message->text,
                    [
                        'type' => 'conversation',
                        'sender_id' => $sender->id,
                        'sender_name' => $sender->name,
                        'photo' => $sender->image,
                        'message' => $message->text,
                        'conversation_id' => $conversation->id
                    ],
                    'CHAT'
                );
                      
               }


            return response()->json([
                'status_code' => 200,
                'message' => 'success',
            ]);
        }
        catch(\Exception $ex) {
            return $this->internalServerError($ex);
        }
    }





}
