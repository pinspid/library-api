<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Resources\Category as ResourcesCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(){
        $categories =  Category::orderBy('wording')->get();
        return ResourcesCategory::collection($categories);
    }

    public function show(int $id) {
        $category = Category::where('id', $id)->firstOrFail();
        return new ResourcesCategory($category);
    }

    public function store(Request $request) {
        $category = $this->validation($request);
        Category::create($category);
        return response()->json(['success' => 'category add successfuly']);
    }

    public function update(Request $request, int $id) {
        $category = Category::where('id', $id)->firstOrFail();
        $category->update($this->validation($request));
        return response()->json(['success' => 'category has been update']);
    }

    public function destroy(int $id) {
        $category = Category::where('id', $id)->firstOrFail();
        $category->delete();
        return response()->json(['success' => 'catagory has been delete']);
    }

    private function validation(Request $request) {
        return $request->validate([
            'wording' => 'required|string'
        ]);
    }
}
