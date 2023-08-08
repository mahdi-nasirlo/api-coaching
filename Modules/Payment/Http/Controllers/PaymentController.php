<?php

namespace Modules\Payment\Http\Controllers;


use Illuminate\Routing\Controller;
use Shetabit\Multipay\Invoice;
use Shetabit\Payment\Facade\Payment;

class PaymentController extends Controller
{
    public function payment()
    {
        return Payment::purchase(
            (new Invoice)->amount(1000),
            function ($driver, $transactionId) {
                // Store transactionId in database.
                // We need the transactionId to verify payment in the future.
            }
        )->pay()->toJson();
    }
}
