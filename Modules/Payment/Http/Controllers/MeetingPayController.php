<?php

namespace Modules\Payment\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\URL;
use Modules\Meeting\Entities\Meeting;
use Modules\Meeting\services\MeetingService;
use Modules\Payment\Service\PaymentService;

class MeetingPayController extends Controller
{
   public function payment(Meeting $meeting,PaymentService $paymentService)
   {
       $callbackUrl = URL::temporarySignedRoute('payment.meeting.reserve', now()->addMinutes(4),['meeting' => $meeting]);

       $amount = $meeting->coach->hourly_price * MeetingService::getDiffHourlyStartAndEndTime($meeting->start_time, $meeting->end_time);

       return $paymentService->pay($amount, $callbackUrl);
   }

   public function store(Meeting $meeting, Request $request)
   {
       if (! $request->hasValidSignature()) {
           abort(401);
       }

   }
}
