<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Facility;
use App\Models\Parents;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FacilityController  extends Controller
{

    protected $mainUrl = 'dashboard.facilities.';
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

        return view('facility.create',compact('setter'));
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
        $facility = Facility::create($data);

        return redirect()->route('dashboard.facility.index')->with('success', [
            'type' => 'success',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Facility $facility)
    {

        $data['resource'] = $facility;
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
        $facility = Facility::where('id',$id)->first();
        return view('facility.edit', compact('facility'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $id)
    {
        $data = $request->all();
        $facility = Facility::find($id);
        $facility->update($data);
        return redirect()->route( 'dashboard.facility.index')->with('success', [
            'type' => 'success',
        ]);
    }

    public function destroy($id, Request $request)
    {
        $facility = Facility::find($id);

        $facility->delete();

        return redirect()->route( 'dashboard.facility.index')->with('success', [
            'type' => 'success',
        ]);
    }
}
