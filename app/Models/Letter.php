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
        'letter_type',
        'isAd',
        'weight',
        'cost',
        'from',
        'next',
        'to',
        'status',
        'received_at',
    ];

    protected $casts = [
        'status' => 'integer',
    ];

    protected $appends = ['image_url', 'current_status'];

    public function getImageUrlAttribute()
    {
        return url('uploads/' . $this->file);
    }
    public function getCurrentStatusAttribute()
    {
        return $this->statusOption()[$this->status];
    }

    public function statusOption()
    {
        return [
            1 => 'Uploaded',
            2 => 'Received',
            3 => 'Delivering',
            4 => 'Delivered',
        ];
    }

    public function type()
    {
        return $this->hasOne(Type::class, 'id', 'type');
    }

    public function bag()
    {
        return $this->hasOne(Bag::class);
    }
}
