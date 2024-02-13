<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Setter;
use App\Models\Parents;
use App\Models\Room;
use App\Models\SetterCertificates;
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


class SetterController extends BaseController
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
                'hint'          => 'nullable|string',
                'hour_price'          => 'numeric',
                'nationality' => 'exists:countries,nationality',
                'long'          => 'numeric',
                'lat'          => 'numeric',
                'date_of_birth'          => 'date',
                'gender' => [
                    Rule::in(['male', 'female', 'ذكر', 'أنثى']),
                ],
            ]);

            if ($validator->fails() != null) {
                return $this->apiErrorResponse($validator->errors()->first(), 409);
            }

            $input = $request->only([
                'email', 'image', 'name', 'nationality', 'date_of_birth'
            ]);
            $setter_input = $request->except([
                'email', 'image', 'name', 'nationality', 'date_of_birth', 'gender'
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
            $setter = Setter::where('user_id', $user->id)->first();
            $setter->update($setter_input);
            //$token = $this->generateNewToken($output,1);
            DB::commit();
            $data_show= User::select('users.*','setter.*')
            ->join('setter','setter.user_id','=','users.id')
            ->where('setter.id','=',$setter->id)
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


    public function profileDetails(Request $request)
    {
        try {

            $self = Auth::user();
            $user = $request->input('id') == $self->id
                ? $self
                : User::where('id', $request->get('id'))->first();

            if (!$user) {
                return response()->json([
                    'status_code' => 404,
                    'message' => 'Entity not found.'
                ], 404);
            }

            $data_show= User::select('users.*','setter.*')
            ->join('setter','setter.user_id','=','users.id')
            ->where('setter.user_id','=',$user->id)
            ->first();


            return response()->json([
                'status_code' => 200,
                'user' => ($data_show)
            ], 200);
        } catch (\Exception $ex) {
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

public function career_details(Request $request){

    try {

        $self = Auth::user();
        $user = $request->input('id') == $self->id
            ? $self
            : User::where('id', $request->get('id'))->first();

        if (!$user) {
            return response()->json([
                'status_code' => 404,
                'message' => 'Entity not found.'
            ], 404);
        }
        $setter=Setter::where('user_id',$user->id)->first();
        $certificates=SetterCertificates::where('setter_id',$setter->id)->get();
        $setter->certificates=$certificates;


        return response()->json([
            'status_code' => 200,
            'user' => ($setter)
        ], 200);
    } catch (\Exception $ex) {
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

public function update_career(Request $request){
    $user = Auth::user();
    $validator = Validator::make($request->all(), [
        'Professional_life' => [
            'required',
            Rule::in(['freelance', 'nursery', 'عمل حر', 'حضانة']),
        ],
    ]);
    if ($validator->fails() != null) {
        return $this->apiErrorResponse($validator->errors()->first(), 409);
    }
    $englishValues = [
        'عمل حر' => 'freelance',
        'حضانة' => 'nursery',
        'nursery' => 'nursery',
        'freelance' => 'freelance',

    ];

    $englishValue = $englishValues[$request->input('Professional_life')];

    // Now you can save the $englishValue to the database
    $setter=Setter::where('user_id',$user->id)->first();
    $setter->update([
        'Professional_life' => $englishValue,
    ]);
    return response()->json([
        'status_code' => 200,
        'user' => ($setter)
    ], 200);
}

public function getCertificates(Request $request)
{
    // Retrieve the setter by ID
    $user = Auth::user();
    $setter = Setter::where('user_id',$user->id)->first();

    if(! $setter){
        return response()->json([
            'status_code' => 404,
            'message' => 'setter not found.'
        ], 404);
    }
    // Retrieve the certificates associated with the setter
    $certificates = $setter->certificates()->get();

    // Return the certificates as a JSON response

    return response()->json([
        'status_code' => 200,
        'certificates' => $certificates,
    ], 200);
}

public function addCertificate(Request $request)
{
    // Retrieve the setter by ID
    $user = Auth::user();
    $setter = Setter::where('user_id',$user->id)->first();
    if(! $setter){
        return response()->json([
            'status_code' => 404,
            'message' => 'setter not found.'
        ], 404);
    }
    // Validate the request data
    $validatedData = $request->validate([
        'certificate_name' => 'required|string',
        'image' => 'required|image',
        // Add any additional validation rules for your certificate fields
    ]);

    // Create a new certificate instance
    $certificate = new SetterCertificates();
    $certificate->certificate_name = $validatedData['certificate_name'];
    $certificate->image = $validatedData['image'];
    // Set other certificate properties based on your requirements

    // Associate the certificate with the setter
    $setter->certificates()->save($certificate);

    // Return a JSON response indicating success
    return response()->json([
        'status_code' => 200,
        'message' => 'Certificate added successfully.',
    ], 200);
}

public function editCertificate(Request $request)
{
    // Retrieve the certificate by ID
    $certificate = SetterCertificates::find($request->input('id'));

    if(! $certificate){
        return response()->json([
            'status_code' => 404,
            'message' => 'certificate not found.'
        ], 404);
    }
    // Validate the request data
    $validatedData = $request->validate([
        'certificate_name' => 'string',
        'image' => 'image',
        // Add any additional validation rules for your certificate fields
    ]);


    // Update the certificate with the new data
    $certificate->certificate_name = $validatedData['certificate_name'];
    $certificate->image = $validatedData['certificate_name'];
    $certificate->save();
    // Return a JSON response indicating success
    return response()->json([
        'status_code' => 200,
        'message' => 'Certificate updated successfully.',
    ]);
}

public function deleteCertificate($id)
{
    // Retrieve the certificate by ID
    $certificate = SetterCertificates::find($id);
    if (! $certificate){
        return response()->json([
            'status_code' => 404,
            'message' => 'certificate not found.'
        ], 404);
    }
    // Delete the certificate
    $certificate->delete();

    // Return a JSON response indicating success
    return response()->json([
        'status_code' => 200,
        'message' => 'Certificate deleted successfully.',
    ]);
}







public function facility_details()
{
    $user = Auth::user();
    $setter = Setter::where('user_id',$user->id)->first();
    if (!$setter) {
        return response()->json([
            'status_code' => 404,
            'message' => 'setter not found.'
        ], 404);
        }
    $facility = Facility::where('setter_id',$setter->id)->first();


    if (!$facility) {
        return response()->json([
            'status_code' => 404,
            'message' => 'facility not found.'
        ], 404);
      }
      $facility_data = Facility::with('rooms.rooms_images.image')->find($facility->id);

      return response()->json([
        'status_code' => 200,
        'facility' => ($facility_data)
    ], 200);
}



public function add_facility_room(Request $request)
{
    $user = Auth::user();
    $setter = Setter::where('user_id',$user->id)->first();
    if (!$setter) {
        return response()->json([
            'status_code' => 404,
            'message' => 'setter not found.'
        ], 404);
        }
    $facility = Facility::where('setter_id',$setter->id)->first();

    if (!$facility) {
        return response()->json([
            'status_code' => 404,
            'message' => 'facility not found.'
        ], 404);
    }


    $room = new Room;
    $room->facility_id = $facility->id;
    $room->setter_id = $facility->setter_id;
    // Set other room attributes using $request data
    $room->name = $request->input('name');
    // Set other room attributes as needed
    $room->save();


    // Validate the request data
    $validatedData = $request->validate([
        'images.*' => 'required|image',
    ]);

    $images = $request->file('images');
    foreach ($images as $image) {
        // Store the image file
        $imagePath = $image;

        // Create the image record
        $imageRecord = new Image;
        $imageRecord->image = $imagePath;
        $imageRecord->save();

        // Create the room image record
        $roomImage = new RoomImages;
        $roomImage->room_id = $room->id;
        $roomImage->image_id = $imageRecord->id;
        $roomImage->save();
    }

    return response()->json([
        'status_code' => 200,
        'message' => 'Room added successfully.',
    ]);




}


public function get_all_rooms()
{
    $rooms = Room::all();

    return response()->json([
        'status_code' => 200,
        'data' => $rooms,
    ]);
}

public function get_all_facilities()
{
    $facilities = Facility::all();

    return response()->json([
        'status_code' => 200,
        'data' => $facilities,
    ]);
}

public function update_facility(Request $request){
    $user = Auth::user();
    $validator = Validator::make($request->all(), [
        'space' =>'string',
        'name' =>'string',
        'num_of_rooms'=>"numeric",
        'rent_contract'=>"image",
        'tax_id'=>"image"
    ]);
    if ($validator->fails() != null) {
        return $this->apiErrorResponse($validator->errors()->first(), 409);
    }


    // Now you can save the $englishValue to the database
    $facility=Facility::where('id',$request->input('facility_id'))->first();
    if (!$facility) {
        return response()->json([
            'status_code' => 404,
            'message' => 'facility not found.'
        ], 404);
    }

    $facility->update($request->all());

    return response()->json([
        'status_code' => 200,
        'facility' => ($facility)
    ], 200);
}


public function add_room_image(Request $request)
{
    $room=Room::where('id',$request->input('room_id'))->first();
    if (!$room) {
        return response()->json([
            'status_code' => 404,
            'message' => 'room not found.'
        ], 404);
    }
    $images_limit=RoomImages::where('room_id',$room->id)->get();
    if(count($images_limit)==5){
        return response()->json([
            'status_code' => 402,
            'message' => 'you can not add more images to this room.'
        ], 402);
    }
    $roomImage = new RoomImages;
    $roomImage->room_id = $request->input('room_id');

    // Validate the request data
    $validatedData = $request->validate([
        'image' => 'required|image',
    ]);

    // Store the image file
    $imagePath = $request->file('image');

    // Create the image record
    $image = new Image;
    $image->image = $imagePath;
    $image->save();

    $roomImage->image_id = $image->id;
    $roomImage->save();

    return response()->json([
        'status_code' => 200,
        'message' => 'room image added successfully.',
    ]);
}



public function delete_room_image(Request $request)
{
    $roomImage = RoomImages::where('room_id', $request->input('room_id'))
        ->where('image_id', $request->input('image_id'))
        ->first();

    if (!$roomImage) {
        return response()->json([
            'status_code' => 404,
            'message' => 'room image not found.'
        ], 404);
        }

    $image = Image::find( $request->input('image_id'));

    if (!$image) {
        return response()->json([
            'status_code' => 404,
            'message' => 'image not found.'
        ], 404);
        }

    // Delete the image file from storage
    $filePath='C:/Users/Andrew/Downloads/haleemh_dashboard/public/uploads/images/app/'.$image->image;
    //return $filePath;
    if(File::exists($filePath)) {
    File::delete($filePath);
    }

    // Delete the room image record
    $roomImage->delete();

    // Delete the image record if it is not associated with any other room images
        $image->delete();


    return response()->json([
        'status_code' => 200,
        'message' => 'room image deleted successfully.',
    ]);
}

public function get_room_images(Request $request){
    $room = Room::with('rooms_images.image')->find($request->room_id);
    if (!$room) {
        return response()->json([
            'status_code' => 404,
            'message' => 'room not found.'
        ], 404);
        }
        return response()->json([
            'status_code' => 200,
            'room' => ($room)
        ], 200);
}




public function add_room(Request $request)
{


    $user = Auth::user();
    $setter = Setter::where('user_id',$user->id)->first();
    if (!$setter) {
        return response()->json([
            'status_code' => 404,
            'message' => 'setter not found.'
        ], 404);
        }
    $facility=Facility::where('setter_id',$setter->id)->first();
    if (!$facility) {
        return response()->json([
            'status_code' => 404,
            'message' => 'facility not found.'
        ], 404);
        }
    // Validate the request data
    $validatedData = $request->validate([
        'name' => 'required|string',
        // Add other validation rules for room fields
    ]);
    // Create a new room
    $room = new Room();
    $room->setter_id = $setter->id;
    $room->name = $validatedData['name'];
    $room->facility_id = $facility->id;
    // Set other room fields based on your requirements

    // Save the room
    $room->save();

    // Return a response indicating successful room creation
    return response()->json([
        'message' => 'Room added successfully',
    ]);
}



public function add_facility(Request $request)
{


    $validator = Validator::make($request->all(), [
        'space' =>'string',
        'name' =>'string',
        'num_of_rooms'=>"numeric",
        'rent_contract'=>"image",
        'tax_id'=>"image"
    ]);
    if ($validator->fails() != null) {
        return $this->apiErrorResponse($validator->errors()->first(), 409);
    }


    $user = Auth::user();
    $setter = Setter::where('user_id',$user->id)->first();
    if (!$setter) {
        return response()->json([
            'status_code' => 404,
            'message' => 'setter not found.'
        ], 404);
        }
    $facility=Facility::where('setter_id',$setter->id)->first();
    if ($facility) {
        return response()->json([
            'status_code' => 404,
            'message' => 'facility is already exsist.'
        ], 404);
        }
    $data=$request->all();
    $data['setter_id']=$setter->id;
    Facility::create($data);
    // Return a response indicating successful room creation
    return response()->json([
        'message' => 'facility added successfully',
    ]);
}




public function edit_room(Request $request)
{
    $room=Room::where('id',$request->input('room_id'))->first();
    if (!$room) {
        return response()->json([
            'status_code' => 404,
            'message' => 'room not found.'
        ], 404);
    }
    $validator = Validator::make($request->all(), [
        'name' =>'required|string',
    ]);
    if ($validator->fails() != null) {
        return $this->apiErrorResponse($validator->errors()->first(), 409);
    }
    $room->update($request->all());
    return response()->json([
        'status_code' => 200,
        'message' => 'room updated successfully.',
    ]);
}


public function delete_room(Request $request)
{
    $room=Room::where('id',$request->input('room_id'))->first();
    if (!$room) {
        return response()->json([
            'status_code' => 404,
            'message' => 'room not found.'
        ], 404);
    }
    $roomImages = RoomImages::where('room_id', $request->input('room_id'))->get();
    foreach($roomImages as $roomImage){
        $image = Image::find($roomImage->image_id);
        $filePath='C:/Users/Andrew/Downloads/haleemh_dashboard/public/uploads/images/app/'.$image->image;
        $image->delete();
    //return $filePath;
    if(File::exists($filePath)) {
    File::delete($filePath);
    }
    }
    $room->delete();
    return response()->json([
        'status_code' => 200,
        'message' => 'room deleted successfully.',
    ]);
}



public function deactivateAccount($id)
{
    // Find the user by ID
    $user = User::find($id);
    if (! $user) {
        return response()->json([
            'status_code' => 404,
            'message' => 'user not found.'
        ], 404);
    }
    // Deactivate the user account
    $user->is_active = false;
    $user->save();

    // Optionally perform any other actions related to account deactivation

    // Return a response indicating successful deactivation
    return response()->json([
        'status_code' => 200,
        'message' => 'Account deactivated successfully',
    ]);
}
public function deleteAccount()
{
    $user = Auth::user();

    // Delete the user account
    $user->delete();

    // Optionally perform any other actions related to account deletion

    // Return a response indicating successful deletion
    return response()->json([
        'status_code' => 200,
        'message' => 'Account deleted successfully',
    ]);
}



}
