<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PostOffice;
use Illuminate\Http\Request;

class PostOfiiceController extends Controller
{
    public function index(Request $request)
    {
        $postOffices = PostOffice::where('name', 'like', '%' . $request->q . '%')->orWhere('code', 'like', '%' . $request->q . '%')->paginate($request->get('perPage', 10));
        return response()->json($postOffices, 200);
    }

    public function store(Request $request)
    {
        if (!$request->code) return response()->json([
            'message' => 'Post office code is required',
            'status' => 203,
        ], 203);
        if (!$request->name) return response()->json([
            'message' => 'Post office name is required',
            'status' => 203,
        ], 203);
        if (PostOffice::where('code', $request->code)->count()) return response()->json([
            'message' => 'Post office code already exists',
            'status' => 203,
        ], 203);

        $postOffices = new PostOffice();
        $postOffices->code = $request->code;
        $postOffices->name = $request->name;
        $postOffices->address = $request->address;
        $postOffices->save();
        return response()->json([
            'message' => 'Post office created successfully',
            'status' => 201,
            'data' => $postOffices,
        ], 201);
    }

    public function show(string $id)
    {
        $postOffice = PostOffice::find($id);
        return response()->json($postOffice, 200);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $postOffices = PostOffice::find($id);
        if ($postOffices) {
            $postOffices->code = $request->code;
            $postOffices->name = $request->name;
            $postOffices->address = $request->address;
            $postOffices->save();
            return response()->json([
                'message' => 'Post office updated successfully',
                'status' => 201,
                'data' => $postOffices,
            ], 201);
        }
        return response()->json([
            'message' => 'Post office not found',
            'status' => 203,
        ], 203);
    }

    public function changeStatus(string $id)
    {
        $postOffices = PostOffice::find($id);
        if ($postOffices) {
            $postOffices->status = !$postOffices->status;
            $postOffices->save();
            return response()->json([
                'message' => 'Post office status changed successfully',
                'status' => 201,
            ], 201);
        }
        return response()->json([
            'message' => 'Post office not found',
            'status' => 203,
        ], 203);
    }

    public function delete(string $id)
    {
        $postOffices = PostOffice::find($id);
        if ($postOffices) {
            $postOffices->delete();
            return response()->json([
                'message' => 'Post office deleted successfully',
                'status' => 201,
            ], 201);
        }
        return response()->json([
            'message' => 'Post office not found',
            'status' => 203,
        ], 203);
    }
}
