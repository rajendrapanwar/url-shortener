<x-guest-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Accept Invitation</h1>
        <p class="text-gray-600">
            You've been invited to join <strong class="text-gray-800">{{ $invitation->company->name }}</strong> 
            as <strong class="text-gray-800">{{ ucfirst($invitation->role) }}</strong>.
        </p>
    </div>

    <form method="POST" action="{{ route('invitations.accept.post', $invitation->token) }}">
        @csrf

        <!-- Name -->
        <div class="mb-4">
            <x-input-label for="name" value="Name" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" required autofocus 
                          placeholder="John Doe" />
            @error('name')
                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-4">
            <x-input-label for="password" value="Password" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required 
                          placeholder="••••••••" />
            @error('password')
                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="mb-4">
            <x-input-label for="password_confirmation" value="Confirm Password" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" 
                          name="password_confirmation" required placeholder="••••••••" />
        </div>

        <div class="flex items-center justify-end mt-6">
            <x-primary-button>
                {{ __('Create Account') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>