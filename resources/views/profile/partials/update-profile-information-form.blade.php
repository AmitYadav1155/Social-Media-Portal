<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>

        {{-- Add bio field --}}
        <div>
            <x-input-label for="bio" :value="__('Bio')" />
            <x-text-input id="bio" name="bio" type="text" class="mt-1 block w-full" :value="old('bio', $user->bio)" autocomplete="bio" />
            <x-input-error class="mt-2" :messages="$errors->get('bio')" />
        </div>

        {{-- Add contact field --}}
        <div>
            <x-input-label for="contact" :value="__('Contact Info')" />
            <x-text-input id="contact" name="contact" type="text" class="mt-1 block w-full" pattern="[0-9]{10}" maxlength="10" inputmode="numeric" :value="old('contact', $user->contact)" autocomplete="contact" />
            <x-input-error class="mt-2" :messages="$errors->get('contact')" />
        </div>

        {{-- Add profile picture upload --}}
        <div>
            <x-input-label for="profile_picture" :value="__('Profile Picture')" />
            <input id="profile_picture" name="profile_picture" type="file" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
            <x-input-error class="mt-2" :messages="$errors->get('profile_picture')" />

            @if ($user->profile_picture)
                <div class="mt-3">
                    <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile Picture" class="w-16 h-16 rounded-full">
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
