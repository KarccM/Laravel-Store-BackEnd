<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\invoic;
use App\Models\User;
use App\Models\client;
use App\Models\sold_items;


class orders extends Model
{
    use HasFactory;

    public function invoic(){
        return $this->has(invoic::class);
    }

    public function slodItems(){
        return $this->hasMany(soldItems::class);
    }
    
    public function user(){
        return $this->belongsTo(user::class);
    }

    public function client(){
        return $this->belongsTo(cleint::class);
    }
}
