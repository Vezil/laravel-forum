<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Interfaces\Resources\CategoryRepositoryInterface;
use App\Models\Category;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->middleware('JWT', ['except' => ['index', 'show']]);

        $this->categoryRepository = $categoryRepository;
    }

    public function index()
    {
        return $this->categoryRepository->index();
    }

    public function store(CategoryRequest $request)
    {

        $category = new Category;
        $category->name = $request->name;
        $category->slug = str_slug($request->name);
        $category->save();

        $formattedCategory = $this->categoryRepository->toArray($category);

        return response(['category' => $formattedCategory], Response::HTTP_CREATED);
    }

    public function show(Category $category)
    {
        return $this->categoryRepository->show($category);
    }

    public function update(Request $request, Category $category)
    {
        $category->update(
            [
                'name' => $request->name,
                'slug' => str_slug($request->name)
            ]
        );

        $formattedCategory = $this->categoryRepository->toArray($category);

        return response($formattedCategory, Response::HTTP_OK);
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
