<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\FriendRequest;


class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Get accepted friends
        $acceptedFriends = FriendRequest::where(function($query) use ($user) {
            $query->where('sender_id', $user->id)
                  ->orWhere('receiver_id', $user->id);
        })
        ->where('status', 'accepted')
        ->with(['sender', 'receiver'])
        ->get()
        ->map(function($friendRequest) use ($user) {
            return $friendRequest->sender_id === $user->id
                ? $friendRequest->receiver
                : $friendRequest->sender;
        });

        // Get pending friend requests (received)
        $pendingRequests = FriendRequest::where('receiver_id', $user->id)
            ->where('status', 'pending')
            ->with('sender')
            ->get();

        return view('dashboard', compact('acceptedFriends', 'pendingRequests'));
    }
}
