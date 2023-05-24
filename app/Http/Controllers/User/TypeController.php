<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Type;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    public function index(Request $request)
    {
        $types = Type::where('po_id', auth()->user()->po_id)->where('name', 'like', '%' . $request->q . '%')->paginate($request->get('perPage', 10));
        return response()->json($types, 200);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $type = new Type();
        $type->name = $request->name;
        $type->description = $request->description;
        $type->po_id = auth()->user()->po_id;
        $type->save();
        return response()->json([
            'message' => 'Type created successfully',
            'status' => 201,
            'data' => $type,
        ], 201);
    }

    public function show(string $id)
    {
        $user = Type::find($id);
        return response()->json($user, 200);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $type = Type::find($id);
        if ($type) {
            $type->name = $request->name;
            $type->description = $request->description;
            $type->save();
            return response()->json([
                'message' => 'Type successfully',
                'status' => 201,
                'data' => $type,
            ], 201);
        }
        return response()->json([
            'message' => 'Type not found',
            'status' => 203,
        ], 203);
    }

    public function changeStatus(string $id)
    {
        $user = Type::find($id);
        if ($user) {
            $user->status = !$user->status;
            $user->save();
            return response()->json([
                'message' => 'Type status changed successfully',
                'status' => 201,
            ], 201);
        }
        return response()->json([
            'message' => 'Type not found',
            'status' => 203,
        ], 203);
    }

    public function delete(string $id)
    {
        $type = Type::find($id);
        if ($type) {
            $type->delete();
            return response()->json([
                'message' => 'Type deleted successfully',
                'status' => 201,
            ], 201);
        }
        return response()->json([
            'message' => 'Type not found',
            'status' => 203,
        ], 203);
    }
}
