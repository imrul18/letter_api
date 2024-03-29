<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostOffice extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'head_po_id',
        'address',
        'status'
    ];

    protected $casts = [
        'status' => 'integer',
        'head_po_id' => 'integer',
    ];

    /**
     * Get all of the users for the PostOffice
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany(User::class, 'po_id');
    }

    /**
     * Get the headPostOffice that owns the PostOffice
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function headPostOffice()
    {
        return $this->belongsTo(HeadPostOffice::class, 'head_po_id', 'id');
    }
}
