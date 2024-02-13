<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Room;
use App\Models\Image;
use App\Models\Parents;
use App\Models\Setter;
use App\Models\Facility;
use App\Models\RoomImages;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoomController extends Controller
{

    protected $mainUrl = 'dashboard.rooms.';
    protected $exceptionUrl = 'home';

    public function index(Request $request)
    {
        return redirect()->route( 'dashboard.setters.index')->with('success', [
            'type' => 'success',
        ]);
    }



    public function create(Request $request)
    {
        $setter=$request->setter;
        $facility=DB::table('facility')->pluck('name','name');
        return view('rooms.create',compact('facility','setter'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $data=$request->all();
        $room_data=$request->only('setter_id','name');
        $facility_id=Facility::where('name', $request->input('facility_id'))->value('id');
        $room_data['facility_id'] = $facility_id;
        $check_if_room_exsist=Room::where('name',$request->name)->where('setter_id',$request->setter_id)->first();
        $room_id=0;
        if(! $check_if_room_exsist){
            $room =Room::create($room_data);
            $room_id=$room->id;
        }
        else{
            $room_id= $check_if_room_exsist->id;
        }

        if ($request->file('images')) {
            foreach($data['images'] as $image){
                $image_model = Image::create(['image'=>$image]);
                $room_image=RoomImages::create(['image_id'=>$image_model->id,'room_id'=>$room_id]);

               // $image_model->ads()->attach($ads);
            }
        }

        return redirect()->route( 'dashboard.rooms.index')->with('success', [
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
    public function show($id)
    {
        $rooms = Room::where('id',$id)->first();
        $data['resource'] = $rooms;
        return view($this->mainUrl . 'show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $images = Image::where('id',$id)->first();
        return view('rooms.edit', compact('images'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $image = Image::find($id);
        $image->update($data);
        return redirect()->route( 'dashboard.rooms.index')->with('success', [
            'type' => 'success',
        ]);
    }

    public function destroy($id, Request $request)
    {
        $image = Image::find($id);

        $image->delete();

        return redirect()->route( 'dashboard.rooms.index')->with('success', [
            'type' => 'success',
        ]);
     }


}
