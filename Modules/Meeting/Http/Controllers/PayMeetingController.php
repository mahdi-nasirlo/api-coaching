<?php

namespace Modules\Meeting\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Response;
use Modules\Meeting\Entities\Meeting;
use Modules\Meeting\services\MeetingPayService;
use Modules\Payment\Entities\Transaction;

class PayMeetingController extends Controller
{
    public function payment(Request $request, Meeting $meeting, MeetingPayService $meetingService)
    {
        $data = $request->validate(['url' => 'required|url']);

        if ($meetingService->is_reserved($meeting))
            return Response::json(['status' => false]);

        $test = $meetingService->meetingPay($meeting, url: $data['url']);

        return Response::json(['data' => $test]);
    }

    public function reserved(Transaction $transaction, MeetingPayService $meetingService)
    {
        return $meetingService->verifyMeetingPay($transaction);
    }

    public function rePay()
    {

    }
}
