<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Payment;
use App\Models\Invoice;
use App\Models\User;
use App\Models\Client;


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
        return [
            "invoice"=>$invoice,
            "payments"=>$invoice->payments
        ];
    }

   public function getUser($id){
        $user = User::find($id);
        return [
            "user"=>$user,
            "payments"=>$user->payments
        ];
    }

   public function getClient($id){
        $client = Client::find($id);
        return [
            "client"=>$client,
            "payments"=>$client->payments
        ];
    }

}
