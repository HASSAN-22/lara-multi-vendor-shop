<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny',Category::class);
        $categories = Category::with('category')->latest()->search()->paginate(config('app.paginate'));
        return view('admin.category.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create',Category::class);
        $categories = Category::get();
        return view('admin.category.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $this->authorize('create',Category::class);
        return responseMessage($this->updateAndCreate(new Category(), $request),'create');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $this->authorize('update',$category);
        $categories = Category::get();
        return view('admin.category.update',compact('categories','category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $this->authorize('update',$category);
        return responseMessage($this->updateAndCreate($category, $request),'update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $this->authorize('update',$category);
        DB::beginTransaction();
        try{
            $category->delete();
            $this->deleteChildes($category);
            DB::commit();
            return responseMessage(true,'delete');
        }catch (\Exception $e){
            return responseMessage(false,'delete');
        }
    }

    private function deleteChildes($category){
        foreach($category->childes as $child){
            $child->delete();
            $this->deleteChildes($child);
        }
    }

    private function updateAndCreate(Category $category, CategoryRequest $request){
        $category->parent_id = $request->parent_id;
        $category->title = $request->title;
        $category->slug = slug($request->title);
        $category->status = $request->status;
        $category->meta_description = $request->meta_description;
        $category->meta_keyword = $request->meta_keyword;
        return $category->save();
    }
}
