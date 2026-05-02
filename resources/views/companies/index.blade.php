<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Companies') }}
            </h2>
            <a href="{{ route('companies.create') }}" 
               class="btn text-black border border-gray-300 px-4 py-2 rounded hover:bg-gray-100 text-sm font-medium">
                + Create Company
            </a>
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

                    <table class="w-full border border-gray-200" id="companies-table">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200">
                                <th class="px-4 py-3 text-left text-sm font-medium text-black">Name</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-black">Slug</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-black">Users</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-black">Short URLs</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-black">Created</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($companies as $company)
                            <tr class="border-b border-gray-200 hover:bg-gray-50">
                                <td class="px-4 py-3 font-semibold text-black">{{ $company->name }}</td>
                                <td class="px-4 py-3 text-black">{{ $company->slug }}</td>
                                <td class="px-4 py-3 text-black">{{ $company->users_count }}</td>
                                <td class="px-4 py-3 text-black">{{ $company->short_urls_count }}</td>
                                <td class="px-4 py-3 text-black">{{ $company->created_at->format('M d, Y') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-4 py-6 text-center text-gray-500">No companies created yet.</td>
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
            initializeDataTable('companies-table', {
                order: [[4, 'desc']],
                columnDefs: [
                    { orderable: false }
                ]
            });
        });
    </script>
    @endpush
</x-app-layout>