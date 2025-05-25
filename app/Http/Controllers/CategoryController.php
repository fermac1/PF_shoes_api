<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function getCategories()
    {
        $categories = Category::latest()->paginate(4);

        return response()->json(['categories' => $categories ]);

    }

    public function createCategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|required',
            'description' => 'required'
        ]);

        if ($validator->fails()) {
            // Log::error('Validation errors:', $validator->errors());
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validated = $validator->validated();

        try {
            $category = Category::create($validated);

            return response()->json(['message' => 'Category created succesfully', 'data' => $category]);
        } catch (Exception $e) {
            return response()->json(['error' => 'An error occurred', 'message' => $e->getMessage()], 500);
        }
    }

    public function updateCategory(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'string|required',
            'description' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $category->update([$validator]);

        return response()->json([
            'success' => true,
            'message' => 'Category updated successfully!'
        ], 200);
    }

    public function deleteCategory()
    {

    }
}
