<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\OrderStoreRequest;
use Illuminate\Support\Facades\DB;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Order;
use App\Models\Item;
use App\Models\SoldItem;
// use Illuminate\Support\Facades\Auth;





class OrdersController extends Controller
{

    public function __construct()
    {
        // $this->middleware('cors');
        $this->middleware("auth:sanctum");
    }

    //re make validation here
    public function store(OrderStoreRequest $request){
        $user = auth()->user();
        DB::beginTransaction();
        try {
            $client = Client::updateOrCreate(
                ["name"=> $request['client']['name']],
                [
                    "address" => $request['client']['address'],
                    "phone" => $request['client']['phone'],
                ]
            );
            //Before I should Check for state of every Item an Make Sure The Price that send from frontend is equal to price in database then do this
            $realItems = collect($request['items'])->map(function($item){
                return [ ...$item  , "total"=> ($item['price'] * $item['quantity'])];
            });

            $discount = isset($request['payment']['discount'])? $request['payment']['discount']/100 : 0;
            $totalPricesWithoutDiscount = $realItems->sum->total;
            $total = $totalPricesWithoutDiscount - ($totalPricesWithoutDiscount * $discount) ;
            $subtotal = $request['payment']['amount'];
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
                    'name_at_moment' => $item['name'] ?? 'unk',
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
    public function index(Request $request){;
        return Order::with(['user','client','soldItems','invoice'])->get()
        ->filter(function($order){
            return $order->active == true;
        })
        ->map(function ($order){
            return [
                "id" => $order->id,
                "user" => $order->user->email,
                "client" => $order->client->name,
                "order_status" => $order->status,
                "invoice_status" => $order->invoice->status,
                "total"=>$order->invoice->total,
                "subtotal"=>$order->invoice->subtotal,
                "discount"=>$order->invoice->discount
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
