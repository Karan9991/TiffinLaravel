<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannersController extends Controller
{
    public function upload(Request $request)
{
    $image = $request->file('image');
    $extension = $image->getClientOriginalExtension();
    $filename = uniqid().'.'.$extension;
    $path = 'storage/banners/'.$filename;

    // Save the file to storage/app/public/banners folder
    $contents = file_get_contents($image->getRealPath());
    file_put_contents(storage_path('app/public/banners/'.$filename), $contents);

    // Save the file path to database without the "public/banners/" prefix
    $banner = new Banner;
    $banner->image = $filename;
    $banner->save();

    return redirect()->back()->with('success', 'Image uploaded successfully.');
}


// public function upload(Request $request)
// {
//     $image = $request->file('image');
//     $filename = $image->getClientOriginalName();
//     $filepath = $image->storeAs('public/banners', $filename);

//     $banner = new Banner;
//     $banner->image = $filepath;
//     $banner->save();

//     return redirect()->back()->with('success', 'Banner uploaded successfully.');
// }


//     public function upload(Request $request)
// {
//     $image = $request->file('image');
//     $filename = $image->getClientOriginalName();
//     $path = $request->file('image')->putFile('banners', $filename);

//     $banner = new Banner;
//     $banner->image = $path;
//     $banner->save();

//     return redirect()->back()->with('success', 'Image uploaded successfully.');
// }


//     public function upload(Request $request)
// {
//     $image = $request->file('image');
//     $filepath = $image->store('public/banners');

//     $banner = new Banner;
//     $banner->image = $filepath;
//     $banner->save();

//     return redirect()->back()->with('success', 'Image uploaded successfully.');
// }

public function index()
{
    $banners = Banner::all();


    return response()->json([
        'success' => true,
        'data' => $banners
    ]);
}

}
