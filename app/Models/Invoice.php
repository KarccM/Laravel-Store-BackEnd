<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Client;
use App\Models\Order;
use App\Models\User;
use App\Models\Payment;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [ 'total' ,'subtotal','discount','status','client_id','user_id'];

    protected $table  = 'invoices';

    public function client(){
        return $this->beloongsTo(Client::class);
    }

    public function user(){
        return $this->beloongsTo(User::class);
    }

    public function order(){
        return $this->hasOne(Order::class);
    }

    public function payments(){
        return $this->hasMany(Payment::class);
    }
}
