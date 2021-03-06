<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Occurrence extends Model
{
    use HasFactory;

    public function urgency(){
        return $this->belongsTo(Urgency::class);
    }

    public function users(){
        return $this->belongsToMany(User::class)->withPivot('opened','status');
    }

    public function userlocations(){
        return $this->hasMany(Userlocation::class);
    }
}
