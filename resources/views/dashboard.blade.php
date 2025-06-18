<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">Dashboard</h2>
    </x-slot>

    <div class="py-6 space-y-10 max-w-7xl mx-auto sm:px-6 lg:px-8">

        <!-- Accepted Friends -->
        <div class="bg-white p-6 rounded shadow">
            <h3 class="text-lg font-bold mb-4">Your Friends</h3>
            @if($acceptedFriends->count())
                <table class="min-w-full bg-white rounded shadow overflow-hidden w-full">
                    <thead class="bg-gray-100 text-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left">Image</th>
                            <th class="px-6 py-3 text-left">Name</th>
                            <th class="px-6 py-3 text-left">Email</th>
                            <th class="px-6 py-3 text-left">Contact</th>
                            <th class="px-6 py-3 text-left">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 justify-item-center">
                        @foreach($acceptedFriends as $friend)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-gray-600">
                                    @if($friend->profile_picture)
                                        <img src="{{ asset('storage/' . $friend->profile_picture) }}" alt="Profile" class="w-20 h-20 rounded-full">
                                    @else
                                        {{ '—' }}
                                    @endif
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-800">{{ $friend->name }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $friend->email }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $friend->contact ?? '—' }}</td>
                                <td class="px-6 py-4">
                                    <form action="{{ route('friend.delete', $friend->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove this friend?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-600 text-white text-sm px-4 py-2 rounded hover:bg-red-600">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>No friends yet.</p>
            @endif
        </div>

        <!-- Pending Friend Requests -->
        <div class="bg-white p-6 rounded shadow">
            <h3 class="text-lg font-bold mb-4">Pending Friend Requests</h3>
            @if($pendingRequests->count())
                <table class="min-w-full bg-white rounded shadow overflow-hidden w-full">
                    <thead class="bg-gray-100 text-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left">Name</th>
                            <th class="px-6 py-3 text-left">Email</th>
                            <th class="px-6 py-3 text-left">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 justify-item-center">
                        @foreach($pendingRequests as $request)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 font-medium text-gray-800">{{ $request->sender->name }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $request->sender->email }}</td>
                                <td class="px-6 py-4 flex space-x-1 justify-center">
                                    <form method="POST" action="{{ route('friend.accept', $request->id) }}">
                                        @csrf
                                        <button type="submit" class="bg-gray-800 text-white text-sm px-4 py-2 rounded hover:bg-red-600">
                                            Accept
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('friend.reject', $request->id) }}">
                                        @csrf
                                        <button type="submit" class="bg-red-600 text-white text-sm px-4 py-2 rounded hover:bg-red-600">
                                            Reject
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>No pending requests.</p>
            @endif
        </div>
    </div>
</x-app-layout>
