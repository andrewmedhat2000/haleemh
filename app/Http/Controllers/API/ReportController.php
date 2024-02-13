<?php

namespace App\Http\Controllers\API;
use App\Models\Report;

use Illuminate\Http\Request;

class ReportController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function make_report(Request $request)
    {
        $request->validate([
            'problem' => 'required',
            'description' => 'required',
            'setter_id' => 'required|exists:setter,id',
            'parent_id' => 'required|exists:parents,id',
        ]);

        $report = Report::create($request->all());

        return response()->json([
            'message' => 'Report created successfully',
            'report' => $report
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
