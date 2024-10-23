<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subcategories = Subcategory::latest()->paginate(10);
        return view('backend.sub-category.index', compact('subcategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('backend.sub-category.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories|max:50',
            'category_id' => 'required|exists:categories,id',
        ]);

        Subcategory::create([
            'name' => $request->name,
            'slug' => Str::slug($request['name']),
            'category_id' => $request->category_id
        ]);

        return redirect()->route('subcategory.index')->with( 'success', 'Sub-Category created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $subcategory = Subcategory::find($id);
        $categories = Category::all();

        return view('backend.sub-category.edit', compact('subcategory', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subcategory $subcategory)
    {
        $request->validate([
            'name' => 'required|max:50|unique:categories,name,' . $subcategory->id,
            'category_id' => 'required|exists:categories,id',
        ]);

        $subcategory->update([
            'name' => $request->name,
            'slug' => Str::slug($request['name']),
            'category_id' => $request->category_id
        ]);

        return redirect()->route('subcategory.index')->with('success', 'Sub-Category updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subcategory $subcategory)
    {
        $subcategory->delete();
        return redirect()->route('subcategory.index')->with('success', 'Sub-Category deleted successfully');
    }

    public function getSubcategories($categoryId)
    {
        // Fetch subcategories based on the selected category
        $subcategories = Subcategory::where('category_id', $categoryId)->get();

        // Return as JSON response
        return response()->json($subcategories);
    }
}
