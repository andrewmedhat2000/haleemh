<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\Country;
class CountryController extends BaseController
{
    public function getcontries(Request $request)
    {

        try {

            $contries = Country::get();

            return response()->json([
                'status_code' => 200,
                'contries' => $contries,
            ], 200);
        } catch (\Exception $ex) {

            DB::rollback();

            Log::info('exception: ');
            Log::info($ex->getMessage());
            Log::info($ex);

            return response()->json([
                'status_code' => 407,
                'message' => 'Something Went Wrong',
                'info' => $ex->getMessage()
            ], 407);
        }
    }


}
