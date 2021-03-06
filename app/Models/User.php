<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'api_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function groups(){
        return $this->belongsToMany(Group::class);
    }

    public function occurrences(){
        return $this->belongsToMany(Occurrence::class)->withPivot('opened','status');
    }

    public function getLocationsByOccurrence(Occurrence $occurrence){
        return $this->hasMany(Userlocation::class)
            ->where('occurrence_id',$occurrence->id)->get(['long','lat']);
    }

    public function userlocations(){
        return $this->hasMany(Userlocation::class);
    }
}
