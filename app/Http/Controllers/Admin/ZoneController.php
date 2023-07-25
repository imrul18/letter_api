<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Zone;
use Illuminate\Http\Request;

class ZoneController extends Controller
{
    public function index(Request $request)
    {
        $zones = Zone::where('name', 'like', '%' . $request->q . '%')->orWhere('code', 'like', '%' . $request->q . '%')->paginate($request->get('perPage', 10));
        return response()->json($zones, 200);
    }

    public function store(Request $request)
    {
        if (!$request->code) return response()->json([
            'message' => 'Zone code is required',
            'status' => 203,
        ], 203);
        if (!$request->name) return response()->json([
            'message' => 'Zone name is required',
            'status' => 203,
        ], 203);
        if (Zone::where('code', $request->code)->count()) return response()->json([
            'message' => 'Zone code already exists',
            'status' => 203,
        ], 203);

        $zone = new Zone();
        $zone->code = $request->code;
        $zone->name = $request->name;
        $zone->address = $request->address;
        $zone->save();
        return response()->json([
            'message' => 'Zone created successfully',
            'status' => 201,
            'data' => $zone,
        ], 201);
    }

    public function show(string $id)
    {
        $zone = Zone::find($id);
        return response()->json($zone, 200);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $zone = Zone::find($id);
        if ($zone) {
            $zone->code = $request->code;
            $zone->name = $request->name;
            $zone->address = $request->address;
            $zone->save();
            return response()->json([
                'message' => 'Zone updated successfully',
                'status' => 201,
                'data' => $zone,
            ], 201);
        }
        return response()->json([
            'message' => 'Zone not found',
            'status' => 203,
        ], 203);
    }

    public function changeStatus(string $id)
    {
        $zone = Zone::find($id);
        if ($zone) {
            $zone->status = !$zone->status;
            $zone->save();
            return response()->json([
                'message' => 'Zone status changed successfully',
                'status' => 201,
            ], 201);
        }
        return response()->json([
            'message' => 'Zone not found',
            'status' => 203,
        ], 203);
    }

    public function delete(string $id)
    {
        $zone = Zone::find($id);
        if ($zone) {
            $zone->delete();
            return response()->json([
                'message' => 'Zone deleted successfully',
                'status' => 201,
            ], 201);
        }
        return response()->json([
            'message' => 'Zone not found',
            'status' => 203,
        ], 203);
    }
}
