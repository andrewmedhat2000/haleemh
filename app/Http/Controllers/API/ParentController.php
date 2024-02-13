<?php

namespace App\Http\Controllers\API;
use App\Models\User;
use App\Models\Parents;
use App\Models\Setter;
use App\Models\Room;
use App\Models\Children;
use App\Models\Driver;
use App\Models\Favourite;
use App\Models\SetterCertificates;
use App\Models\UserRate;
use App\Models\Image;
use App\Models\RoomImages;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Models\PasswordReset;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use App\Models\Facility;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ParentController extends BaseController
{
    public function update_profile(Request $request)
    {
        DB::beginTransaction();
        try {


            $user = Auth::user();

            $validator = Validator::make($request->all(), [
                'email'    => 'email|unique:users,email,' . $user->id,
                'name'          => 'nullable|string',
               // 'phone'          => 'unique:users,phone,' . $user->id,
                'image'   => 'image',
                'nationality' => 'exists:countries,nationality',
                'long'          => 'numeric',
                'lat'          => 'numeric',
                'date_of_birth'          => 'date',
                'address'=>'string',
                'gender' => [
                    Rule::in(['male', 'female', 'ذكر', 'أنثى']),
                ],
                'national_id'=>'string',

            ]);

            if ($validator->fails() != null) {
                return $this->apiErrorResponse($validator->errors()->first(), 409);
            }

            $input = $request->only([
                'email', 'image', 'name', 'nationality', 'date_of_birth','national_id','address'
            ]);
            $parent_input = $request->except([
                'email', 'image', 'name', 'nationality', 'date_of_birth','national_id','address'
            ]);
            $old_user = User::where('id', $user->id)->first();
            $englishValues = [
                'ذكر' => 'male',
                'أنثى' => 'female',
                'female' => 'female',
                'male' => 'male',
            ];

            $englishValue = $englishValues[$request->input('gender')];

            // Now you can save the $englishValue to the database
            $old_user->update($input);
            $old_user->update([
                'gender' => $englishValue,
            ]);
            $output = User::where('id', $user->id)->first();
            $parent = Parents::where('user_id', $user->id)->first();
            $parent->update($parent_input);
            //$token = $this->generateNewToken($output,1);
            DB::commit();
            $data_show= User::select('users.*','parents.*')
            ->join('parents','parents.user_id','=','users.id')
            ->where('parents.id','=',$parent->id)
            ->first();

            return response()->json([
                'status_code' => 200,
                'message' => 'Updated successfully.',
                'user' => ($data_show)
            ], 200);

           // return $this->apiResponse(200, 'Updated successfully.', 'user', (new UserFullResponse($output)));
        } catch (\Exception $ex) {

            DB::rollback();
            Log::info('exception: ');
            Log::info($ex->getMessage());
            Log::info($ex);


            return response()->json([
                'status_code' => 409,
                'message' => 'Something Went Wrong',
                'info' => $ex->getMessage()
            ], 409);
        }
    }
    public function update_phone(Request $request){
        $user = Auth::user();
           $validator = Validator::make($request->all(), [

               'phone'          => 'unique:users,phone,' . $user->id,
               'phone_code'          => 'exists:countries,code'
           ]);

           if ($validator->fails() != null) {
               return $this->apiErrorResponse($validator->errors()->first(), 409);
           }

            // Generate a random verification code
   $verificationCode = rand(100000, 999999);

   // Calculate the expiry date for the verification code (e.g., 10 minutes from now)
   $expiryDate = now()->addMinutes(10);

   // Store the verification code and expiry date in the user's record
   $user->verification_code = $verificationCode;
   $user->verification_code_expiry = $expiryDate;
   $user->save();

   return response()->json([
       'status_code' => 200,
       'message' => 'sent successfully.',
       'code' => ($verificationCode)
   ], 200);


   }



   public function getChildrens()
{
    $user = Auth::user();
    $parent = Parents::where('user_id',$user->id)->first();

    if(! $parent){
        return response()->json([
            'status_code' => 404,
            'message' => 'parent not found.'
        ], 404);
    }
    $childrens = $parent->childrens()->get();


    return response()->json([
        'status_code' => 200,
        'childrens' => $childrens,
    ], 200);
}

public function addChildren(Request $request)
{
    // Retrieve the setter by ID
    $user = Auth::user();
    $parent = Parents::where('user_id',$user->id)->first();
    if(! $parent){
        return response()->json([
            'status_code' => 404,
            'message' => 'parent not found.'
        ], 404);
    }

    $validator = Validator::make($request->all(), [
        'name' => 'required|string',
        'image' => 'required|image',
        'date_of_birth' => 'required|date',
        'gender' => [
            'required',
            Rule::in(['male', 'female', 'ذكر', 'أنثى']),
        ],
        'hobby'=>'required|string',
        'is_diseased'=>'required|boolean',
        'disease' => 'string',
        'note'=>'string'

    ]);

    if ($validator->fails() != null) {
        return $this->apiErrorResponse($validator->errors()->first(), 409);
    }



    // Create a new certificate instance
    $children =  new Children($request->all());
    // Set other certificate properties based on your requirements
    // Associate the certificate with the setter
    $parent->childrens()->save($children);
    // Return a JSON response indicating success
    return response()->json([
        'status_code' => 200,
        'message' => 'children added successfully.',
    ], 200);
}

public function editChildren(Request $request)
{
    // Retrieve the certificate by ID
    $children = Children::find($request->input('id'));

    if(! $children){
        return response()->json([
            'status_code' => 404,
            'message' => 'children not found.'
        ], 404);
    }
    // Validate the request data
    $validator = Validator::make($request->all(), [
        'name' => 'string',
        'image' => 'image',
        'date_of_birth' => 'date',
        'gender' => [
            Rule::in(['male', 'female', 'ذكر', 'أنثى']),
        ],
        'hobby'=>'string',
        'is_diseased'=>'boolean',
        'disease' => 'string',
        'note'=>'string'

    ]);

    if ($validator->fails() != null) {
        return $this->apiErrorResponse($validator->errors()->first(), 409);
    }

    // Update the certificate with the new data
    $children->update($request->except('id'));
    $children->save();
    // Return a JSON response indicating success
    return response()->json([
        'status_code' => 200,
        'message' => 'children updated successfully.',
    ]);
}

public function deleteChildren($id)
{
    // Retrieve the certificate by ID
    $children = Children::find($id);
    if (! $children){
        return response()->json([
            'status_code' => 404,
            'message' => 'children not found.'
        ], 404);
    }
    // Delete the certificate
    $children->delete();

    // Return a JSON response indicating success
    return response()->json([
        'status_code' => 200,
        'message' => 'children deleted successfully.',
    ]);
}
public function getdrivers()
{
    $user = Auth::user();
    $parent = Parents::where('user_id',$user->id)->first();

    if(! $parent){
        return response()->json([
            'status_code' => 404,
            'message' => 'parent not found.'
        ], 404);
    }
    $drivers = $parent->drivers()->get();


    return response()->json([
        'status_code' => 200,
        'drivers' => $drivers,
    ], 200);
}



public function adddriver(Request $request)
{
    // Retrieve the setter by ID
    $user = Auth::user();
    $parent = Parents::where('user_id',$user->id)->first();
    if(! $parent){
        return response()->json([
            'status_code' => 404,
            'message' => 'parent not found.'
        ], 404);
    }

    $validator = Validator::make($request->all(), [
        'name' => 'required|string',
        'phone'=>'required|numeric|unique:drivers,phone',
        'email'=>'required|email|unique:drivers,email',
        'nationality' => 'exists:countries,nationality',
        'phone_code' => 'required|exists:countries,code',
        'image' => 'required|image',
        'date_of_birth' => 'required|date',
        'gender' => [
            'required',
            Rule::in(['male', 'female', 'ذكر', 'أنثى']),
        ],

    ]);

    if ($validator->fails() != null) {
        return $this->apiErrorResponse($validator->errors()->first(), 409);
    }



    // Create a new certificate instance
    $driver =  new Driver($request->all());
    // Set other certificate properties based on your requirements
    // Associate the certificate with the setter
    $parent->drivers()->save($driver);
    // Return a JSON response indicating success
    return response()->json([
        'status_code' => 200,
        'message' => 'driver added successfully.',
    ], 200);
}


public function editdriver(Request $request)
{
    // Retrieve the certificate by ID
    $driver = Driver::find($request->input('id'));

    if(! $driver){
        return response()->json([
            'status_code' => 404,
            'message' => 'driver not found.'
        ], 404);
    }
    // Validate the request data
    $validator = Validator::make($request->all(), [
        'name' => 'string',
        'phone'=>'numeric|unique:drivers,phone',
        'email'=>'email|unique:drivers,email',
        'nationality' => 'exists:countries,nationality',
        'phone_code' => 'exists:countries,code',
        'image' => 'image',
        'date_of_birth' => 'date',
        'gender' => [
            Rule::in(['male', 'female', 'ذكر', 'أنثى']),
        ],

    ]);

    if ($validator->fails() != null) {
        return $this->apiErrorResponse($validator->errors()->first(), 409);
    }

    // Update the certificate with the new data
    $driver->update($request->except('id'));
    $driver->save();
    // Return a JSON response indicating success
    return response()->json([
        'status_code' => 200,
        'message' => 'driver updated successfully.',
    ]);
}

public function deletedriver($id)
{
    // Retrieve the certificate by ID
    $driver = Driver::find($id);
    if (! $driver){
        return response()->json([
            'status_code' => 404,
            'message' => 'driver not found.'
        ], 404);
    }
    // Delete the certificate
    $driver->delete();

    // Return a JSON response indicating success
    return response()->json([
        'status_code' => 200,
        'message' => 'driver deleted successfully.',
    ]);
}



public function setter_details($id)
{
    $setter = Setter::find($id);
    if (!$setter) {
        return response()->json([
            'status_code' => 404,
            'message' => 'setter not found.'
        ], 404);
        }

      $setter_data = Setter::with('certificates','facility.rooms.rooms_images.image','user')->find($id);

      return response()->json([
        'status_code' => 200,
        'setter' => ($setter_data)
    ], 200);
}


public function add_rate(Request $request)
    {
        $user = User::find($request->id);
        if (!$user) {
            return response()->json([
                'status_code' => 404,
                'message' => 'user not found.'
            ], 404);
            }
        $request->validate([

        ]);
        $validator = Validator::make($request->all(), [
            'num_of_stars' => 'required|integer|between:1,5',
            'review' => 'required|string|max:255',
            'type' => [
                Rule::in(['setter', 'parent']),
            ],

        ]);

        if ($validator->fails() != null) {
            return $this->apiErrorResponse($validator->errors()->first(), 409);
        }
        $rate = new UserRate();
        $rate->num_of_stars = $request->input('num_of_stars');
        $rate->review = $request->input('review');
        $rate->user_id = $request->input('id');
        $rate->type = $request->input('type');
        $rate->save();
        return response()->json(['message' => 'Review created successfully'], 201);
    }



    public function reviews_details($id){
        $user = User::find($id);
        if (! $user) {
            return response()->json([
                'status_code' => 404,
                'message' => 'user not found.'
            ], 404);
        }

        $averageStars = DB::table('user_rates')
        ->where('user_id', $id)
        ->avg('num_of_stars');

    $reviews=UserRate::where('user_id', $id)->get();

    $data=[];
    // Round the average to 2 decimal places
    $averageStars = round($averageStars, 2);
        //SetterRate
    $data['averageStars']=$averageStars;
    $reviewCount = DB::table('user_rates')
        ->where('user_id', $id)
        ->count();
     $data['reviewCount']=$reviewCount;
     $data['reviews']=$reviews;

     return response()->json([
        'status_code' => 200,
        'reviews'=>$data,
    ]);
    }

public function make_favourite(Request $request)
{
    $user = Auth::user();
    $parent = Parents::where('user_id',$user->id)->first();
    if (! $parent) {
        return response()->json([
            'status_code' => 404,
            'message' => 'parent not found.'
        ], 404);
    }
    $setter = Setter::where('id',$request->input('setter_id'))->first();
    if (! $setter) {
        return response()->json([
            'status_code' => 404,
            'message' => 'setter not found.'
        ], 404);
    }

    $favorite = Favourite::create([
        'parent_id' => $parent->id,
        'setter_id' => $request->input('setter_id')
    ]);

    return response()->json([
        'status_code' => 200,
        'messege'=>"added to favourites",
    ]);
}


public function delete_favourite(Request $request)
{
    $user = Auth::user();
    $parent = Parents::where('user_id',$user->id)->first();
    if (! $parent) {
        return response()->json([
            'status_code' => 404,
            'message' => 'parent not found.'
        ], 404);
    }
    $setter = Setter::where('id',$request->input('setter_id'))->first();
    if (! $setter) {
        return response()->json([
            'status_code' => 404,
            'message' => 'setter not found.'
        ], 404);
    }

    Favourite::where('parent_id', $parent->id)
    ->where('setter_id', $request->input('setter_id'))
    ->delete();

    return response()->json([
        'status_code' => 200,
        'messege'=>"removed from favourites",
    ]);
}

public function get_my_favourites(){


    $user = Auth::user();
    $parent = Parents::where('user_id',$user->id)->first();
    if (! $parent) {
        return response()->json([
            'status_code' => 404,
            'message' => 'parent not found.'
        ], 404);
    }
    $favourites=Favourite::where('parent_id',$parent->id)->with('setter')->get();
    return response()->json([
        'status_code' => 200,
        'favourites'=>$favourites,
    ]);

}


public function get_setters(){
    $setters_data = Setter::with('user')->paginate(20);

    return response()->json([
        'status_code' => 200,
        'setters' => $setters_data->items(),
        'pagination' => [
            'current_page' => $setters_data->currentPage(),
            'total_pages' => $setters_data->lastPage(),
            'per_page' => $setters_data->perPage(),
            'total' => $setters_data->total(),
        ],
    ]);
}


public function filter(Request $request)
    {
        $query = Sitter::query();

        // Apply filters if provided
        if ($request->has('hour')) {
            $query->where('location', $request->input('location'));
        }

        if ($request->has('availability')) {
            $query->where('availability', $request->input('availability'));
        }

        // Retrieve the filtered sitters
        $sitters = $query->get();

        return response()->json($sitters);
    }

}
