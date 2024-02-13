<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Nursery;
use App\Models\Parents;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NurseryController  extends Controller
{

    protected $mainUrl = 'dashboard.nurseries.';
    protected $exceptionUrl = 'home';


    public function index(Request $request)
    {
        $nurseries =Nursery::paginate(10);
        return view('nursery.index', compact('nurseries'));
    }

    public function create()
    {
        return view('nursery.create');
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
        $nursery = Nursery::create($data);
        return redirect()->route( 'dashboard.nursery.index')->with('success', [
            'type' => 'success',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Nursery $nursery)
    {

        $data['resource'] = $nursery;
        return view($this->mainUrl . 'show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Nursery $nursery)
    {
        $resource = $nursery;
        return view('nursery.edit', compact('resource'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Nursery $nursery)
    {
        $data = $request->all();

        $nursery->update($data);

        return redirect()->route('dashboard.nursery.index');
    }

    public function destroy($id, Request $request)
    {
        $nursery = Nursery::where('id', $id)->first();

        $nursery->delete();

        return redirect()->route('dashboard.nursery.index');
    }
}
