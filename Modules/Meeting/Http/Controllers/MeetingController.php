<?php

namespace Modules\Meeting\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Meeting\Entities\Coach;
use Modules\Meeting\Http\Requests\Meeting\CreateMeeting;
use Modules\Meeting\Transformers\Meeting\MeetingResource;

class MeetingController extends Controller
{
    public function index(Coach $coach)
    {
        $coach->load('meeting');

        return MeetingResource::collection($coach->meeting)->collection->groupBy('date');
    }

    public function store(CreateMeeting $request, Coach $coach)
    {
        $coach->load('meeting');

    }
}
