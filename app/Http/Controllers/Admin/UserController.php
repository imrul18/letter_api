<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::paginate($request->per_page, 10);
        return response()->json($users, 200);
    }
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'type' => 'required',
            'po_id' => 'required',
        ]);
        $user = new User();
        $user->username = $request->username;
        $user->password = Hash::make('123456');
        $user->type = $request->type;
        $user->po_id = $request->po_id;
        $user->status = 'active';
        $user->save();
        return response()->json([
            'message' => 'Post office created successfully',
            'status' => 201,
            'data' => $user,
        ], 201);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'username' => 'required',
            'type' => 'required',
            'po_id' => 'required',
        ]);
        $user = User::find($id);
        if ($user) {
            $user->username = $request->username;
            $user->type = $request->type;
            $user->po_id = $request->po_id;
            $user->save();
            return response()->json([
                'message' => 'User updated successfully',
                'status' => 201,
                'data' => $user,
            ], 201);
        }
        return response()->json([
            'message' => 'User not found',
            'status' => 203,
        ], 203);
    }

    public function changeStatus(string $id)
    {
        $user = User::find($id);
        if ($user) {
            $user->status = $user->status === 'active' ? 'inactive' : 'active';
            $user->save();
            return response()->json([
                'message' => 'User status changed successfully',
                'status' => 201,
            ], 201);
        }
        return response()->json([
            'message' => 'User not found',
            'status' => 203,
        ], 203);
    }


    public function delete(string $id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            return response()->json([
                'message' => 'User deleted successfully',
                'status' => 201,
            ], 201);
        }
        return response()->json([
            'message' => 'User not found',
            'status' => 203,
        ], 203);
    }
}
