<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Bag;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BagController extends Controller
{
    public function index(Request $request)
    {
        $bags = Bag::where('po_id', auth()->user()->po_id)->where('created_at', Carbon::today()->toDateString())->first();
        return response()->json($bags, 200);
    }
    public function makeStore(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        if (Bag::where('po_id', auth()->user()->id)->whereDate('created_at', Carbon::today()->toDateString())->count()) return response()->json([
            'message' => 'Bag already created today',
            'status' => 203,
            'data' => '',
        ], 203);

        foreach ($request as $value) {
            $unique = uniqid();
            $number = Bag::whereDate('created_at', Carbon::today()->toDateString())->count() + 1;
            $bag = new Bag();
            $bag->bag_id = substr($unique, strlen($unique) - 4, strlen($unique)) . '-' . date('Ymd') . '-' . $number;
            $bag->po_id = auth()->user()->po_id;
            $bag->letter_id = $value->letter_ids;
            $bag->save();
        }


        return response()->json([
            'message' => 'Bag created successfully',
            'status' => 201,
            'data' => $bag,
        ], 201);
    }

    //update
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        foreach ($request as $value) {
            $bag = Bag::find($value->id);
            if ($bag) {
                $bag->letter_id = $value->letter_ids;
                $bag->save();
            }
            return response()->json([
                'message' => 'Bag successfully',
                'status' => 201,
                'data' => $bag,
            ], 201);
        }
        return response()->json([
            'message' => 'Bag not found',
            'status' => 203,
        ], 203);
    }
}
