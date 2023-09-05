<?php

namespace Modules\Blog\Http\Controllers;

use App\Models\Blog\Category;
use Illuminate\Routing\Controller;

class CategoryController extends Controller
{

    public function index()
    {

        $categories = Category::query()->where("is_visible", true)->get();

        return $categories;

//        return CategoryResource::make($categories);
    }

    public function show($id)
    {
        return view('blog::show');
    }
}
