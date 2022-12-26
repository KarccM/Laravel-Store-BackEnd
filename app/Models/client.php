<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\payment;
use App\Models\invoic;
use App\Models\orders;

class client extends Model
{
    use HasFactory;

    public function payments(){
        return $this->hasMany(payment::class);
    }

    public function invoices(){
        return $this->hasMany(invoic::class);
    }

    public function orders(){
        return $this->hasMany(orders::class);
    }
    
}
