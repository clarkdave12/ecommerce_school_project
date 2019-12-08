<?php

namespace App\Http\Controllers;
// require 'vendor/autoload.php';

use Illuminate\Http\Request;
use PayPal\Api\Payer;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Api\PaymentExecution;

use App\Order;
use App\User;
use App\Cart;
use App\Sale;
use App\Popular;

class PaymentController extends Controller
{

    public function create($id, $totalAmount)
    {

        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
              env('PAYPAL_CLIENT_ID'),
              env('PAYPAL_CLIENT_SECRET')
            )
          );

        $payer = new Payer();
        $payer->setPaymentMethod("paypal");

        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl('http://localhost:8000/api/execute-payment/' . $id . '/' . $totalAmount)
                     ->setCancelUrl('http://localhost:8000/cancel');

        $amount = new Amount();
        $amount->setCurrency("PHP")
        ->setTotal($totalAmount);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
                    ->setDescription("Payment description");

        $payment = new Payment();
        $payment->setIntent('sale')
                ->setPayer($payer)
                ->setRedirectUrls($redirectUrls)
                ->setTransactions(array($transaction));

        $payment->create($apiContext);

        return redirect($payment->getApprovalLink());
        
    }

    public function execute($id, $totalAmount)
    {

        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                env('PAYPAL_CLIENT_ID'),
                env('PAYPAL_CLIENT_SECRET')
            )
        );

        $paymentId = request('paymentId');
        $payment = Payment::get($paymentId, $apiContext);
        $payerId = request('PayerID');

        $execution = new PaymentExecution();
        $execution->setPayerId($payerId);

        $result = $payment->execute($execution, $apiContext);

        $amount = 0;
        /* Getting user information */
        $user = User::find($id);

        $products = Cart::where('user_id', $id)->get();

        foreach($products as $product)
        {
            $order = new Order();
            $order->user_id = $id;
            $order->order_id = $result->id;
            $order->product_id = $product->product_id;
            $order->state = $result->state;
            $order->quantity = $product->quantity;
            $order->price = $product->price;
            $order->status = "For Shipping";
            $order->method = $result->payer->payment_method;
            $order->save();
        }

        $pop = new Popular();
        foreach($products as $product)
        {
            $pop->product_id = $product->product_id;
            $pop->sold = $product->quantity;
            $pop->save();
        }

        $sale = new Sale();
        $sale->user_id = $id;
        $sale->amount = $totalAmount;
        $sale->order_id = $result->id;
        $sale->save();

        return redirect('http://localhost:8000/success');
    }
}
