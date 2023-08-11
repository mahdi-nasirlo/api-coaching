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

        $callbackUrl = route('meeting.reserve.verify', ['transaction' => $verifyCode, 'url' => $url]);

        $result = $this->getPaymentJson(
            $callbackUrl,
            $amount,
            function ($driver, $transactionId) use ($meeting, $verifyCode, $amount) {
                $meeting->transaction()->create([
                    'resnumber' => $transactionId,
                    'verify_code' => $verifyCode,
                    'amount' => $amount
                ]);
            });

        return json_decode($result);
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
