<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'password',
        'type',
        'po_id',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = ['user_type'];
    public function getUserTypeAttribute()
    {
        return $this->userType[$this->type];
    }

    protected $casts = [
        'email_verified_at' => 'datetime',
        'status' => 'integer',
        'po_id' => 'integer',
        'type' => 'integer',
    ];

    public $userType = [
        '1' => 'Admin',
        '2' => 'Counter',
        '3' => 'Manager',
        '4' => 'Post Man',
    ];



    /**
     * Get the postOffice that owns the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function postOffice()
    {
        return $this->belongsTo(PostOffice::class, 'po_id', 'id');
    }
}
