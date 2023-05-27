<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Type extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'po_id',
        'name',
        'description',
        'status'
    ];

    //cast
    protected $casts = [
        'status' => 'integer',
    ];
}
