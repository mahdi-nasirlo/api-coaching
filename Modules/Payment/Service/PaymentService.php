<?php

namespace Modules\Payment\Service;

use Shetabit\Multipay\Exceptions\InvalidPaymentException;
use Shetabit\Multipay\Invoice;
use Shetabit\Payment\Facade\Payment;

class PaymentService
{
    public function pay(int $amount, string $callbackUrl)
    {
        return Payment::callbackUrl($callbackUrl)
            ->purchase(
                (new Invoice)->amount($amount),
                function ($driver, $transactionId) {
                    // Store transactionId in database.
                    // We need the transactionId to verify payment in the future.
                }
            )->pay()->toJson();
    }

    public function verify($transaction_id): void
    {
        // You need to verify the payment to ensure the invoice has been paid successfully.
// We use transaction id to verify payments
// It is a good practice to add invoice amount as well.
        try {
            $receipt = Payment::amount(1000)->transactionId($transaction_id)->verify();

            // You can show payment referenceId to the user.
            $receipt->getReferenceId();

        } catch (InvalidPaymentException $exception) {
            /**
             * when payment is not verified, it will throw an exception.
             * We can catch the exception to handle invalid payments.
             * getMessage method, returns a suitable message that can be used in user interface.
             **/
            echo $exception->getMessage();
        }
    }
}
