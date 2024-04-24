<?php

namespace App\Http\Controllers;


use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Contracts\View\View;

class ChatController extends Controller
{
    /**
     * Fetch all messages.
     *
     * @return View
     */
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $messages = Message::orderBy('created_at', 'asc')->get();
        
        // dd($messages);

        return view('FriendRequest.chat', compact('messages'));
    }

    /**
     * Send a message.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    // ChatController.php
    public function sendMessage(Request $request)
    {
        
        $request->validate([
            'message' => 'required|string',
            'receiver_email' => 'required|email|exists:users,email',
        ]);

        if (!Auth::check()) {
            return response()->json(['status' => 'error', 'message' => 'User not logged in']);
        }

        $message = Message::create([
            'sender_email' => Auth::user()->email,
            'receiver_email' => $request->receiver_email,
            'message' => $request->input('message'),
        ]);
        // dd($message);
        return response()->json(['status' => 'success', 'message' => $message]);
    }



    public function FetchMessage(){

        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $messages = Message::orderBy('created_at', 'asc')->get();
        // dd($messages);,
        return response()->json(['status'=> 'success','message'=> $messages]);
    }
}