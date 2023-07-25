<?php

namespace App\Http\Controllers;

use App\Models\HeadPostOffice;
use App\Models\PostOffice;
use App\Models\Type;
use App\Models\Zone;
use Illuminate\Http\Request;

class OptionController extends Controller
{
    public function zone()
    {
        $items = Zone::where('status', 1)->get();
        $data = [];
        foreach ($items as $item) {
            $data[] = [
                'value' => $item->id,
                'label' => $item->code . '-' . $item->name,
            ];
        }
        return response()->json($data, 200);
    }

    public function headPostOffice(string $id)
    {
        $items = HeadPostOffice::where('status', 1)->where('zone_id', $id)->get();
        $data = [];
        foreach ($items as $item) {
            $data[] = [
                'value' => $item->id,
                'label' => $item->code . '-' . $item->name,
            ];
        }
        return response()->json($data, 200);
    }

    public function postOffice(string $id)
    {
        $items = PostOffice::where('status', 1)->where('head_po_id', $id)->get();
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
        $items = Type::where('status', 1)->get();
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
