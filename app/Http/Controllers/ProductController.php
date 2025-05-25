<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getProducts()
    {
        $products = Product::latest()->paginate(4);

        return response()->json(['products' => $products ]);

    }

    public function singleproduct($id)
    {
        try {
            $product = Product::findOrFail($id);
            return response()->json(['product' => $product ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Product not Found'], 404);
        }

    }

    public function createProduct(CreateProductRequest $request)
    {
        $validated = $request->validated();

        try {
            $product = Product::create($validated);

            return response()->json(['message' => 'Product created succesfully', 'data' => $product]);
        } catch (Exception $e) {
            return response()->json(['error' => 'An error occurred', 'message' => $e->getMessage()], 500);
        }
    }

    public function updateProduct(UpdateProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validated();

        try {
            $product->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Product updated successfully!'
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Product not Found'], 404);
        }
    }
}
