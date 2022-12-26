<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\invoic;
use App\Models\oreders;
use App\Models\Item;

class sold_items extends Model
{
    use HasFactory;


    public function invoice(){
        return $this->belongsTo(invoic::class);
    }

    public function item(){
        return $this->belongsTo(Item::class);
    }

    public function order(){
        return $this->belongsTo(oreders::class);
    }
}
