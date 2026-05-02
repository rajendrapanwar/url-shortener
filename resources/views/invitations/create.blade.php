<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Invite User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <form method="POST" action="{{ route('invitations.store') }}">
                        @csrf

                        <div class="mb-4">
                            <label class="block text-black text-sm font-medium mb-2" for="email">
                                Email
                            </label>
                            <input type="email" name="email" id="email" required 
                                   class="border border-gray-300 rounded w-full py-2 px-3 text-black focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="user@example.com">
                            @error('email') 
                                <span class="text-red-500 text-sm">{{ $message }}</span> 
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-black text-sm font-medium mb-2" for="role">
                                Role
                            </label>
                            <select name="role" id="role" required 
                                    class="border border-gray-300 rounded w-full py-2 px-3 text-black focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                @if(auth()->user()->isSuperAdmin())
                                    <option value="admin">Admin</option>
                                @else
                                    <option value="admin">Admin</option>
                                    <option value="member">Member</option>
                                @endif
                            </select>
                            @error('role') 
                                <span class="text-red-500 text-sm">{{ $message }}</span> 
                            @enderror
                        </div>

                        @if(auth()->user()->isSuperAdmin())
                        <div class="mb-4">
                            <label class="block text-black text-sm font-medium mb-2" for="company_id">
                                Company
                            </label>
                            <select name="company_id" id="company_id" required 
                                    class="border border-gray-300 rounded w-full py-2 px-3 text-black focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Select Company</option>
                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                                @endforeach
                            </select>
                            @error('company_id') 
                                <span class="text-red-500 text-sm">{{ $message }}</span> 
                            @enderror
                        </div>
                        @endif

                        <div class="flex items-center justify-between">
                            <button type="submit" 
                                    class="btn text-black border border-gray-300 px-6 py-2 rounded hover:bg-gray-100 text-sm font-medium">
                                Send Invitation
                            </button>
                            <a href="{{ route('invitations.index') }}" 
                               class="text-gray-600 hover:text-gray-800 text-sm">
                                Cancel
                            </a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>