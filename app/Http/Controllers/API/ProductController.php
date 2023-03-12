<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Product;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
    public function index()
    {
        $data = Product::latest()->get();
        return response()->json([ProductResource::collection($data)]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|unique:products,code',
            'name' => 'required|unique:products,name',
            'price' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $product = Product::create([
            'code' => $request->code,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price
        ]);

        return response()->json(['Product created successfully.', new ProductResource($product)]);
    }

    public function show($id)
    {
        $product = Product::find($id);

        if (is_null($product)) {
            return response()->json('Data not found', 404);
        }

        return response()->json([new ProductResource($product)]);
    }

    public function getNewProductCode()
    {
        $lastProductCode = Product::select('code')->orderBy('code', 'DESC')->first();

        if ($lastProductCode) {
            return ++$lastProductCode->code;
        }

        return "VAF-0001";
    }

    public function update(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|unique:products,code,'. $product->id,
            'name' => 'required|unique:products,name,'. $product->id,
            'price' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $product->code = $request->code;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->save();

        return response()->json(['Product updated successfully.', new ProductResource($product)]);
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json('Product deleted successfully');
    }
}
