<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use Illuminate\Http\Request;
use App\Models\User;

class ChatController extends Controller
{
    public function storeChat(Request $request)
    {
        // $user = User::find($request->input('user_id'));

        // if (!$user) {
        //     return response()->json([
        //         'status' => 'error',
        //         'message' => 'User not found'
        //     ], 404);
        // }

        $chatMessage = new Chat();
        $chatMessage->sender_id = $request->input('sender_id');
        $chatMessage->receiver_id = $request->input('receiver_id');
        $chatMessage->message = $request->input('message');
        $chatMessage->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Chat message stored successfully'
        ], 200);
    }
    // public function storeChat(Request $request)
    // {
    //     $user = User::find($request->input('user_id'));

    //     if (!$user) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'User not found'
    //         ], 404);
    //     }

    //     $chatMessage = new Chat();
    //     $chatMessage->user_id = $user->id;
    //     $chatMessage->message = $request->input('message');
    //     $chatMessage->save();

    //     return response()->json([
    //         'status' => 'success',
    //         'message' => 'Chat message stored successfully'
    //     ], 200);
    // }

    // public function fetchChat(Request $request)
    // {
    //     $user = User::find($request->input('user_id'));

    //     if (!$user) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'User not found'
    //         ], 404);
    //     }

    //     $chatMessages = Chat::where('user_id', $user->id)->get();

    //     return response()->json([
    //         'status' => 'success',
    //         'data' => $chatMessages,
    //         'messages' => $chatMessages->pluck('message')
    //     ], 200);
    // }

    public function fetchChat()
    {
        $chat = Chat::all();

        return response()->json([
            'success' => true,
            'data' => $chat
        ]);
    }
}
