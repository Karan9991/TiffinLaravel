<?php

namespace App\Http\Controllers;

use App\Models\CreateKitchen;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;

class CreateKitchenController extends Controller
{

    public function getAllKitchens()
{
    $kitchen = CreateKitchen::all();

    return response()->json([
        'success' => true,
        'data' => $kitchen
    ]);
}

public function deleteKitchen($id)
{
    $kitchen = CreateKitchen::find($id);
    if (!$kitchen) {
        return response()->json([
            'success' => false,
            'message' => 'Kitchen not found'
        ], 404);
    }

    $kitchen->delete();

    return response()->json([
        'success' => true,
        'message' => 'Kitchen deleted successfully'
    ]);
}

    public function create(Request $request)
{
    // Validate request parameters
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'image' => 'required',
        'user_id' => 'required|integer'
    ]);

    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 400);
    }

    // Upload image file
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time().'.'.$image->getClientOriginalExtension();
        $contents = file_get_contents($image->getRealPath());
        file_put_contents(storage_path('app/public/kitchens/'.$imageName), $contents);
       // $image->move(public_path('kitchen_images'), $imageName);
    }

    // Create new kitchen
    $kitchen = new CreateKitchen();
    $kitchen->name = $request->name;
    $kitchen->image = $imageName;
    $kitchen->user_id = $request->user_id;
    $kitchen->save();

    return response()->json(['message' => 'Kitchen created successfully']);
}

// public function getKitchenByUserId(Request $request)
// {
//     // Validate request parameters
//     $validator = Validator::make($request->all(), [
//         'user_id' => 'required|integer'
//     ]);

//     if ($validator->fails()) {
//         return response()->json(['error' => $validator->errors()], 400);
//     }

//     // Get kitchen data
//     $kitchen = CreateKitchen::where('user_id', $request->user_id)->first();

//     if (!$kitchen) {
//         return response()->json(['error' => 'Kitchen not found'], 404);
//     }

//     $kitchenData = [
//         'success' => true,
//         'name' => $kitchen->name,
//         'image' => $kitchen->image
//        // 'image' => $kitchen->image ? url('storage/kitchens/'.$kitchen->image) : null
//     ];

//     return response()->json(['data' => $kitchenData]);
// }

public function getKitchenByUserId(Request $request)
{
    $user_id = $request->query('user_id');
    $kitchen = CreateKitchen::where('user_id', $user_id)->get();

    return response()->json([
        'success' => true,
        'data' => $kitchen
    ]);
}


}
