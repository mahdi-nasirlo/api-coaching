<?php

namespace Modules\Meeting\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Response;
use Modules\Meeting\Entities\Coach;
use Modules\Meeting\Entities\Meeting;
use Modules\Meeting\Enums\MeetingStatusEnums;
use Modules\Meeting\Http\Requests\Meeting\CreateMeeting;
use Modules\Meeting\Transformers\Meeting\AppointmentDaysResource;
use Modules\Meeting\Transformers\Meeting\MeetingResource;
use Morilog\Jalali\Jalalian;

class MeetingController extends Controller
{
    public function index(Coach $coach)
    {
        $meetings = $coach->meeting()->availableDate()->activeStatus()->get();

        return Cache::remember(
            'coachMeetingList' . $coach->uuid,
            60 * 60 * 2,
            fn() => MeetingResource::collection($meetings)->collection->groupBy('date')
        );
    }

    public function getAppointmentDay(Coach $coach)
    {
        $meetings = $coach->meeting()->availableDate()->activeStatus()->get();

        return AppointmentDaysResource::collection($meetings);
    }

    public function getAppointmentDayTime(Request $request, Coach $coach)
    {
        $data = $request->validate([
            'date' => 'required|date_format:Y-m-d'
        ]);

        $date = Jalalian::fromFormat('Y-m-d', $data['date'])->toCarbon();

        $meetings = $coach->meeting()->where('date', '=', $date->format('Y-m-d'))->activeStatus()->get();

        return Cache::remember(
            'coachMeetingList-' . $data['date'] . $coach->uuid,
            60 * 60 * 2,
            fn() => MeetingResource::collection($meetings)
        );
    }

    public function store(CreateMeeting $request, Coach $coach, PaymentService $paymentService): JsonResponse
    {
        $coach->meeting()->create($request->toArray());

        return Response::json(['status' => 'true', 'message' => 'meeting create successfully']);
    }

    public function toggleStatus(Meeting $meeting): JsonResponse
    {
        if ($meeting->status->isActive())
            $meeting->update(['status' => MeetingStatusEnums::DEACTIVATE->value]);
        else
            $meeting->update(['status' => MeetingStatusEnums::ACTIVE]);

        return Response::json([
            'status' => true,
            'message' => "meeting status is toggled",
            'date' => new MeetingResource($meeting),
        ]);
    }
}
