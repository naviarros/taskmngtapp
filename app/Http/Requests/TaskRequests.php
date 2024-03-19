<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskRequests
{
    /**
     * Determine if the user is authorized to make this request.
     */

     public function authorize(Request $request)
     {
        $validator = Validator::make($request->all(), [
            'task_id' => 'numeric',
            'title' => 'required',
            'content' => 'required',
            'status' => 'required',
            'image_url' => 'nullable',
            'user_id' => 'nullable',
            'created_at' => 'datetime',
            'updated_at' => 'datetime'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        return $validator;
     }
}
