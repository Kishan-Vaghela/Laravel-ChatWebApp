<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use App\Models\FriendRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class FriendRequestController extends Controller
{
    //
    public function DisplayFriend()
    {
        $existingRequests = FriendRequest::where('sender_email', Auth::user()->email)->pluck('receiver_email')->toArray();


        $exitisingfriends = User::where('id', '!=', Auth::user()->id)->get();

        // dd($exitisingfriends);
        return view("FriendRequest.friendlist", compact("exitisingfriends", "existingRequests"));
    }


    public function SearchFriend(Request $request)
    {
        $search = $request->input('search');
        $searchResults = User::where('name', 'like', "%{$search}%")->get();
        return response()->json($searchResults);
    }

    public function SendRequest(Request $request)
    {

        $request->validate([
            'receiver_email' => 'required|email|exists:users,email',
        ]);
        $senderEmail = Auth::user()->email;
        $receiverEmail = $request->receiver_email;

        $existingRequest = FriendRequest::where('sender_email', $senderEmail)
            ->where('receiver_email', $receiverEmail)
            ->exists();

        if ($existingRequest) {
            return response()->json(['error' => 'Request already sent'], 422);
        }

        FriendRequest::create([
            'sender_email' => $senderEmail,
            'receiver_email' => $receiverEmail
        ]);

        return response()->json(['message' => 'Friend Request Sent Successfully']);
    }
    public function ShowFriendRequest()
    {
        $friendRequest = FriendRequest::where('receiver_email', Auth::user()->email)->get();
        // dd($friendRequest);
        // dd(Auth::user()->email);
        return view('FriendRequest.friendrequest', compact('friendRequest'));
    }

    public function rejectFriendRequest(Request $request)
    {

        $userEmail = Auth::user()->email;

        $friendRequests = FriendRequest::where('receiver_email', $userEmail)->get();
        foreach ($friendRequests as $friendRequest) {

            $friendRequest->delete();
        }
        if ($friendRequests->count() == 0) {
            return response()->json(['message' => 'No Friend Request Found']);
        }
        // return back()->with('message', 'Friend Requests Rejected Successfully');
        return response()->json(['message' => 'Friend Request Sent Successfully']);
    }


    public function acceptFriendRequest(Request $request)
    {

        $userEmail = Auth::user()->email;

        $friendRequests = FriendRequest::where('receiver_email', $userEmail)->get();



        foreach ($friendRequests as $friendRequest) {
            $friendRequest->status = 'accepted';
            $friendRequest->save();
        }

        $acceptedFriendRequest = FriendRequest::where('status', '=', 'accepted');
        if ($acceptedFriendRequest) {
            return response()->json(['message' => 'You are friends!']);
        }
        return response()->json(['message' => 'Friend request(s) accepted successfully']);
    }



    public function DisplayAcceptedFriend(Request $request)
{
    $acceptedFriendRequest = FriendRequest::where('status', 'accepted')
        ->where('receiver_email', '!=', Auth::user()->email)
        ->get();

    foreach ($acceptedFriendRequest as $request) {
        $unreadMessagesCount = Message::where('receiver_email', Auth::user()->email)
            ->where('sender_email', $request->receiver_email)
            ->where('status', 'unread')
            ->count();

        $request->unread_messages_count = $unreadMessagesCount;
    }

    return view('FriendRequest.acceptedrequest', compact('acceptedFriendRequest'));
}

    
  




}
