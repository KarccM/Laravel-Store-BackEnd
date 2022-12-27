<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Invoice;
use App\Models\User;
use App\Models\Client;
use App\Models\Solditem;


class Order extends Model
{
    use HasFactory;


    protected $fillable = ['client_id','user_id','invoice_id','status','active'];

    public function invoice(){
        return $this->belongsTo(Invoice::class);
    }

    public function soldItems(){
        return $this->hasMany(SoldItem::class);
    }
    
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function client(){
        return $this->belongsTo(Client::class);
    }
}
