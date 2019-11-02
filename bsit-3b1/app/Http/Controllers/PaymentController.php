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

class PaymentController extends Controller
{

    public function create($id, $total)
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
        $redirectUrls->setReturnUrl('http://localhost:8000/api/execute-payment/' . $id)
                     ->setCancelUrl('http://localhost:8000/cancel');

        $amount = new Amount();
        $amount->setCurrency("PHP")
        ->setTotal($total);

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

    public function execute($id)
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

        foreach($result->transactions as $transaction)
        {
            $amount += $transaction->amount->total;
        }

        $order = new Order();
        $order->user_id = $id;
        $order->order_id = $result->id;
        $order->state = $result->state;
        $order->amount = $amount;
        $order->cart = $result->cart;
        $order->method = $result->payer->payment_method;
        $order->payer_id = $result->payer->payer_info->payer_id;
        $order->payer_email = $result->payer->payer_info->email;
        $order->recipient_name = $result->payer->payer_info->shipping_address->recipient_name;
        $order->shipping_address = $result->payer->payer_info->shipping_address->line1 . ' ' . $result->payer->payer_info->shipping_address->city;
        $order->save();

        return redirect('http://localhost:8000/success');
    }
}
