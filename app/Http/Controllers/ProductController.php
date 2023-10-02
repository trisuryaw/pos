<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Http\Resources\UserResource;
use App\Models\ProductModel;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $products = ProductModel::query();

        if($request->has('category')){
            $products->where('category_id', $request->category);
        }

        return response()->json([
            'success' => true,
            'message' => 'Success',
            'data' => ProductResource::collection($products->get())
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\ProductRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ProductRequest $request)
    {
        $product = ProductModel::create($request->validated());
        return response()->json([
            'success' => true,
            'message' => 'Created Success',
            'data' => $product
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id): JsonResponse
    {
        try {
            $data = ProductModel::findOrFail(['id' => $id])->first();
        }catch (ModelNotFoundException $exception){
            return response()->json([
                'success' => true,
                'message' => 'Data not found!',
                'data' => null
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Success',
            'data' => new ProductResource($data)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\ProductRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ProductRequest $request, $id)
    {
        try{
            ProductModel::findOrFail(['id' => $id]);
        }catch (ModelNotFoundException $exception){
            return response()->json([
                'success' => true,
                'message' => 'Data not found!',
                'data' => null
            ]);
        }

        ProductModel::where('id', $id)->update([
            'sku' => $request->validated('sku'),
            'name' => $request->validated('name'),
            'stock' => $request->validated('stock'),
            'price' => $request->validated('price'),
            'image' => $request->validated('image'),
            'category_id' => $request->validated('category_id'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Update Success',
            'data' => new ProductResource(ProductModel::find($id))
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try{
            ProductModel::findOrFail(['id' => $id]);
        }catch (ModelNotFoundException $exception){
            return response()->json([
                'success' => true,
                'message' => 'Data not found!',
                'data' => null
            ]);
        }


        ProductModel::destroy($id);
        return response()->json([
            'success' => true,
            'message' => 'Deleted Success'
        ]);
    }
}
