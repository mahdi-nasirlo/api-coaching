<?php

namespace Modules\Meeting\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Response;
use Modules\Meeting\Entities\Coach;
use Modules\Meeting\Entities\CoachInfo;
use Modules\Meeting\Http\Requests\Coach\CreateCoachRequest;
use Modules\Meeting\Http\Requests\Coach\UpdateCoachRequest;
use Modules\Meeting\services\CoachService;
use Modules\Meeting\Transformers\Coach\CoachListResource;
use Modules\Meeting\Transformers\Coach\CoachResource;

class CoachController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $coaches = Cache::remember('getAllCoach', 60 * 60, function () {
            return Coach::with('categories')->acceptedStatus()->paginate();
        });

        $coaches = Coach::with('categories')->acceptedStatus()->paginate();

        return CoachListResource::collection($coaches);
    }

    public function store(CreateCoachRequest $request, CoachService $coachService): CoachResource|JsonResponse
    {
        if (auth()->user()->coach) {
            return Response::json([
                'status' => false,
                'message' => 'You are a coach right now and you cannot become a coach again.'
            ], 403);
        }

        $data = $request->validated();
        $data['avatar'] = $coachService->uploadAvatar($request);

        $coachInfo = CoachInfo::create($data);
        $data['info_id'] = $coachInfo->id;
        $data['user_id'] = auth()->id();

        $coach = Coach::create($data);

        $coachService->syncCategories($request, $coach);

        return Response::json(['status' => true, 'message' => 'coach create successfully']);
    }

    public function show($uuid): CoachResource
    {
        $coach = Cache::remember('getCoach_' . $uuid, 60 * 60 * 5, fn() => Coach::with('categories')->join('coach_infos', 'coaches.info_id', '=', 'coach_infos.id')
            ->select
            (
                'coaches.id', 'coaches.name', 'coaches.avatar',
                'coaches.user_name', 'coaches.hourly_price', 'coaches.info_id', 'coaches.uuid',
                'coach_infos.about_me', 'coach_infos.resume', 'coach_infos.job_experience', 'coach_infos.education_record'
            )
            ->where('coaches.uuid', $uuid)
            ->whereNotNull('coach_infos.id')
            ->firstOrFail()
        );


        return new CoachResource($coach);
    }

    public function update(UpdateCoachRequest $request, Coach $coach, CoachService $coachService): CoachResource|JsonResponse
    {
        if (auth()->id() !== $coach->user_id) {
            return Response::json(['message' => "You Don't access to update this coach information"], 403);
        }

        $data = $request->validated();

        $data['coach']['avatar'] = $coachService->uploadAvatar($request);

        $coach->update($data['coach']);
        $coach->coachInfo()->update($data['coach_info']);
        $coachService->syncCategories($request, $coach);

        return new CoachResource($coach);
    }
}
