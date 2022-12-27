<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\client;

class ItemController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth:sanctum");
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // return $request->query('name');
        
        $queryName = $request->query('name') ?? '';
        
        // $items = collect(Item::where("name",$queryName)->first());

        $items = DB::table('items')->where('name','like','%'.$queryName.'%')->get();

            // ->map(function ($item){
            //     if($item->active == 1)
            //     $item->active =true;
            //     else
            //     $item->active =false;
            //     return $item;
            // });
        // $activeItems = Item::cursor()->filter(function ($iteme) {
        //     return $iteme->active == false;
        // });

        return $items;
 }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreItemRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreItemRequest $request)
    {
        Item::create([
            "name" => $request->input('name'),
            "price" => $request->input('price'),
            "active" => $request->input('active') ?? false,
        ]);
        return ["message"=>"Success"];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        return $item;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateItemRequest  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateItemRequest $request, Item $item)
    {
        $item->name = $request->input('name') ?? $item->name;
        $item->price = $request->input('price') ?? $item->price;
        $item->active = $request->input('active') ?? $item->active;
        $item->save();
        $item->refresh();
        return $item;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        $item->delete();
        return "sucess";
    }

    
}
