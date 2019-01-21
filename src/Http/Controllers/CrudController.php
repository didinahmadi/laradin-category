<?php

namespace Laradin\Category\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Laradin\Category\Category;
use Laradin\Category\Http\Requests\CategoryRequest;

class CrudController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Category::get();
        return view('laradin-category::category.index', [
            'items' => $items
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categoryList = Category::getList();        
        return view('laradin-category::category.create', [
            'categoryList' => $categoryList
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $validated = $request->validated();


        if ( null!==($category = Category::create($request->all())) ) {
            return redirect(laradin_route('index'))->with([
                'notification' => [
                    'class' => 'success',
                    'message' => __('New category created successfully')
                ]
            ]);
        } else {
            return redirect(laredin_route('index'))->with([
                'notification' => [
                    'class' => 'danger',
                    'message' => __('New category created failed')
                ]
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = Category::findOrFail($id);
        return view('laradin-category::category.show', [
            'model' => $model
        ]);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = Category::findOrFail($id);
        $categoryList = Category::getList(null, [$id]);
        return view('laradin-category::category.edit', [
            'model' => $model,
            'categoryList' => $categoryList
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $id)
    {
        $request->validated();
        $model = Category::findOrFail($id);
        $data  = array_merge(['active' => Category::ACTIVE_NO], $request->all());

        if ($model->update($data)) {
            return redirect(laradin_route('show', ['category' => $model]))->with([
                'notification' => [
                    'class' => 'success',
                    'message' => __('Category updated successfully')
                ]
            ]);
        } else {
            return redirect(laradin_route('edit', ['category' => $model]))->with([
                'notification' => [
                    'class' => 'danger',
                    'message' => __('Category updated failed')
                ]
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
