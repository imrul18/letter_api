<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Letter;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LetterController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|image|max:2048',
            'sender_phone' => 'required',
            'receiver_phone' => 'required',
        ]);
        $unique = uniqid();
        $fileName = $unique . time() . '.' . $request->file->extension();
        $request->file->move(public_path('uploads'), $fileName);
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
        $letter = Letter::where('letter_id', 'like', strval($request->q) . '%')->get()->take(10);
        $letter->transform(function ($user) {
            return [
                'label' => $user->letter_id,
                'value' => $user->id,
            ];
        });
        return response()->json([
            'message' => '',
            'data' => $letter,
            'status' => 203,
        ], 203);
    }

    public function show(string $id)
    {
        $letter = Letter::find($id);
        if ($letter) {
            $letter->file = url('uploads/' . $letter->file);
            return response()->json([
                'message' => '',
                'status' => 200,
                'data' => $letter,
            ], 200);
        }
    }

    public function update(Request $request, string $id)
    {
        $letter = Letter::find($id);
        $letter->status = 'received';
        $letter->stamp_value = $request->stamp_value;
        $letter->type = $request->type;
        if ($letter) {
            $letter->file = url('uploads/' . $letter->file);
            return response()->json([
                'message' => '',
                'status' => 200,
                'data' => $letter,
            ], 200);
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
