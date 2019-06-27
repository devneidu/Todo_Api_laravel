<?php

namespace App\Http\Controllers;

use App\User;
use Validator;
use Tymon\JWTAuth\JWTAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    protected $auth;

    public function __construct(JWTAuth $auth)
    {
        $this->auth = $auth;
    }

    public function user(Request $request)
    {
        return response()->json([
            'success' => true,
            'data' => $request->user()
        ], 200);
    }

    public function logout()
    {
        $this->auth->invalidate();

        $response = [
            'success' => true,
            'message' => 'Logged out successfully'
        ];

        return response()->json($response, 200);
    }
    
    
}
