<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemSize extends Model
{
    use HasFactory;

    public function availability(){
        return $this->hasOne(Availability::class);
    }

    public function users(){
        return $this->hasMany(User::class);
    }

    public function item(){
        return $this->hasOne(Item::class);
    }
}
