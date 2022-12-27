<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Payment;
use App\Models\Invoice;
use App\Models\Order;

class Client extends Model
{
    use HasFactory;

    protected $fillable = ['name','address','phone'];

    public function payments(){
        return $this->hasMany(Payment::class);
    }

    public function invoices(){
        return $this->hasMany(Invoice::class);
    }

    public function orders(){
        return $this->hasMany(Order::class);
    }

}
