<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Client;
use App\Models\Invoice;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['amount','active','client_id','user_id','invoice_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function client(){
        return $this->belongsTo(Client::class);
    }

    public function invoice(){
        return $this->belongsTo(Invoice::class);
    }

}
