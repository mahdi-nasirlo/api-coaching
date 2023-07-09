<?php

namespace Modules\Meeting\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controller;
use Modules\Meeting\Entities\Coach;
use Modules\Meeting\Transformers\Coach\CoachListResource;

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


    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        return view('meeting::show');
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
