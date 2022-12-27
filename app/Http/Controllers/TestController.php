<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class TestController extends Controller
{
    public function item_relation(){
        $item = Item::find(1);
        return ["item"=>$item,
        "sold"=>$item->soldItems];
    }
}
