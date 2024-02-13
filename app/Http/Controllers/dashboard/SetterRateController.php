<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\SetterRate;
use App\Models\Parents;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SetterRateController  extends Controller
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

        return view('setter_rates.create',compact('setter'));
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
        $setter_rates = SetterRate::create($data);

        return redirect()->route('dashboard.setter_rate.index')->with('success', [
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
        $setter_rate = SetterRate::where('id',$id)->first();
        return view('setter_rates.edit', compact('setter_rate'));
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
        $setter_rate = SetterRate::find($id);
        $setter_rate->update($data);
        return redirect()->route( 'dashboard.setter_rate.index')->with('success', [
            'type' => 'success',
        ]);
    }

    public function destroy($id, Request $request)
    {
        $setter_rate = SetterRate::find($id);

        $setter_rate->delete();

        return redirect()->route( 'dashboard.setter_rate.index')->with('success', [
            'type' => 'success',
        ]);
    }
}
