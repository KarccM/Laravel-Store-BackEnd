<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Order;
use App\Models\Item;
use App\Models\SoldItem;


class OrdersController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth:sanctum");
    }

    //re make validation here
    public function store(Request $request){
        $validated = $request->validate([
            "items" => 'required',
            "items.*.id" => 'required',
            "items.*.name" => 'required',
            "items.*.quantity" => 'required',
            "client" => 'required',
            "payment" => 'required',
        ]);

        $user = auth()->user();

        DB::beginTransaction();
        try {
            $client = Client::updateOrCreate(
                ["name"=> $validated['client']['name']],
                [
                    "address" => $validated['client']['address'],
                    "phone" => $validated['client']['phone'],
                ]
            );

            //Before I should Check for state of every Item an Make Sure The Price that send from frontend is equal to price in database then do this
            $realItems = collect($validated['items'])->map(function($item){
                return [ ...$item  , "total"=> ($item['price'] * $item['quantity'])];
            });

            $discount = isset($validated['payment']['discount'])? $validated['payment']['discount']/100 : 0;
            $totalPricesWithoutDiscount = $realItems->sum->total;
            $total = $totalPricesWithoutDiscount - ($totalPricesWithoutDiscount * $discount) ;
            $subtotal = $validated['payment']['amount'];
            $invoice = Invoice::create([
                'total' => $total,
                'subtotal' => $subtotal ,
                'discount' => $discount,
                'status' => $total == $subtotal ? 'paid' : 'due',
                'client_id' => $client->id,
                'user_id'=> $user->id
            ]);

            $payment = Payment::create([
                'amount' => $subtotal ,
                'active' => true,
                'client_id' => $client->id,
                'user_id'=> $user->id,
                'invoice_id'=> $invoice->id
            ]);

            $order = Order::create([
                'client_id' => $client->id,
                'user_id' => $user->id,
                'invoice_id' => $invoice->id,
                'status' => 'completed',
                'active' => true
            ]);

            foreach($realItems as $item){
                $soldItem = SoldItem::create([
                    'invoice_id' => $invoice->id,
                    'order_id' => $order->id,
                    'item_id' => $item['id'],
                    'price_at_moment' => $item['price'],
                    'name_at_moment' => $item['name'],
                    'quantity' => $item['quantity']
                ]);
            }


            DB::commit();
            return $order;
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }

    }

    //filters
    public function index(){
        return Order::with(['user','client','soldItems','invoice'])->get()
        ->filter(function($order){
            return $order->active == true;
        })
        ->map(function ($order){
            return [
                "id" => $order->id,
                "user" => $order->user,
                "client" => $order->client,
                "invoice" => $order->invoice,
                "soldItems" => $order->soldItems,
            ];
        });
    }

    public function update(Request $request,Order $order){
        //delete perv sold items
        //add new sold items

        //edit payments => delete prev and add new

    }

    public function addPayment(Request $request){

    }

    public function show(Order $order){
        return $order;
    }

    public function delete(Order $order){
        $oredr->active = false;
        return "success";
    }
}
