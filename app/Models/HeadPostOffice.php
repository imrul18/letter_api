<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeadPostOffice extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'zone_id',
        'address',
        'status'
    ];

    protected $casts = [
        'status' => 'integer',
    ];

    /**
     * Get all of the postOffices for the HeadPostOffice
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */

    public function postOffices()
    {
        return $this->hasMany(PostOffice::class, 'head_po_id');
    }

    /**
     * Get the zone that owns the HeadPostOffice
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function zone()
    {
        return $this->belongsTo(Zone::class, 'zone_id', 'id');
    }
}
