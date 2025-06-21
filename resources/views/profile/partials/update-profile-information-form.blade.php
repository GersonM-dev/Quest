<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information, photo, and email address.") }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <!-- Profile Photo Upload & Preview -->
        <div class="flex flex-col items-center mb-6">
            <div x-data="{photoName: null, photoPreview: null}">
                <!-- Hidden File Input -->
                <input type="file" name="profile_photo" id="profile_photo" class="hidden"
                       accept="image/*"
                       x-ref="photo"
                       x-on:change="
                            photoName = $refs.photo.files[0].name;
                            const reader = new FileReader();
                            reader.onload = (e) => { photoPreview = e.target.result; };
                            reader.readAsDataURL($refs.photo.files[0]);
                       ">

                <!-- Preview or Current Photo -->
                <div class="mb-2">
                    <template x-if="photoPreview">
                        <img :src="photoPreview" class="w-24 h-24 rounded-full object-cover border-4 border-blue-200 shadow-lg" alt="Profile Preview">
                    </template>
                    <template x-if="!photoPreview">
                        <img src="{{ $user->profile_photo_url }}"
                             class="w-24 h-24 rounded-full object-cover border-4 border-blue-200 shadow-lg"
                             alt="Profile Photo">
                    </template>
                </div>

                <!-- Upload Button -->
                <button type="button"
                        class="inline-block px-4 py-2 bg-blue-600 text-white rounded-lg font-semibold shadow hover:bg-blue-700 transition"
                        x-on:click.prevent="$refs.photo.click()">
                    {{ __('Change Photo') }}
                </button>
                <span class="block mt-1 text-xs text-gray-400" x-text="photoName"></span>

                @if ($errors->has('profile_photo'))
                    <span class="block mt-2 text-red-500 text-xs">{{ $errors->first('profile_photo') }}</span>
                @endif
            </div>
        </div>

        <!-- Profile Fields -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>
        <div>
            <x-input-label for="kelas" :value="__('Kelas')" />
            <x-text-input id="kelas" name="kelas" type="text" class="mt-1 block w-full"
                :value="old('kelas', $user->kelas)" required autocomplete="off" />
            <x-input-error class="mt-2" :messages="$errors->get('kelas')" />
        </div>
        <div>
            <x-input-label for="no_absen" :value="__('No Absen')" />
            <x-text-input id="no_absen" name="no_absen" type="number" class="mt-1 block w-full"
                :value="old('no_absen', $user->no_absen)" required autocomplete="off" />
            <x-input-error class="mt-2" :messages="$errors->get('no_absen')" />
        </div>
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>

<!-- Alpine.js for photo preview (add at bottom or in your layout) -->
<script src="//unpkg.com/alpinejs" defer></script>
