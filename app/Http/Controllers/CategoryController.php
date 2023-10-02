<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\CategoryModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json([
            'success' => true,
            'message' => 'Success',
            'data' => CategoryModel::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\CategoryRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CategoryRequest $request)
    {
        $category = CategoryModel::create($request->validated());
        return response()->json([
            'success' => true,
            'message' => 'Created Success',
            'data' => $category
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        return response()->json([
            'success' => true,
            'message' => 'Success',
            'data' => CategoryModel::find($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\CategoryRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CategoryRequest $request, $id)
    {
        try {
            CategoryModel::findOrFail(['id' => $id]);
        }catch (ModelNotFoundException $exception){
            return response()->json([
                'success' => true,
                'message' => 'Data not found!',
                'data' => null
            ]);
        }

        CategoryModel::where('id', $id)->update([
            'name' => $request->validated('name')
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Updated Success',
            'data' => CategoryModel::find($id)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            CategoryModel::findOrFail(['id' => $id]);
        }catch (ModelNotFoundException $exception){
            return response()->json([
                'success' => true,
                'message' => 'Data not found!',
                'data' => null
            ]);
        }

        CategoryModel::destroy($id);
        return response()->json([
            'success' => true,
            'message' => 'Deleted Success'
        ]);
    }
}
