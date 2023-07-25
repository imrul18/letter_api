<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'address',
        'status'
    ];

    protected $casts = [
        'status' => 'integer',
    ];

    /**
     * Get all of the headPostOffices for the Zone
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function headPostOffices(): HasMany
    {
        return $this->hasMany(HeadPostOffice::class, 'zone_id');
    }
}
