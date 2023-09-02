<?php

namespace Modules\Blog\Http\Controllers;

use App\Models\Blog\Category;
use Illuminate\Routing\Controller;

class CategoryController extends Controller
{

    public function index()
    {
        return Category::query()->get()->toTree();
    }

    public function show($id)
    {
        return view('blog::show');
    }
}
