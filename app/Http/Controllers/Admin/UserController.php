<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeadPostOffice;
use App\Models\PostOffice;
use App\Models\User;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public $userType = [
        '1' => 'Admin',
        '2' => 'Counter',
        '3' => 'Manager',
        '4' => 'Post Man',
    ];

    public function index(Request $request)
    {
        $users = User::with('postOffice.headPostOffice.zone')
            ->where('username', 'like', '%' . $request->q . '%')
            ->paginate($request->get('perPage', 10));
        return response()->json($users, 200);
    }

    public function getUserName(Request $request)
    {
        $username = '';
        if ($request->zone_id && $request->head_id && $request->po_id && $request->type) {
            $zone = Zone::find($request->zone_id);
            $head_po = HeadPostOffice::find($request->head_id);
            $po = PostOffice::find($request->po_id);
            $count = User::count() + 1;
            $username = strtolower(substr($zone->name, 0, 1) . substr($head_po->name, 0, 1) . substr($po->name, 0, 1) .
                substr($this->userType[$request->type], 0, 1) . "_1" . str_pad($count, 8, '0', STR_PAD_LEFT));
        }
        return response()->json($username, 200);
    }

    public function store(Request $request)
    {
        if (!$request->username) return response()->json([
            'message' => 'Username is required',
            'status' => 203,
        ], 203);
        if (!$request->type) return response()->json([
            'message' => 'Type is required',
            'status' => 203,
        ], 203);
        if (!$request->zone_id) return response()->json([
            'message' => 'Zone is required',
            'status' => 203,
        ], 203);
        if (!$request->head_id) return response()->json([
            'message' => 'Head Post office is required',
            'status' => 203,
        ], 203);
        if (!$request->po_id) return response()->json([
            'message' => 'Post office is required',
            'status' => 203,
        ], 203);
        $user = new User();
        $user->username = $request->username;
        $user->password = Hash::make('123456');
        $user->type = $request->type;
        $user->po_id = $request->po_id;
        $user->status = true;
        $user->save();
        return response()->json([
            'message' => 'User created successfully',
            'status' => 201,
            'data' => $user,
        ], 201);
    }

    public function show(string $id)
    {
        $user = User::find($id);
        return response()->json($user, 200);
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
            $user->status = !$user->status;
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
