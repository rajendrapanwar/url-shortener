<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Super Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Clients Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Clients</h3>
                        <a href="{{ route('companies.create') }}" 
                           class="btn text-black border border-gray-300 px-4 py-2 rounded hover:bg-gray-100 text-sm font-medium">
                            + Create Company
                        </a>
                    </div>
                    
                    <table class="w-full border border-gray-200">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200">
                                <th class="px-4 py-3 text-left text-sm font-medium text-black">Client Name</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-black">Users</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-black">Total Generated URLs</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-black">Total URL Hits</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($companies as $company)
                            <tr class="border-b border-gray-200 hover:bg-gray-50">
                                <td class="px-4 py-3">
                                    <div class="font-semibold text-black">{{ $company->name }}</div>
                                    <div class="text-sm text-gray-500">
                                        {{ $company->users->first()?->email ?? 'No users yet' }}
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-black">{{ $company->users_count }}</td>
                                <td class="px-4 py-3 text-black">{{ $company->short_urls_count }}</td>
                                <td class="px-4 py-3 text-black">0</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-4 py-6 text-center text-gray-500">No companies yet.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-3 text-sm text-gray-500">
                        Showing {{ $companies->count() }} of total {{ $totalCompanies }}
                    </div>

                    <a href="{{ route('companies.index') }}" class="btn text-black border border-gray-300 px-4 py-2 rounded hover:bg-gray-100 text-sm font-medium mt-2 inline-block">View All</a>
                </div>
            </div>

            <!-- Generated Short URLs Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Generated Short URLs</h3>
                        <a href="{{ route('short-urls.index') }}" 
                           class="btn text-black border border-gray-300 px-4 py-2 rounded hover:bg-gray-100 text-sm font-medium">
                            View All
                        </a>
                    </div>
                    
                    <table class="w-full border border-gray-200">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200">
                                <th class="px-4 py-3 text-left text-sm font-medium text-black">Short URL</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-black">Long URL</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-black">Hits</th>
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
                                <td class="px-4 py-3 text-black">0</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-4 py-6 text-center text-gray-500">No short URLs generated yet.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-3 text-sm text-gray-500">
                        Showing {{ $recentUrls->count() }} of total {{ $totalUrls }}
                    </div>

                    <a href="{{ route('short-urls.index') }}" class="btn text-black border border-gray-300 px-4 py-2 rounded hover:bg-gray-100 text-sm font-medium mt-2 inline-block">View All</a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>