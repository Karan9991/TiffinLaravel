<?php

namespace App\Http\Controllers;

use App\Models\TiffinRecipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TiffinRecipeController extends Controller
{
    public function index()
    {
        $tiffin = TiffinRecipe::all();

        return response()->json([
            'success' => true,
            'data' => $tiffin
        ]);
    }

//     public function gettiffins($user_id)
// {
//     $tiffin = TiffinRecipe::where('user_id', $user_id)->get();

//     return response()->json([
//         'success' => true,
//         'data' => $tiffin
//     ]);
// }
public function gettiffins(Request $request)
{
    $user_id = $request->query('user_id');
    $tiffin = TiffinRecipe::where('user_id', $user_id)->get();

    return response()->json([
        'success' => true,
        'data' => $tiffin
    ]);
}

// public function edittiffin(Request $request, $id)
// {
//     $tiffin = TiffinRecipe::findOrFail($id);

//     // delete old image from storage if new image is uploaded
//     if ($request->hasFile('image')) {
//         Storage::delete($tiffin->image);
//         $image = $request->file('image');
//         $filename = time() . '.' . $image->getClientOriginalExtension();
//         $path = 'tiffins/' . $filename;
//         Storage::putFileAs('public', $image, $path);
//         $tiffin->image = $path;
//     }

//     $tiffin->name = $request->input('name');
//     $tiffin->price = $request->input('price');
//     $tiffin->description = $request->input('description');
//     $tiffin->save();

//     return response()->json(['message' => 'Tiffin updated successfully', 'data' => $tiffin], 200);
// }


public function editTiffin(Request $request, $id)
{
    //dd($request->all());

    $request->validate([
        'name'=>'required',
        'price'=>'required',
        'description'=>'required'
    ]);

    $tiffin = TiffinRecipe::find($id);

    if (!$tiffin) {
        return response()->json([
            'success' => false,
            'message' => 'Tiffin not found'
        ]);
    }

   // dd($request->all()); // add this line

    $tiffin->name = $request->get('name');
    $tiffin->description = $request->get('description');
    $tiffin->price = $request->get('price');

    // Delete old image if user uploaded a new one
    if ($request->hasFile('image')) {
        Storage::delete($tiffin->image); // Delete old image from storage
        $imagePath = $request->file('image')->store('public/tiffinrecipes');
        $tiffin->image = basename($imagePath);
    }

    $tiffin->save();

    return response()->json([
        'success' => true,
        'data' => $tiffin
    ]);
}


public function deletetiffin($id)
{
    $tiffin = TiffinRecipe::find($id);
    if (!$tiffin) {
        return response()->json([
            'success' => false,
            'message' => 'Tiffin not found'
        ], 404);
    }

    $tiffin->delete();

    return response()->json([
        'success' => true,
        'message' => 'Tiffin deleted successfully'
    ]);
}


    /**
     * Store a newly created category in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   

public function store(Request $request)
{
    // Validate the form data
    $validatedData = $request->validate([
        'name' => 'required|max:255',
        'image' => 'required',
    ]);

    // Save the category data to the database
    $tiffin = new TiffinRecipe();
    $tiffin->name = $request->name;
    $tiffin->price = $request->price;
    $tiffin->description = $request->description;
    $tiffin->user_id = $request->user_id;
    // $tiffin->category_id = $request->category_id;

    $image = $request->file('image');
    $extension = $image->getClientOriginalExtension();
    $filename = uniqid().'.'.$extension;
    $path = 'storage/banners/'.$filename;

    // Save the file to storage/app/public/banners folder
    $contents = file_get_contents($image->getRealPath());
    file_put_contents(storage_path('app/public/tiffinrecipes/'.$filename), $contents);


   // $filepath = $image->store('public/tiffinrecipes');

    $tiffin->image = $filename;
    $tiffin->save();
    return response()->json(['message' => 'Tiffin published successfully. Customers will contact you soon!']);

    //return redirect()->back()->with('success', 'TiffinRecipe added successfully.');

}

// public function upload(Request $request)
// {
//     $image = $request->file('image');
//     $extension = $image->getClientOriginalExtension();
//     $filename = uniqid().'.'.$extension;
//     $path = 'storage/banners/'.$filename;

//     // Save the file to storage/app/public/banners folder
//     $contents = file_get_contents($image->getRealPath());
//     file_put_contents(storage_path('app/public/banners/'.$filename), $contents);

//     // Save the file path to database without the "public/banners/" prefix
//     $banner = new Banner;
//     $banner->image = $filename;
//     $banner->save();

//     return redirect()->back()->with('success', 'Image uploaded successfully.');
// }

}
