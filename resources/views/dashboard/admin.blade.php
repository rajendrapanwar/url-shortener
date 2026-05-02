<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Admin Dashboard') }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('invitations.create') }}" 
                   class="btn text-black border border-gray-300 px-4 py-2 rounded hover:bg-gray-100 text-sm font-medium">
                    + Invite User
                </a>
                <a href="{{ route('short-urls.create') }}" 
                   class="btn text-black border border-gray-300 px-4 py-2 rounded hover:bg-gray-100 text-sm font-medium">
                    + Create Short URL
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-2 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-3xl font-bold text-black">{{ $totalUrls }}</div>
                        <div class="text-gray-500 text-sm mt-1">Total Short URLs</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-3xl font-bold text-black">{{ $totalMembers }}</div>
                        <div class="text-gray-500 text-sm mt-1">Team Members</div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-black mb-4">Recent URLs</h3>
                    
                    <table class="w-full border border-gray-200">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200">
                                <th class="px-4 py-3 text-left text-sm font-medium text-black">Short URL</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-black">Original URL</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-black">Created By</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-black">Created</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentUrls as $url)
                            <tr class="border-b border-gray-200 hover:bg-gray-50">
                                <td class="px-4 py-3">
                                    <a href="{{ url($url->short_code) }}" class="text-blue-600 hover:underline" target="_blank">
                                        {{ url($url->short_code) }}
                                    </a>
                                </td>
                                <td class="px-4 py-3 text-black">{{ \Illuminate\Support\Str::limit($url->original_url, 40) }}</td>
                                <td class="px-4 py-3 text-black">{{ $url->user->name }}</td>
                                <td class="px-4 py-3 text-black">{{ $url->created_at->format('M d, Y') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-4 py-6 text-center text-gray-500">No URLs created yet.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <a href="{{ route('short-urls.index') }}" class="btn text-black border border-gray-300 px-4 py-2 rounded hover:bg-gray-100 text-sm font-medium mt-4 inline-block">View All</a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>