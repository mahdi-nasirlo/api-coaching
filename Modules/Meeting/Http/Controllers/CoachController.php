<?php

namespace Modules\Meeting\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controller;
use Modules\Meeting\Entities\Coach;
use Modules\Meeting\Entities\CoachInfo;
use Modules\Meeting\Http\Requests\CoachRequest;
use Modules\Meeting\Transformers\Coach\CoachListResource;
use Modules\Meeting\Transformers\Coach\CoachResource;

class CoachController extends Controller
{
    

    public function index(): AnonymousResourceCollection
    {
        $coaches = Coach::paginate();

        return CoachListResource::collection($coaches);
    }

    public function create()
    {
        return view('meeting::create');
    }


    public function store(CoachRequest $request): JsonResponse
    {
        $data = $request->toArray();

        $coachInfo = CoachInfo::create($data);
        $data['info_id'] = $coachInfo->id;
        $data['user_id'] = auth()->id();

        $coach =  Coach::create($data);

        return response()->json($coach->toArray());
    }

    public function show($id): CoachResource
    {
        $coach = Coach::join('coach_infos', 'coaches.info_id', '=', 'coach_infos.id')
                ->select
                (
                    'coaches.id','coaches.name', 'coaches.avatar',
                    'coaches.user_name', 'coaches.hourly_price', 'coaches.info_id',
                    'coach_infos.about_me', 'coach_infos.resume', 'coach_infos.job_experience', 'coach_infos.education_record'
                )
            ->where('coaches.id', $id)
            ->whereNotNull('coach_infos.id')
            ->firstOrFail();

        return new CoachResource($coach);
    }

    public function edit($id)
    {
        return view('meeting::edit');
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
