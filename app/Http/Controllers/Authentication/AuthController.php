<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequests;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        try {
            $user = $this->user->where('email', $request->input('email'))->first();
            if ($user) {
                if (Hash::check($request->input('password'), $user->password)) {
                    $token = $user->createToken('Personal Access Token')->plainTextToken;

                    return response()->json([
                        'success' => true,
                        'data' => $user,
                        'bearer_token' => $token,
                        'server_response' => 'ok'
                    ]);
                } else {
                    return response()->json([
                     'success' => false,
                     'message' => 'Invalid password'
                    ]);
                }
            } else {

            }
        }
        catch (\Exception $e) {
            return response()->json([
             'message' => $e->getMessage()
            ], 500);
        }
    }
}
