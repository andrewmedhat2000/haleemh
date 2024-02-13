<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ValidateImage
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $validatedData = [
                'image' => $image,
            ];

            $rules = [
                'image' => 'image|mimes:png,jpeg,jpg|max:5120', // 5MB limit
            ];

            $validator = \Validator::make($validatedData, $rules);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Invalid image.',
                    'errors' => $validator->errors(),
                ], 422);
            }
        }
        else{
            return response()->json([
                'message' => 'Invalid image.',
            ], 422);
        }

        return $next($request);
    }
}
