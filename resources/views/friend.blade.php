<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">{{ __('Friends') }}</h2>
    </x-slot>

    <div class="py-6 space-y-10 max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if (session('status'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                {{ session('status') }}
            </div>
        @endif
        {{-- Search --}}
        <form method="GET" action="{{ route('friends.index') }}" class="mb-6">
            <input type="text" name="search" placeholder="Search friends..." value="{{ $search }}"
                class="w-full sm:w-1/3 px-4 py-2 border rounded shadow-sm">
        </form>

        {{-- All Users --}}
        <div class="bg-white rounded shadow p-6">
            <h3 class="text-lg font-semibold mb-4">All Users</h3>

            @forelse ($users as $user)
                @php
                    $status = $currentUser->friendStatusWith($user->id);
                @endphp
                <div class="flex justify-between items-center border-b py-2">
                    <div>
                        <p class="text-gray-800 font-medium">{{ $user->name }}</p>
                        <p class="text-sm text-gray-500">{{ $user->email }}</p>
                    </div>

                    {{-- Case 1: No friend request exists --}}
                    @if (!$status)
                        <form action="{{ route('friend.send', $user->id) }}" method="POST">
                            @csrf
                            <button class="bg-gray-800 hover:bg-blue-700 text-white py-1 px-4 rounded">
                                Send Request
                            </button>
                        </form>

                    {{-- Case 2: Already friends --}}
                    @elseif ($status->status === 'accepted')
                        <button class="bg-red text-white py-1 px-4 rounded" disabled>
                            Friends
                        </button>

                    {{-- Case 3: Current user SENT the request --}}
                    @elseif ($status->sender_id === $currentUser->id && $status->status === 'pending')
                        <button class="bg-gray-400 text-white py-1 px-4 rounded" disabled>
                            Request Sent
                        </button>

                    {{-- Case 4: Current user RECEIVED the request --}}
                    @elseif ($status->receiver_id === $currentUser->id && $status->status === 'pending')
                        <div class="flex space-x-2">
                            <form action="{{ route('friend.accept', $status->id) }}" method="POST">
                                @csrf
                                <button class="bg-green-500 text-white py-1 px-3 rounded hover:bg-green-600">
                                    Accept
                                </button>
                            </form>
                            <form action="{{ route('friend.reject', $status->id) }}" method="POST">
                                @csrf
                                <button class="bg-red-500 text-white py-1 px-3 rounded hover:bg-red-600">
                                    Reject
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            @empty
                <p class="text-gray-600">No users found.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>
