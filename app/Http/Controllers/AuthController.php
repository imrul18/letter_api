<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //login function name adminLogin
    public function adminLogin(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
        $user = User::where('username', $request->username)->where('type', 'admin')->first();
        if (!$user) return response()->json([
            'message' => 'User not found',
            'status' => 203,
        ], 203);
        if (!Hash::check($request->password, $user->password)) return response()->json([
            'message' => 'Password is incorrect',
            'status' => 203,
        ], 203);


        $user->token = $user->createToken('admin-token')->plainTextToken;
        return response()->json([
            'message' => 'Login successful',
            'status' => 200,
            'data' => $user,
        ], 200);
    }

    public function adminUser(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
        $user = User::where('username', $request->username)->where('type', 'user')->first();
        if (!$user) return response()->json([
            'message' => 'User not found',
            'status' => 203,
        ], 203);
        if (!Hash::check($request->password, $user->password)) return response()->json([
            'message' => 'Password is incorrect',
            'status' => 203,
        ], 203);


        $user->token = $user->createToken('user-token')->plainTextToken;
        return response()->json([
            'message' => 'Login successful',
            'status' => 200,
            'data' => $user,
        ], 200);
    }

    public function loginDelivery(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
        $user = User::where('username', $request->username)->where('type', 'delivery')->first();
        if (!$user) return response()->json([
            'message' => 'User not found',
            'status' => 203,
        ], 203);
        if (!Hash::check($request->password, $user->password)) return response()->json([
            'message' => 'Password is incorrect',
            'status' => 203,
        ], 203);


        $user->token = $user->createToken('delivery-token')->plainTextToken;
        return response()->json([
            'message' => 'Login successful',
            'status' => 200,
            'data' => $user,
        ], 200);
    }
}
