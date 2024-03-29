<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bag extends Model
{
    use HasFactory;

    protected $fillable = [
        'po_id',
        'bag_id',
        'date',
    ];

    protected $casts = [
        'letter_id' => 'array',
    ];

    public function letters()
    {
        return $this->hasMany(Letter::class);
    }
}
