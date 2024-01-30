<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\CategoryRequest;
use App\Http\Resources\v1\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pageCount = request()->get('page_count') ?? 4;
        // $query = Category::query();
        // if(request()->has('search')){
        //     $search = request()->get('search');
        //     $query->where('title', 'like', "%$search%");
        // }
        // $orderBy = request()->get('order_by') ?? 'created_at';
        // $orderDir = request()->get('order_dir') ?? 'desc';
        // $query->orderBy($orderBy, $orderDir);

        $category=Category::paginate($pageCount);
        return  CategoryResource::collection($category);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        $category=Category::create([
            'parent_id' => $request['parent_id'],
            'name' => $request['name'],
            'description' => $request['description'],
        ]);
        return new CategoryResource($category);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $category->update([
            'parent_id' => $request['parent_id'],
            'name' => $request['name'],
            'description' => $request['description'],
        ]);
        return new CategoryResource($category);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return new CategoryResource($category);
    }

    public function Subcategory(Category $category)
    {
        return new CategoryResource($category->load('Subcategory'));
    }

    public function parentcategory(Category $category)
    {
        return new CategoryResource($category->load('parentcategory'));
    }

    public function products(Category $category)
    {
        return new CategoryResource($category->load('products'));
    }


}
