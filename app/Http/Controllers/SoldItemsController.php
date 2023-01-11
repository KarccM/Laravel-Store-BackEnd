<?php

namespace App\Http\Controllers;

class SoldItemsController extends Controller
{
    public function delete($id){
        $solditem = SoldItem::find($id);
        $solditem->delete();
        return "deleted";
    }
}
