<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Trait\CustomResponse;


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
        // if(auth()->user()->tokenCan('list'))
        //  return CustomResponse::failed([],'unauthorized');
        $queryName = $request->query('name') ?? '';
        $active = $request->query('active') ?? null;
        $price = $request->query('price') ?? null;

        $itemsQuery =Item::where('name','like','%'.$queryName.'%');
        if($active){
            if($active == 'true') $active = 1;
            else $active = 0;
            $itemsQuery = $itemsQuery->where('active' , 'like',$active);
        }

        if($price){
            $itemsQuery = $itemsQuery->where('price' , '>=',$price);
        }

        $items = $itemsQuery->get();

        return CustomResponse::success($items,"All Items");
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
        $item = Item::create([
            "name" => $request->input('name'),
            "price" => $request->input('price'),
            "active" => $request->input('active') ?? true,
        ]);
        return CustomResponse::success($item,"Add New Item Success");
    }

    /**
     * Display the specified resource.
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Item::find($id);
        return CustomResponse::success($item,"Item Found");
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
    public function update(UpdateItemRequest $request,$id)
    {
        $item = Item::find($id);
        $item->name = $request->input('name') ?? $item->name;
        $item->price = $request->input('price') ?? $item->price;
        $item->active = $request->input('active') ?? $item->active;
        $item->save();
        $item->refresh();
        return CustomResponse::success($item,"Update Success");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Item::find($id);
        $item->delete();
        return CustomResponse::success([],"Delete Success");
    }


}
