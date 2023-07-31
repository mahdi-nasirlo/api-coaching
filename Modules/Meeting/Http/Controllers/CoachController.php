<?php

namespace Modules\Meeting\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Response;
use Modules\Meeting\Entities\Coach;
use Modules\Meeting\Entities\CoachInfo;
use Modules\Meeting\Http\Requests\Coach\CreateCoachRequest;
use Modules\Meeting\Http\Requests\Coach\UpdateCoachRequest;
use Modules\Meeting\Transformers\Coach\CoachListResource;
use Modules\Meeting\Transformers\Coach\CoachResource;

class CoachController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $coaches = Cache::remember('getAllCoach', 60 * 60, function () {
            return Coach::acceptedStatus()->paginate();
        });

        return CoachListResource::collection($coaches);
    }

    public function store(CreateCoachRequest $request): CoachResource|JsonResponse
    {
        if (auth()->user()->coach) {
            return Response::json([
                'status' => false,
                'message' => 'You are a coach right now and you cannot become a coach again.'
            ], 403);
        }

        $data = $request->validated();
        $data['avatar'] = $this->uploadAvatar($request);

        $coachInfo = CoachInfo::create($data);
        $data['info_id'] = $coachInfo->id;
        $data['user_id'] = auth()->id();

        $coach = Coach::create($data);

        return new CoachResource($coach);
    }

    protected function uploadAvatar(Request $request): string
    {
        $file = $request->file('avatar');
        $filename = uniqid() . '.' . $file->getClientOriginalExtension();
        $filePath = $file->storeAs('public/avatars', $filename);

        return $filename;
    }

    public function show($uuid): CoachResource
    {
        $coach = Cache::remember('getCoach_' . $uuid, 60 * 60 * 5, fn() => Coach::join('coach_infos', 'coaches.info_id', '=', 'coach_infos.id')
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

    public function update(UpdateCoachRequest $request, Coach $coach): CoachResource|JsonResponse
    {
        if (auth()->id() !== $coach->user_id) {
            return Response::json(['message' => "You Don't access to update this coach information"], 403);
        }

        $data = $request->validated();

        $data['coach']['avatar'] = $this->uploadAvatar($request);

        $coach->update($data['coach']);
        $coach->coachInfo()->update($data['coach_info']);

        return new CoachResource($coach);
    }
}
