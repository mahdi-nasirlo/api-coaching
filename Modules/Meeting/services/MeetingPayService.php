<?php

namespace Modules\Meeting\services;

use Modules\Meeting\Entities\Meeting;
use Modules\Meeting\Enums\MeetingStatusEnums;
use Modules\Payment\Entities\Transaction;
use Modules\Payment\traits\InteractWithPayments;

class MeetingPayService extends MeetingService
{
    use InteractWithPayments;

    public function meetingPay(Meeting $meeting, string|null $url = null)
    {
        $amount = self::getTotalPrice($meeting);

        $verifyCode = md5(uniqid());

        $callbackUrl = $this->getMeetingVerifyUrl($verifyCode, $url);

        return $this->getPaymentJson(
            $callbackUrl,
            $amount,
            function ($driver, $transactionId) use ($meeting, $verifyCode, $amount) {
                $meeting->transaction()->updateOrCreate([
                    'resnumber' => $transactionId,
                    'verify_code' => $verifyCode,
                    'amount' => $amount
                ]);
            });
    }

    public function getMeetingVerifyUrl($verifyCode, $url = null): string
    {
        return route('meeting.reserve.verify', ['transaction' => $verifyCode, 'url' => $url]);
    }

    public function transactionPay(Transaction $transaction, string|null $url = null)
    {
        $verifyCode = $transaction->verify_code;

        $callbackUrl = $this->getMeetingVerifyUrl($verifyCode, $url);

        return $this->getPaymentJson(
            $callbackUrl,
            $transaction->amount,
            function ($driver, $transactionId) use ($transaction) {
                Transaction::query()->updateOrCreate(
                    ['verify_code' => $transaction->verify_code],
                    ['resnumber' => $transactionId]
                );
            });
    }

    public function verifyMeetingPay(Transaction $transaction)
    {
        return $this->verifyTransaction($transaction, tryCallback: function (Transaction $transaction) {

            $transaction->getMeeting()->update(['status' => MeetingStatusEnums::RESERVED->value]);

            if (request()->get('url'))
                return redirect()->to(request('url'));
            else
                return view('welcome');
        });

    }

    public function is_reserved(Meeting $meeting): bool
    {
        return $meeting->status->isReserved() && $meeting->transaction()->where('status', 1)->exists();
    }

}
