<?php

namespace App\Http\Controllers;


use App\Models\Message;
use Illuminate\Contracts\Session\Session;
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
    public function index(Request $request)
    {
        $receiverEmail = $request->input('receiver_email');
        // dd($receiverEmail);
        $request->session()->put('receiverEmail', $receiverEmail);
        // dd($request);


        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $messages = Message::where('sender_email', Auth::user()->email)
            ->where('receiver_email', $receiverEmail)
            ->orWhere('sender_email', $receiverEmail)
            ->where('receiver_email', Auth::user()->email)
            ->orderBy('created_at', 'asc')
            ->get();
        
            Message::where('receiver_email', Auth::user()->email)
            ->where('sender_email', $receiverEmail)
            ->update(
                [
                    'status' => 'read'
                ]
            );


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
        // dd( $request->session()->get('receiverEmail'));
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

    public function FetchMessage(Request $request)
    {
        $receiverEmail = $request->session()->get('receiverEmail');

        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $userEmail = Auth::user()->email;

        $messages = Message::where('sender_email', $userEmail)
            ->where('receiver_email', $receiverEmail)
            ->orWhere('sender_email', $receiverEmail)
            ->where('receiver_email', $userEmail)
            ->orderBy('created_at', 'asc')
            ->get();

        // dd($messages);

        return response()->json(['status' => 'success', 'message' => $messages]);
    }



}