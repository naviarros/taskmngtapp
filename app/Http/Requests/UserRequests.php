<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserRequests
{
    /**
     * Determine if the user is authorized to make this request.
     */

     public function authorize(Request $request)
     {
        $validator = Validator::make($request->all(), [
            'user_id' => 'numeric',
            'first_name' => 'required',
            'middle_name' => 'nullable',
            'last_name' => 'required',
            'password' => 'required',
            'user_status' => 'string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        return $validator;
     }
}
