<?php

namespace Modules\Meeting\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Response;
use Modules\Meeting\Entities\Coach;
use Modules\Meeting\Entities\Meeting;
use Modules\Meeting\Enums\MeetingStatusEnums;
use Modules\Meeting\Http\Requests\Meeting\CreateMeeting;
use Modules\Meeting\Transformers\Meeting\MeetingResource;

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

    public function store(CreateMeeting $request, Coach $coach)
    {
        $coach->meeting()->create($request->toArray());

        return Response::json(['status' => 'true', 'message' => 'meeting create successfully']);
    }

    public function toggleStatus(Meeting $meeting)
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
