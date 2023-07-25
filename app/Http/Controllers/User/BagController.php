<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Bag;
use App\Models\Letter;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BagController extends Controller
{
    public function index(Request $request)
    {
        $bags = Bag::where('po_id', auth()->user()->po_id)->whereDate('date', Carbon::parse($request->date)->toDateString())->paginate($request->get('perPage', 10));
        $isBag = Bag::where('po_id', auth()->user()->po_id)->whereDate('date', Carbon::parse($request->date)->toDateString())->exists();
        if ($isBag) {
            $message = 'Bag already created for this date';
            $bags->getCollection()->transform(function ($bag) {
                $data = [];
                foreach ($bag->letter_id as $letter_id) {
                    $data[] = Letter::where('letter_id', $letter_id)->first();
                }
                $bag['letter'] = $data;
                return $bag;
            });
        } else {
            $letter = Letter::where('from', auth()->user()->po_id)->whereDate('received_at', Carbon::parse($request->date)->toDateString())->exists();
            if ($letter) {
                $message = null;
            } else {
                $message = 'No letter found for this date';
            }
        }
        return response()->json(['data' => $bags, 'isBag' => $isBag, 'message' => $message], 200);
    }
    public function makeStore(Request $request)
    {

        if (Bag::where('po_id', auth()->user()->id)->whereDate('date', Carbon::parse($request->bag_date)->toDateString())->count()) return response()->json([
            'message' => 'Bag already created today',
            'status' => 203,
            'data' => '',
        ], 203);

        foreach ($request->data as $value) {

            $unique = uniqid();
            $number = Bag::whereDate('date', Carbon::parse($request->bag_date)->toDateString())->count() + 1;

            $letterIds = [];
            foreach ($value['cards'] as $card) {
                $letterIds[] = $card['letter_id'];
            }
            $bag = new Bag();
            $bag->bag_id = substr($unique, strlen($unique) - 4, strlen($unique)) . '-' . date('Ymd') . '-' . $number;
            $bag->po_id = auth()->user()->po_id;
            $bag->date = Carbon::parse($request->bag_date)->toDateString();
            $bag->save();
            Letter::whereIn('id', $letterIds)->update(['bag_id' => $bag->id]);
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
