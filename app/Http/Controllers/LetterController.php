<?php

namespace App\Http\Controllers;

use App\Models\Letter;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LetterController extends Controller
{
    //file upload function name upload
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

    //get all letters function name getAll with base url for file
    public function getAll()
    {
        $letters = Letter::all();
        foreach ($letters as $letter) {
            $letter->file = url('uploads/' . $letter->file);
        }
        return response()->json([
            'message' => 'Letters fetched successfully',
            'status' => 200,
            'data' => $letters,
        ], 200);
    }
}
