<?php

namespace Modules\Meeting\services;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Modules\Meeting\Entities\Meeting;
use Modules\Meeting\Enums\MeetingStatusEnums;
use Modules\Payment\Entities\Transaction;
use Modules\Payment\Enums\PaymentStatusEnum;
use Shetabit\Multipay\Exceptions\InvalidPaymentException;
use Shetabit\Multipay\Invoice;
use Shetabit\Payment\Facade\Payment;

class MeetingPayService extends MeetingService
{
    public function meetingPay(Meeting $meeting, string|null $url = null)
    {
        $amount = self::getTotalPrice($meeting);

        $invoice = (new Invoice)->amount($amount);

        $verifyCode = md5(uniqid());

        $callbackUrl = route('meeting.reserve.verify', ['transaction' => $verifyCode, 'url' => $url]);

        return Payment::callbackUrl($callbackUrl)->purchase(
            $invoice,
            function ($driver, $transactionId) use ($meeting, $amount, $verifyCode) {
                $meeting->transaction()->create([
                    'resnumber' => $transactionId,
                    'verify_code' => $verifyCode,
                    'amount' => $amount
                ]);
            }
        )->pay()->toJson();
    }

    public function verifyMeetingPay(Transaction $transaction): JsonResponse
    {
        try {
            $receipt = Payment::amount($transaction->amount)->transactionId($transaction->resnumber)->verify();

            DB::transaction(function () use ($transaction) {

                $transaction->update(['status' => PaymentStatusEnum::PAID->value]);

                $transaction->getMeeting()->update(['status' => MeetingStatusEnums::RESERVED->value]);

            });

            return Response::json(['message' => $receipt->getReferenceId()]);

        } catch (InvalidPaymentException $exception) {

            $transaction->update(['status' => PaymentStatusEnum::UNSUCCESSFUL->value]);

            return Response::json(['message' => $exception->getMessage()]);
        }
    }

    public function is_reserved(Meeting $meeting): bool
    {
        return $meeting->status->isReserved() && $meeting->transaction()->where('status', 1)->exists();
    }

}
