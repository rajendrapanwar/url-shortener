<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Invitations') }}
            </h2>
            <a href="{{ route('invitations.create') }}" 
               class="btn text-black border border-gray-300 px-4 py-2 rounded hover:bg-gray-100 text-sm font-medium">
                + Send New Invitation
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

                    <table class="w-full border border-gray-200" id="invitations-table">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200">
                                <th class="px-4 py-3 text-left text-sm font-medium text-black">Email</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-black">Role</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-black">Company</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-black">Status</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-black">Invited By</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($invitations as $invitation)
                            <tr class="border-b border-gray-200 hover:bg-gray-50">
                                <td class="px-4 py-3 text-black">{{ $invitation->email }}</td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 rounded text-xs font-semibold
                                        {{ $invitation->role === 'admin' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }}">
                                        {{ ucfirst($invitation->role) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-black">{{ $invitation->company->name }}</td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 rounded text-xs font-semibold
                                        {{ $invitation->isAccepted() ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                        {{ $invitation->isAccepted() ? 'Accepted' : 'Pending' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-black">{{ $invitation->inviter->name }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-4 py-6 text-center text-gray-500">No invitations sent yet.</td>
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
            initializeDataTable('invitations-table', {
                order: [[4, 'desc']],
                columnDefs: [
                    { orderable: false }
                ]
            });
        });
    </script>
    @endpush
</x-app-layout>