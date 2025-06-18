<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\FriendRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\FriendRequestReceived;

class FriendController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $currentUser = $user;
        $search = $request->input('search');

        $friends = FriendRequest::where(function ($q) use ($user) {
            $q->where('sender_id', $user->id)->orWhere('receiver_id', $user->id);
        })
        ->where('status', 'accepted')
        ->with(['sender', 'receiver'])
        ->get()
        ->map(function ($req) use ($user) {
            return $req->sender_id == $user->id ? $req->receiver : $req->sender;
        });

        $excludeIds = $friends->pluck('id')->push($user->id)->toArray();

        $users = User::whereNotIn('id', $excludeIds)
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%$search%")
                      ->orWhere('email', 'like', "%$search%");
            })
            ->get();

        return view('friend', compact('users', 'search', 'currentUser'));
    }

    public function sendRequest($receiverId)
    {
        $sender = auth()->user();
        $receiver = User::findOrFail($receiverId);

        // Check if already exists
        $exists = FriendRequest::where(function($q) use ($sender, $receiver) {
            $q->where('sender_id', $sender->id)->where('receiver_id', $receiver->id);
        })->orWhere(function($q) use ($sender, $receiver) {
            $q->where('sender_id', $receiver->id)->where('receiver_id', $sender->id);
        })->exists();

        if ($exists) {
            return back()->with('error', 'Friend request already sent or already friends.');
        }

        FriendRequest::create([
            'sender_id' => $sender->id,
            'receiver_id' => $receiver->id,
            'status' => 'pending',
        ]);

        // Send email to receiver
        Mail::to($receiver->email, $receiver->email)->send(new FriendRequestReceived($sender));

        return back()->with('status', 'Friend request sent!');
    }


    public function destroy($id)
    {
        $user = Auth::user();

        $friendRequest = FriendRequest::where(function($q) use ($user, $id) {
            $q->where('sender_id', $user->id)->where('receiver_id', $id);
        })->orWhere(function($q) use ($user, $id) {
            $q->where('sender_id', $id)->where('receiver_id', $user->id);
        })->first();

        if ($friendRequest) {
            $friendRequest->delete();
            return back()->with('status', 'Friend removed successfully.');
        }

        return back()->with('error', 'Friend not found.');
    }


}
