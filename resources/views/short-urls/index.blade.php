<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Short URLs') }}
            </h2>
            @if(!auth()->user()->isSuperAdmin())
            <a href="{{ route('short-urls.create') }}" 
               class="btn text-black border border-gray-300 px-4 py-2 rounded hover:bg-gray-100 text-sm font-medium">
                + Create Short URL
            </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <table class="w-full border border-gray-200" id="short-urls-table">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200">
                                <th class="px-4 py-3 text-left text-sm font-medium text-black">Short URL</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-black">Original URL</th>
                                @if(auth()->user()->isSuperAdmin())
                                    <th class="px-4 py-3 text-left text-sm font-medium text-black">Company</th>
                                @endif
                                @if(!auth()->user()->isMember())
                                    <th class="px-4 py-3 text-left text-sm font-medium text-black">Created By</th>
                                @endif
                                <th class="px-4 py-3 text-left text-sm font-medium text-black">Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($shortUrls as $shortUrl)
                            <tr class="border-b border-gray-200 hover:bg-gray-50">
                                <td class="px-4 py-3">
                                    <a href="{{ url($shortUrl->short_code) }}" 
                                       class="text-blue-600 hover:underline" 
                                       target="_blank">
                                        {{ url($shortUrl->short_code) }}
                                    </a>
                                </td>
                                <td class="px-4 py-3 text-black">
                                    {{ \Illuminate\Support\Str::limit($shortUrl->original_url, 50) }}
                                </td>
                                @if(auth()->user()->isSuperAdmin())
                                    <td class="px-4 py-3 text-black">{{ $shortUrl->company->name }}</td>
                                @endif
                                @if(!auth()->user()->isMember())
                                    <td class="px-4 py-3 text-black">{{ $shortUrl->user->name }}</td>
                                @endif
                                <td class="px-4 py-3 text-black">
                                    {{ $shortUrl->created_at->format('M d, Y H:i') }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-4 py-6 text-center text-gray-500">
                                    No short URLs found.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
     @push('scripts')
<script>
    $(document).ready(function () {
        @if(auth()->user()->isSuperAdmin())
            initializeDataTable('short-urls-table', { order: [[4, 'desc']] });  // 5 columns
        @elseif(auth()->user()->isAdmin())
            initializeDataTable('short-urls-table', { order: [[3, 'desc']] });  // 4 columns
        @else
            initializeDataTable('short-urls-table', { order: [[2, 'desc']] });  // 3 columns
        @endif
    });
</script>
@endpush
</x-app-layout>