<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Item;

class SoldItem extends Model
{
    use HasFactory;

    protected $table  = 'solditems';

    protected $fillable = ['order_id','invoice_id','price_at_moment','name_at_moment','quantity','item_id'];

    public function invoice(){
        return $this->belongsTo(Invoice::class);
    }

    public function item(){
        return $this->belongsTo(Item::class);
    }

    public function order(){
        return $this->belongsTo(Order::class);
    }
}
