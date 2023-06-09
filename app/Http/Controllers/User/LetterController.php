<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Bag;
use App\Models\Letter;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class LetterController extends Controller
{

    public function index(Request $request)
    {
        $letters = Letter::with('type')->where('from', auth()->user()->po_id)->where('letter_id', 'like', '%' . $request->q . '%')->whereDate('received_at', Carbon::parse($request->date)->toDateString())->paginate($request->get('perPage', 10));
        $isBag = Bag::where('po_id', auth()->user()->po_id)->whereDate('date', Carbon::parse($request->date)->toDateString())->exists();
        return response()->json(['data' => $letters, 'isBag' => $isBag], 200);
    }

    public function allLetter(Request $request)
    {
        $letters = Letter::with('type')->where('from', auth()->user()->po_id)->whereDate('received_at', Carbon::parse($request->bag_date)->toDateString())->get();

        $isBag = Bag::where('po_id', auth()->user()->po_id)->whereDate('date', Carbon::parse($request->bag_date)->toDateString())->exists();

        if ($isBag) {
            return response()->json([
                'message' => 'Bag already created for this date',
                'status' => 203,
                'data' => $letters,
            ], 203);
        }
        return response()->json($letters, 200);
    }

    public function bagLetter(string $id)
    {
        $bag = Bag::find($id);
        if (!$bag) return response()->json([
            'message' => 'Bag not found',
            'status' => 203,
            'data' => '',
        ], 203);
        $data = [];
        foreach ($bag->letter_id as $letter_id) {
            $data[] = Letter::with('type')->where('letter_id', $letter_id)->first();
        }
        $bag['letter'] = $data;
        return response()->json($bag, 200);
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|image',
            'sender_phone' => 'required',
            'receiver_phone' => 'required',
        ]);


        $unique = uniqid();
        $fileName = $unique . time() . '.' . $request->file->extension();


        $image = Image::make($request->file);
        $image->resize(400, 300, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        $image->save(public_path('uploads/' . $fileName));

        // $request->file->move(public_path('uploads'), $fileName);



        $number = Letter::whereDate('created_at', Carbon::today()->toDateString())->count() + 1;
        $letter = new Letter();
        $letter->file = $fileName;
        $letter->letter_id = substr($unique, strlen($unique) - 4, strlen($unique)) . '-' . date('Ymd') . '-' . $number;
        $letter->sender_phone = $request->sender_phone;
        $letter->receiver_phone = $request->receiver_phone;
        $letter->status = 'uploaded';
        $letter->save();
        return response()->json([
            'message' => 'File uploaded successfully',
            'status' => 201,
            'data' => $letter,
        ], 201);
    }

    public function findOption(Request $request)
    {
        $letter = Letter::where('status', 'uploaded')->where('letter_id', 'like', '%' . $request->q . '%')->get()->take(10);
        return response()->json($letter, 200);
    }

    public function show(string $id)
    {
        $letter = Letter::find($id);
        if ($letter) {
            return response()->json(
                $letter,
                200
            );
        }
    }

    public function update(Request $request, string $id)
    {
        if (!$request->type) {
            return response()->json([
                'message' => 'Type is required',
                'status' => 203,
            ], 203);
        }
        if (!$request->stamp_value) {
            return response()->json([
                'message' => 'Stamp Value is required',
                'status' => 203,
            ], 203);
        }
        $letter = Letter::find($id);
        $letter->status = 'received';
        $letter->stamp_value = $request->stamp_value;
        $letter->type = $request->type;
        $letter->next = $request->next;
        $letter->received_at = Carbon::now();
        $letter->from = auth()->user()->po_id;
        $letter->save();
        if ($letter) {
            return response()->json([
                'message' => 'Letter updated successfully',
                'status' => 201,
                'data' => '',
            ], 201);
        }
    }

    public function delivery(Request $request, string $id)
    {
        $letter = Letter::find($id);
        $letter->status = 'delivered';
        if ($letter) {
            return response()->json([
                'message' => '',
                'status' => 200,
                'data' => $letter,
            ], 200);
        }
    }
}
