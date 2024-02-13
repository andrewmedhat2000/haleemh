<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Setter;
use App\Models\Parents;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ParentController extends Controller
{
     //
     protected $mainUrl = 'dashboard.parents.';
     protected $exceptionUrl = 'home';


     public function index(Request $request)
     {
        $parents =Parents::paginate(10);
        $data['parents'] = $parents;
        return view($this->mainUrl . 'index', $data);
     }

     public function create()
     {
         return view($this->mainUrl . 'create');
     }


     /**
      * Store a newly created resource in storage.
      *
      * @param  \Illuminate\Http\Request  $request
      * @return \Illuminate\Http\Response
      */

     public function store(Request $request)
     {

         $data_user = $request->all();
         $user = User::create($data_user);
         $data_parent = $request->all();
         $data_parent['user_id'] = $user->id;
         $parent = new Parents($data_parent);
         $user->parent()->save($parent);
         return redirect()->route($this->mainUrl . 'index')->with('success', [
             'type' => 'success',
             'message' => 'user created successfully.'
         ]);
     }

     /**
      * Display the specified resource.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function show(Parents $parent)
     {
       $data_show= User::select('users.*','parents.*')
        ->join('parents','parents.user_id','=','users.id')
        ->where('parents.user_id','=',$parent->user_id)
        ->first();

        $data_show ->makeHidden(['user_id','role','password','created_at','updated_at','id']);
         $data['resource'] = $data_show;
         return view($this->mainUrl . 'show', $data);
     }

     /**
      * Show the form for editing the specified resource.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function edit(Parents $parent)
     {
        $data_show= User::select('users.*','parents.*')
        ->join('parents','parents.user_id','=','users.id')
        ->where('parents.user_id','=',$parent->user_id)
        ->first();
        $data_show ->makeHidden(['user_id','role','password','created_at','updated_at','id']);
         $data['resource'] = $data_show;
        return view($this->mainUrl . 'edit', $data);
     }

     /**
      * Update the specified resource in storage.
      *
      * @param  \Illuminate\Http\Request  $request
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function update(Request $request, Parents $parent)
     {

        $data_user = $request->all();
        $user = User::find($parent->user_id);
        $user->update($data_user);
        $data_parent = $request->all();
        $parent->update($data_parent);
         return redirect()->route($this->mainUrl . 'index');
     }

     public function destroy($id, Request $request)
     {
         $parent = Parents::where('id', $id)->first();
         $user = User::where('id', $parent->user_id)->first();
         $user->delete();
         return redirect()->route($this->mainUrl . 'index');
     }
}
