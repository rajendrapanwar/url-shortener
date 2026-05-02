<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Short URL') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <form method="POST" action="{{ route('short-urls.store') }}">
                        @csrf

                        <div class="mb-4">
                            <label class="block text-black text-sm font-medium mb-2" for="original_url">
                                Original URL
                            </label>
                            <input type="url" name="original_url" id="original_url" required 
                                   class="border border-gray-300 rounded w-full py-2 px-3 text-black focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="https://example.com">
                            @error('original_url') 
                                <span class="text-red-500 text-sm">{{ $message }}</span> 
                            @enderror
                        </div>

                        <div class="flex items-center justify-between">
                            <button type="submit" 
                                    class="btn text-black border border-gray-300 px-6 py-2 rounded hover:bg-gray-100 text-sm font-medium">
                                Shorten
                            </button>
                            <a href="{{ route('short-urls.index') }}" 
                               class="text-gray-600 hover:text-gray-800 text-sm">
                                View All URLs
                            </a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>