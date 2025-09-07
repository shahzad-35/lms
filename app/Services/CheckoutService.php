<?php

namespace App\Services;

use Checkout\CheckoutApi;
use Checkout\Environment;
use Checkout\Payments\Request\PaymentRequest;
use Checkout\Common\Currency;

class CheckoutService
{
    protected $api;

    public function __construct()
    {
        $this->api = new CheckoutApi(
            new \Checkout\CheckoutSdk()
        );
    }

    public function createPayment($amount, $currency = "USD", $sourceToken)
    {
        $request = new PaymentRequest();
        $request->source = new \Checkout\Payments\Request\Source\RequestTokenSource();
        $request->source->token = $sourceToken; // From frontend
        $request->amount = $amount * 100; // convert to cents
        $request->currency = Currency::$usd;

        return $this->api->getPaymentsClient()->requestPayment($request);
    }
}
