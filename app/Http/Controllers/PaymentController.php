<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Payment;
use App\Models\Invoice;
use App\Models\User;
use App\Models\Client;
use App\Models\Order;
use App\Trait\CustomResponse;


//All Methods should work with exception handler
class PaymentController extends Controller
{
    public function __construct() {
        $this->middleware("auth:sanctum");
    }

    public function index() {
        return [];
    }

   public function bulkDelete(Request $request){
    try {
        Payment::destroy(collect($request->input('ids')));
    }catch(Exception $e){
        // not worked well
        return "error";
    }
    return "GG";
   }

   public function update(){
        return [];
   }

   public function delete(Payment $payment){
    Payment::destroy($payment);
   }

    public function getInvoice($id){
        $invoice = Invoice::find($id);
        return CustomResponse::success([
            "invoice"=>$invoice,
            "payments"=>$invoice->payments
        ]);
    }

   public function getUser($id){
        $user = User::find($id);
        return CustomResponse::success([
            "user"=>$user,
            "payments"=>$user->epayments
        ]);
    }

    public function getClient($name){
        $client = Client::with('payments')->where('name','like','%'.$name.'%')->get();
        return CustomResponse::success([
            "client"=>$client,
            // "payments"=>$client->payments
        ]);
    }

    public function getOrder($id){
        $order = Order::find($id);
        return $this->getInvoice($order->invoice_id);
    }

}
