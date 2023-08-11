<?php

namespace Modules\Payment\traits;

use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Modules\Payment\Entities\Transaction;
use Modules\Payment\Enums\PaymentStatusEnum;
use Shetabit\Multipay\Exceptions\InvalidPaymentException;
use Shetabit\Multipay\Invoice;
use Shetabit\Payment\Facade\Payment;

trait InteractWithPayments
{
    public function getPaymentJson(string $callbackUrl, int $amount, Closure $callback)
    {
        $invoice = (new Invoice)->amount($amount);

        $response = Payment::callbackUrl($callbackUrl)->purchase(
            $invoice,
            function ($driver, $transactionId) use ($callback) {
                $callback($driver, $transactionId);
            }
        )->pay()->toJson();

        return json_decode($response);
    }

    public function verifyTransaction(Transaction $transaction, Closure|null $tryCallback = null, Closure|null $catchCallback = null)
    {
        try {
            $receipt = Payment::amount($transaction->amount)->transactionId($transaction->resnumber)->verify();

            return DB::transaction(function () use ($transaction, $tryCallback, $receipt) {

                $transaction->update(['status' => PaymentStatusEnum::PAID->value]);

                return $tryCallback ? $tryCallback($transaction) : Response::json(['message' => $receipt->getReferenceId()]);

            });

        } catch (InvalidPaymentException $exception) {

            $transaction->update(['status' => PaymentStatusEnum::UNSUCCESSFUL->value]);

            return $catchCallback ?
                $catchCallback($transaction) :
                Response::json(['message' => $exception->getMessage()]);
        }
    }
}
