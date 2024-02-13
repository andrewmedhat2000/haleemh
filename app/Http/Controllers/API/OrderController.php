<?php

namespace App\Http\Controllers\API;
use App\Models\Order;
use App\Models\Setter;
use App\Models\Parents;
use App\Models\Driver;
use App\Models\Transaction;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Models\PasswordReset;
use Illuminate\Http\Request;

class OrderController extends BaseController
{


    public function order_details(Request $request)
    {
        $order = Order::where('id',$request->order_id)->first();
        if (!$order) {
            return response()->json([
                'status_code' => 404,
                'message' => 'order not found.'
            ], 404);
            }
        $order_data = Order::with('children','parent.user','parent.drivers','setter.user')->find($request->order_id);
        if($reques->input('type')=='parent'){
            $order_data->each(function ($order) {
                $order->parent->user->makeHidden('rates');
               $averageNumOfStars = $order->parent->user->rates->avg('num_of_stars');
               $order->parent->average_num_of_stars = $averageNumOfStars;
              });
        }

        else if($reques->input('type')=='setter'){
            $order_data->each(function ($order) {
                $order->setter->user->makeHidden('rates');
               $averageNumOfStars = $order->setter->user->rates->avg('num_of_stars');
               $order->setter->average_num_of_stars = $averageNumOfStars;
              });
        }

          return response()->json([
            'status_code' => 200,
            'order' => ($order_data)
        ], 200);
    }


    public function get_orders(Request $request)
    {

        $user = Auth::user();
        $setter = Setter::where('user_id',$user->id)->first();
        if (!$setter) {
            return response()->json([
                'status_code' => 404,
                'message' => 'setter not found.'
            ], 404);
            }
        $validator = Validator::make($request->all(), [
            'order_activity' => [
                'required',
                Rule::in(['new', 'current', 'finished']),
            ],
        ]);

        if ($validator->fails() != null) {
            return $this->apiErrorResponse($validator->errors()->first(), 409);
        }

        $order_data = Order::where('order_activity', $request->order_activity)
        ->where('setter_id', $setter->id)
        ->with('children', 'parent.user','parent.drivers', 'setter.user')
        ->get();
    if($reques->input('type')=='parent'){
        $order_data->each(function ($order) {
           $order->parent->user->makeHidden('rates');
           $averageNumOfStars = $order->parent->user->rates->avg('num_of_stars');
           $order->parent->average_num_of_stars = $averageNumOfStars;
          });
    }

    else if($reques->input('type')=='setter'){
        $order_data->each(function ($order) {
            $order->setter->user->makeHidden('rates');
           $averageNumOfStars = $order->setter->user->rates->avg('num_of_stars');
           $order->setter->average_num_of_stars = $averageNumOfStars;
          });
    }

          return response()->json([
            'status_code' => 200,
            'order' => ($order_data)
        ], 200);
    }
    public function set_order_status(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'status' => [
                'required',
                Rule::in(['accepted', 'rejected', 'started', 'completed','refused']),
            ],
        ]);

        if ($validator->fails() != null) {
            return $this->apiErrorResponse($validator->errors()->first(), 409);
        }

       // $order = Order::where('id',$request->order_id)->first();

        $order = Order::with('children','parent.user','setter.user')->find($request->order_id);

        if (!$order) {
            return response()->json([
                'status_code' => 404,
                'message' => 'order not found.'
            ], 404);
            }

        if($request->status=='started' || $request->status=='accepted'){
            $order->status=$request->status;
            $order->order_activity='current';
            $order->save();
        }

        else{
            if($request->status=='completed'){
               $amount= ($order->hours*$order->setter->hour_price)-$order->discount;
               $user_id_setter=$order->setter->user_id;
               $user_id_parent=$order->parent->user_id;
                 Transaction::create(['user_id'=>$user_id_setter,'amount'=>$amount,'type'=>'credit']);
                 Transaction::create(['user_id'=>$user_id_parent,'amount'=>$amount,'type'=>'debit']);

               }



            $order->status=$request->status;
            $order->order_activity='finished';
            $order->save();
        }

          return response()->json([
            'status_code' => 200,
            'order' => ($order)
        ], 200);
    }


    public function orders()
    {
        $orders = Order::all();

        return response()->json([
            'status_code' => 200,
            'orders' => ($orders)
        ], 200);
    }


    public function updateReceiveOrder(Request $request)
    {
        $user = Auth::user();
        $setter = Setter::where('user_id',$user->id)->first();

        if(! $setter){
            return response()->json([
                'status_code' => 404,
                'message' => 'setter not found.'
            ], 404);
        }
        $setter->receive_order = $request->input('receive_order');
        $setter->save();
        return response()->json([
            'status_code' => 200,
            'message' => 'Receive order status updated successfully',
        ], 200);
    }

    public function make_order(Request $request){


        $validator = Validator::make($request->all(), [
            'time' => 'required',
            'date' => 'required|date',
            'days' => 'required|integer',
            'long' => 'required|numeric',
            'lat' => 'required|numeric',
            'hours' => 'required|integer',
            'driver_id' => 'required|exists:drivers,id',
            'setter_id' => 'required|exists:setter,id',
            'discount' => 'numeric',
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



        $user = Auth::user();
        $parent = Parents::where('user_id',$user->id)->first();
        if(! $parent){
            return response()->json([
                'status_code' => 404,
                'message' => 'parent not found.'
            ], 404);
        }


        $new_order=new Order();
        $new_order->fill($request->all());
        $new_order->parent_id=$parent->id;
        $new_order->order_activity	="new";
        $new_order->status	=null;
        $array=json_decode($request->child_ids);
        $new_order->save();
        $new_order->childrens()->attach($array, ['created_at' => now(), 'updated_at' => now()]);

        return response()->json([
            'status_code' => 200,
            'order' => $new_order,

        ], 200);

    }
    public function my_orders_setters(){
        $user = Auth::user();
        $parent = Parents::where('user_id',$user->id)->first();
        if(! $parent){
            return response()->json([
                'status_code' => 404,
                'message' => 'parent not found.'
            ], 404);
        }
        $setterUsers = Order::where('parent_id', $parent->id)
        ->pluck('setter_id');
        $setters=Setter::whereIn('id',$setterUsers)->with('user')->get();
        return response()->json([
            'status_code' => 200,
            'setters' => $setters,

        ], 200);
    }

}
