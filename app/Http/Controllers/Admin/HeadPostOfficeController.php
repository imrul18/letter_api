<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeadPostOffice;
use App\Models\PostOffice;
use Illuminate\Http\Request;

class HeadPostOfficeController extends Controller
{
    public function index(Request $request)
    {
        $postOffices = HeadPostOffice::with('zone')->where('name', 'like', '%' . $request->q . '%')->orWhere('code', 'like', '%' . $request->q . '%')->paginate($request->get('perPage', 10));
        return response()->json($postOffices, 200);
    }

    public function store(Request $request)
    {
        if (!$request->code) return response()->json([
            'message' => 'Head Post Office code is required',
            'status' => 203,
        ], 203);
        if (!$request->name) return response()->json([
            'message' => 'Head Post Office name is required',
            'status' => 203,
        ], 203);
        if (HeadPostOffice::where('code', $request->code)->count()) return response()->json([
            'message' => 'Head Post Office code already exists',
            'status' => 203,
        ], 203);

        $headPostOffices = new HeadPostOffice();
        $headPostOffices->code = $request->code;
        $headPostOffices->name = $request->name;
        $headPostOffices->zone_id = $request->zone_id;
        $headPostOffices->address = $request->address;
        $headPostOffices->save();

        $postOffices = new PostOffice();
        $postOffices->code = $request->code;
        $postOffices->name = $request->name;
        $postOffices->head_po_id = $headPostOffices->id;
        $postOffices->address = $request->address;
        $postOffices->save();

        return response()->json([
            'message' => 'Head Post Office created successfully',
            'status' => 201,
            'data' => $postOffices,
        ], 201);
    }

    public function show(string $id)
    {
        $postOffice = HeadPostOffice::find($id);
        return response()->json($postOffice, 200);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $postOffices = HeadPostOffice::find($id);
        if ($postOffices) {
            $postOffices->code = $request->code;
            $postOffices->name = $request->name;
            $postOffices->address = $request->address;
            $postOffices->save();
            return response()->json([
                'message' => 'Head Post Office updated successfully',
                'status' => 201,
                'data' => $postOffices,
            ], 201);
        }
        return response()->json([
            'message' => 'Head Post Office not found',
            'status' => 203,
        ], 203);
    }

    public function changeStatus(string $id)
    {
        $postOffices = HeadPostOffice::find($id);
        if ($postOffices) {
            $postOffices->status = !$postOffices->status;
            $postOffices->save();
            return response()->json([
                'message' => 'Head Post Office status changed successfully',
                'status' => 201,
            ], 201);
        }
        return response()->json([
            'message' => 'Head Post Office not found',
            'status' => 203,
        ], 203);
    }

    public function delete(string $id)
    {
        $postOffices = HeadPostOffice::find($id);
        if ($postOffices) {
            $postOffices->delete();
            return response()->json([
                'message' => 'Head Post Office deleted successfully',
                'status' => 201,
            ], 201);
        }
        return response()->json([
            'message' => 'Head Post Office not found',
            'status' => 203,
        ], 203);
    }
}
