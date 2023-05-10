<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
  

    public function index()
    {
        $categories = Category::all();

        return response()->json([
            'success' => true,
            'data' => $categories
        ]);
    }
   

public function store(Request $request)
{
    // Validate the form data
    $validatedData = $request->validate([
        'name' => 'required|max:255',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    $category = new Category();
    $category->name = $request->name;

    $image = $request->file('image');

    $extension = $image->getClientOriginalExtension();
    $filename = uniqid().'.'.$extension;
    $path = 'storage/banners/'.$filename;

    // Save the file to storage/app/public/banners folder
    $contents = file_get_contents($image->getRealPath());
    file_put_contents(storage_path('app/public/categories/'.$filename), $contents);

    // Save the file path to database without the "public/banners/" prefix
    $category->image = $filename;
    $category->save();
    // $filepath = $image->store('public/categories');

    // $category->image = $filepath;
    // $category->save();

    return redirect()->back()->with('success', 'Category added successfully.');

}



}
