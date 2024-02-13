<?php

namespace App\Http\Controllers\API;


use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SettingsController extends BaseController
{
    public function index()
    {
        $settings = Settings::all();

        return response()->json($settings);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'about_en' => 'required|string',
            'about_ar' => 'required|string',
            'policy_en' => 'required|string',
            'policy_ar' => 'required|string',
            'cancellation_fees' => 'required|numeric',
            ]);

        if ($validator->fails() != null) {
            return $this->apiErrorResponse($validator->errors()->first(), 409);
        }

        $settings = Settings::create($request->all());

        return response()->json($settings, 200);
    }

    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'about_en' => 'required|string',
            'about_ar' => 'required|string',
            'policy_en' => 'required|string',
            'policy_ar' => 'required|string',
            'cancellation_fees' => 'required|numeric',
            ]);

        if ($validator->fails() != null) {
            return $this->apiErrorResponse($validator->errors()->first(), 409);
        }

        $settings = Settings::find($id);
        if (! $settings) {
            return response()->json([
                'status_code' => 404,
                'message' => 'not found.'
            ], 404);
            }
        $settings->update($request->all());

        return response()->json($settings, 200);
    }

    public function destroy($id)
    {
        $settings = Settings::findOrFail($id);
        $settings->delete();

        return response()->json("deleted successfully", 200);
    }
    
}
