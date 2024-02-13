<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Setter;
use App\Models\Nursery;
use App\Models\Image;
use App\Models\Facility;
use App\Models\SetterCertificates;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Routing\Annotation\Route;

class SetterController extends Controller
{
     //
     protected $mainUrl = 'dashboard.setters.';
     protected $exceptionUrl = 'home';


     public function index(Request $request)
     {
        $setters =Setter::paginate(10);
        return view('setters.index', compact('setters'));
     }

     public function create()
     {
        $nurseries=DB::table('nursery')->pluck('name','name');
        return view('setters.create',compact('nurseries'));
     }


     /**
      * Store a newly created resource in storage.
      *
      * @param  \Illuminate\Http\Request  $request
      * @return \Illuminate\Http\Response
      */

     public function store(Request $request)
     {
         $data_user = $request->except('hour_price', 'long','lat','hint','Professional_life','nursery_id');
         $user = User::create($data_user);
         $data_setter = $request->only('hour_price', 'long','lat','hint','Professional_life');
         if($request->input('Professional_life')=='nursery'){
            $nursery_id=Nursery::where('name', $request->input('nursery_id'))->value('id');
            $data_setter['nursery_id'] = $nursery_id;
         }
         $data_setter['user_id'] = $user->id;
         $setter = new Setter($data_setter);
         $user->setter()->save($setter);
         return redirect()->route( 'dashboard.setters.index')->with('success', [
            'type' => 'success',
            'message' => 'setter created successfully.'
        ]);
     }

     /**
      * Display the specified resource.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function show(Setter $setter)
     {
       $data_show= User::select('users.*','setter.*')
        ->join('setter','setter.user_id','=','users.id')
        ->where('setter.user_id','=',$setter->user_id)
        ->first();

        $data_show ->makeHidden(['user_id','completed_orders','role','password','created_at','updated_at','id']);
         $data['resource'] = $data_show;
         return view($this->mainUrl . 'show', $data);
     }

     /**
      * Show the form for editing the specified resource.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function edit(Setter $setter)
     {
        $nurseries=DB::table('nursery')->pluck('name','name');
        $resource = $setter;
        return view('setters.edit', compact(['resource','nurseries']));
     }



      public function user_details(Request $request)
      {
        $setter_id = $request->input('data');
        $users= User::select('users.*')
            ->join('setter', 'users.id', '=', 'setter.user_id')
            ->where('setter.id', '=', $setter_id)
            ->get();
        $users ->makeHidden(['password','created_at','updated_at']);

        return view('users.index', compact('users'));

      }
      public function nursery_details(Request $request)
      {
        $setter_id = $request->input('data');
        $nurseries= Nursery::select('nursery.*')
            ->join('setter', 'nursery.id', '=', 'setter.nursery_id')
            ->where('setter.id', '=', $setter_id)
            ->get();
        return view('nursery.index', compact('nurseries'));

      }
      public function room_details(Request $request)
      {
        $setter_id = $request->input('data');
        $rooms= Image::select('images.*','rooms.name','rooms.id as room_id')
            ->join('room_images', 'images.id', '=', 'room_images.image_id')
            ->join('rooms', 'rooms.id', '=', 'room_images.room_id')
            ->join('setter', 'setter.id', '=', 'rooms.setter_id')
            ->where('setter.id', '=', $setter_id)
            ->get();
        return view('rooms.index', compact('rooms','setter_id'));

      }
      public function certificates_details(Request $request)
      {
        $setter_id = $request->input('data');
        $certificates= SetterCertificates::select('certificates.*')
            ->join('setter', 'certificates.setter_id', '=', 'setter.id')
            ->where('setter.id', '=', $setter_id)
            ->get();
        return view('certificates.index', compact('certificates','setter_id'));

      }

      public function facility_details(Request $request)
      {
        $setter_id = $request->input('data');
        $facilities= Facility::select('facility.*')
            ->join('setter', 'facility.setter_id', '=', 'setter.id')
            ->where('setter.id', '=', $setter_id)
            ->get();
        return view('facility.index', compact('facilities','setter_id'));

      }


      
     /**
      * Update the specified resource in storage.
      *
      * @param  \Illuminate\Http\Request  $request
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function update(Request $request, Setter $setter)
     {

        $data_user = $request->except('hour_price', 'long','lat','hint','Professional_life','nursery_id');
         $data_setter = $request->only('hour_price', 'long','lat','hint','Professional_life');
         if($request->input('Professional_life')=='nursery'){
            $nursery_id=Nursery::where('name', $request->input('nursery_id'))->value('id');
            $data_setter['nursery_id'] = $nursery_id;
         }
         $setter->update($data_setter);
         $user = User::find($setter->user_id);
         $user->update($data_user);
         return redirect()->route( 'dashboard.setters.index')->with('success', [
            'type' => 'success',
            'message' => 'setter created successfully.'
        ]);
     }

     public function destroy($id, Request $request)
     {
         $setter = Setter::where('id', $id)->first();
         $user = User::where('id', $setter->user_id)->first();
         $user->delete();
         return redirect()->route('dashboard.setters.index');
     }
}
