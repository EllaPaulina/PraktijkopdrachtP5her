<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            return redirect()->route('articles.index')->with('error', 'Unauthorized access.');
        }
        $categories = Category::all();
        return view('category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the 'name' field, which should match what you're using later.
        $validatedData = $request->validate([
            'name' => 'required|unique:categories,name|max:255', // Validate 'name' instead of 'category'
        ], [
            'name.required' => 'The category field is required.',
            'name.unique' => 'This category already exists, please choose a different one.',
            'name.max' => 'The category name cannot be longer than 255 characters.',
        ]);

        // Save the validated 'name'
        $category = new Category();
        $category->name = $validatedData['name']; // Access 'name' instead of 'category'
        $category->save();

        return redirect()->route('categories.index')->with('success', 'Category created successfully!');
    }



    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
    }
}
