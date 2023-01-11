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
use App\Trait\CustomResponse;




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
            //Before I should Check for state of every Item an Make Sure The Price that send from frontend is equal
            //to price in database then do this

            $realItems = collect($request['items'])->map(function($item){
                return [ ...$item  , "total"=> ($item['price'] * $item['quantity'])];
            });

            $discount = isset($request['payment']['discount'])? $request['payment']['discount'] : 0;
            $discount100 = $request['payment']['discount']/100;
            $totalPricesWithoutDiscount = $realItems->sum->total;
            $total = $totalPricesWithoutDiscount - ($totalPricesWithoutDiscount * $discount100) ;
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
                'status' => $total == $subtotal ? 'completed':'shipped',
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
            return CustomResponse::success($order,'Order Created');
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }

    }

    //filters
    public function index(Request $request){;
        return CustomResponse::success(Order::with(['user','client','soldItems','invoice'])->get()
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
        }),"All Orders");
    }

    public function update(Request $request,$id){
        $order = Order::find($id);
        //  read prev items and delete if quantity 0 and change if not
        //  add new items
        //  calculate their prices
        //  get prev payments
        //  add new paymemt
        //  update order (state and items)
        //  save

        //edit payments => delete prev and add new
        return CustomResponse::success([$request->input() , $order]);

    }

    public function addPayment($id){

    }

    public function getOne($id){
        $order = Order::where('id' , '=' ,$id)->withAll()->get()[0]; // not sure
        return CustomResponse::success(collect($order));

    }

    public function delete(Order $order){
        $oredr->active = false;
        return CustomResponse::success([]);
    }
}
