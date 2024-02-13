<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
     //
     protected $mainUrl = 'dashboard.users.';
     protected $exceptionUrl = 'home';


     public function index(Request $request)
     {
        $users =User::where('role','user')->paginate();
        $data['users'] = $users;
        return view('users.index', compact('users'));
     }

     public function create()
     {
        return view('users.create');
     }


     /**
      * Store a newly created resource in storage.
      *
      * @param  \Illuminate\Http\Request  $request
      * @return \Illuminate\Http\Response
      */

     public function store(Request $request)
     {

         $data = $request->all();

         $user = User::create($data);
         return redirect()->route( 'dashboard.users.index')->with('success', [
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
     public function show(User $user)
     {

         $resource = $user;
         return view('users.show', compact('resource'));
        }

     /**
      * Show the form for editing the specified resource.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function edit(User $user)
     {
        $resource = $user;
        return view('users.edit', compact('resource'));
    }

     /**
      * Update the specified resource in storage.
      *
      * @param  \Illuminate\Http\Request  $request
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function update(Request $request, User $user)
     {
         $data = $request->all();

         $user->update($data);

         return redirect()->route('dashboard.users.index');
     }

     public function destroy($id, Request $request)
     {
         $user = User::where('id', $id)->first();

         $user->delete();

         return redirect()->route('dashboard.users.index');
     }
}
