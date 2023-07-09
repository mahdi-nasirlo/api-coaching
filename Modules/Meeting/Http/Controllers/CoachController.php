<?php

namespace Modules\Meeting\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CoachController extends Controller
{

    public function index()
    {
        return view('meeting::index');
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
