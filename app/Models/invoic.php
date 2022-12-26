<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\client;
use App\Models\orders;
use App\Models\User;

class invoic extends Model
{
    use HasFactory;

    public function client(){
        return $this->beloongsTo(client::class);
    }
    
    public function user(){
        return $this->beloongsTo(User::class);
    }

    public function order(){
        return $this->beloongsTo(orders::class);
    }
}
