<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\payment;


class PaymentController extends Controller
{
   
    public function index(Request $request)
    {
        // return $request->query('name');
        
        $queryName = $request->query('name') ?? '';
        
        // $items = collect(Item::where("name",$queryName)->first());

        $items = DB::table('items')->where('name','like','%'.$queryName.'%')->get();

            // ->map(function ($item){
            //     if($item->is_active == 1)
            //     $item->is_active =true;
            //     else
            //     $item->is_active =false;
            //     return $item;
            // });
        // $activeItems = Item::cursor()->filter(function ($iteme) {
        //     return $iteme->is_active == false;
        // });
        return $items;

    }

    public function store(Request $request)
    {
        Item::create([
            "name" => $request->input('name'),
            "price" => $request->input('price'),
            "is_active" => $request->input('is_active') ?? false,
        ]);
        return ["message"=>"Success"];
    }

    public function show(payment $item)
    {
        return $item;
    }

    public function update(Request $request, payment $payment)
    {
        $item->name = $request->input('name') ?? $item->name;
        $item->price = $request->input('price') ?? $item->price;
        $item->is_active = $request->input('is_active') ?? $item->is_active;
        $item->save();
        $item->refresh();
        return $item;
    }

    public function destroy(Item $item)
    {
        $item->delete();
        return "sucess";
    }

}
