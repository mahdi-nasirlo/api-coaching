<?php

namespace Modules\Meeting\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Response;
use Modules\Meeting\Entities\Coach;
use Modules\Meeting\Http\Requests\Meeting\CreateMeeting;
use Modules\Meeting\Transformers\Meeting\MeetingResource;

class MeetingController extends Controller
{
    public function index(Coach $coach)
    {
        $meetings = $coach->meeting()->availableDate()->get();

        return MeetingResource::collection($meetings)->collection->groupBy('date');
    }

    public function store(CreateMeeting $request, Coach $coach)
    {
        $coach->meeting()->create($request->toArray());

        return Response::json(['status' => 'true', 'message' => 'meeting create successfully']);
    }
}
