<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SoldItem;

class Item extends Model
{
    use HasFactory;
    protected $fillable = ['name','price','is_active'];
    public $timestamps = false;

    public function soldItems(){
        return $this->hasMany(SoldItem::class);
    }

}
