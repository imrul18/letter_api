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
        $user = User::where('username', $request->username)->where('type', 1)->first();
        if (!$user) return response()->json([
            'message' => 'Account not found',
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

    public function userLogin(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
        $user = User::where('username', $request->username)->whereIn('type', [2, 3])->first();
        if (!$user) return response()->json([
            'message' => 'Account not found',
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

    public function deliveryLogin(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
        $user = User::where('username', $request->username)->where('type', 4)->first();
        if (!$user) return response()->json([
            'message' => 'Account not found',
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

    public function updatePassword(Request $request)
    {
        $user = User::find(auth()->user()->id);

        if (!Hash::check($request->old_password, $user->password)) return response()->json([
            'message' => 'Old password is incorrect',
            'status' => 203,
        ], 203);

        if ($request->old_password == $request->new_password) return response()->json([
            'message' => 'New password can not be same as old password',
            'status' => 203,
        ], 203);

        if ($request->new_password != $request->confirm_password) return response()->json([
            'message' => 'Password and confirm password does not match',
            'status' => 203,
        ], 203);

        $user->password = Hash::make($request->new_password);

        $user->save();
        return response()->json([
            'message' => 'Password updated successfully',
            'status' => 201,
        ], 201);
    }
}
