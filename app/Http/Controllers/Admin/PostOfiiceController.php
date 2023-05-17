<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PostOffice;
use Illuminate\Http\Request;

class PostOfiiceController extends Controller
{
    public function index(Request $request)
    {
        $postOffices = PostOffice::paginate($request->get('perPage', 10));
        return response()->json($postOffices, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $postOffices = new PostOffice();
        $postOffices->name = $request->name;
        $postOffices->address = $request->address;
        $postOffices->save();
        return response()->json([
            'message' => 'Post office created successfully',
            'status' => 201,
            'data' => $postOffices,
        ], 201);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $postOffices = PostOffice::find($id);
        if ($postOffices) {
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
