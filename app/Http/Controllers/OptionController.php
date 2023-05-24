<?php

namespace App\Http\Controllers;

use App\Models\PostOffice;
use App\Models\Type;
use Illuminate\Http\Request;

class OptionController extends Controller
{

    public function postOffice()
    {
        $items = PostOffice::where('status', 1)->get();
        $data = [];
        foreach ($items as $item) {
            $data[] = [
                'value' => $item->id,
                'label' => $item->code . '-' . $item->name,
            ];
        }
        return response()->json($data, 200);
    }

    public function type()
    {
        $items = Type::where('po_id', auth()->user()->po_id)->where('status', 1)->get();
        $data = [];
        foreach ($items as $item) {
            $data[] = [
                'value' => $item->id,
                'label' => $item->name,
            ];
        }
        return response()->json($data, 200);
    }
}
