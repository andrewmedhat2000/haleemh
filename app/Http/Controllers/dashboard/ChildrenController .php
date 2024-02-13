<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Children;
use App\Models\Parents;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChildrenController extends Controller
{

    protected $mainUrl = 'dashboard.childrens.';
    protected $exceptionUrl = 'home';


    public function index(Request $request)
    {
        $data['collection'] = Children::paginate(10);
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


        $data = $request->all();

        $children = Children::create($data);

        return redirect()->route($this->mainUrl . 'index')->with('success', [
            'type' => 'success',
            'message' => 'Frame created successfully.'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Children $children)
    {

        $data['resource'] = $children;
        return view($this->mainUrl . 'show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Children $children)
    {
        $data['resource'] = $children;
        return view($this->mainUrl . 'edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Children $children)
    {
        $data = $request->all();

        $children->update($data);

        return redirect()->route($this->mainUrl . 'index');
    }

    public function destroy($id, Request $request)
    {
        $children = Children::where('id', $id)->first();

        $children->delete();

        return redirect()->route($this->mainUrl . 'index');
    }
}
