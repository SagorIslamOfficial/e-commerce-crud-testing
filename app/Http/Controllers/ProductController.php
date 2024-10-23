<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(10);
        return view('backend.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $subcategories = Subcategory::all();
        return view('backend.product.create', compact('categories', 'subcategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:subcategories,id',
            'name' => 'required|max:255|unique:products',
            'description' => 'required',
            'image*' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'old_price' => 'required|numeric',
            'new_price' => 'required|numeric',
        ]);

        $product = Product::create([
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'old_price' => $request->old_price,
            'new_price' => $request->new_price
        ]);

        $image = $request->file('image');
        if (isset($image)) {
            // Get the image name
            $slug = Str::slug($request->name);

            // Get the image extension
            $imageName = $slug . '.' . $image->getClientOriginalExtension();

            // Checking the image directory amd if not exist create it
            if (!Storage::disk('public')->exists('products')) {
                Storage::disk('public')->makeDirectory('products');
            }

            // Using the intervention v2 library to resize the image
            $imageResize = Image::make($image)->resize(350, 280)->stream();

            // Storing the image in the products directory
            Storage::disk('public')->put('products/' . $imageName, $imageResize);

            $product->image = $imageName;
            $product->save();
        }

        return redirect()->route('product.index')->with('success', 'Product created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('backend.product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::find($id);
        $categories = Category::all();
        $subcategories = Subcategory::where('category_id', $product->category_id)->get();
        return view('backend.product.edit', compact('product', 'categories', 'subcategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:subcategories,id',
            'name' => 'required|max:255|unique:products,name,' . $product->id,
            'description' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'old_price' => 'required|numeric',
            'new_price' => 'required|numeric',
        ]);

        $product->update([
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'old_price' => $request->old_price,
            'new_price' => $request->new_price,
        ]);

        $image = $request->file('image');
        if (isset($image)) {
            // Get the image name
            $slug = Str::slug($request->name);

            // Get the image extension
            $imageName = $slug . '.' . $image->getClientOriginalExtension();

            // Checking the image directory amd if not exist create it
            if (!Storage::disk('public')->exists('products')) {
                Storage::disk('public')->makeDirectory('products');
            }

            // Delete old image
            if (Storage::disk('public')->exists('products/' . $product->image)){
                Storage::disk('public')->delete('products/' . $product->image);
            }

            // Using the intervention v3 library to resize the image
            $imageResize = Image::make($image)->resize(350, 280)->stream();

            // Storing the image in the products directory
            Storage::disk('public')->put('products/' . $imageName, $imageResize);

            $product->image = $imageName;
            $product->save();
        }

        return redirect()->route('product.index')->with('success', 'Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if (Storage::disk('public')->exists('products/' . $product->image)){
            Storage::disk('public')->delete('products/' . $product->image);
        }

        $product->delete();

        return redirect()->route('product.index')->with('success', 'Product deleted successfully');
    }
}
