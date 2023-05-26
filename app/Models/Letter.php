<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Letter extends Model
{
    use HasFactory;

    protected $fillable = [
        'letter_id',
        'bag_id',
        'type',
        'file',
        'sender_phone',
        'receiver_phone',
        'stamp_value',
        'from',
        'next',
        'to',
        'status',
        'received_at',
    ];

    // appending image url
    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        return url('uploads/' . $this->file);
    }

    public function type()
    {
        return $this->hasOne(Type::class, 'id', 'type');
    }
}
