<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FriendRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class FriendRequestController extends Controller
{
    public function accept($id): RedirectResponse
    {
        $request = FriendRequest::where('id', $id)
            ->where('receiver_id', Auth::id())
            ->firstOrFail();

        $request->status = 'accepted';
        $request->save();

        return redirect()->route('dashboard')->with('status', 'Friend request accepted.');
    }

    public function reject($id): RedirectResponse
    {
        $request = FriendRequest::where('id', $id)
            ->where('receiver_id', Auth::id())
            ->firstOrFail();

        $request->delete();

        return redirect()->route('dashboard')->with('status', 'Friend request rejected.');
    }
}
